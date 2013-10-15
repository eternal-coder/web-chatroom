<?php

session_start();
require_once 'config.php';
$mysqli = new mysqli(Config::dbhost, Config::dbuser, Config::dbpassword, Config::dbname);

foreach (scandir("handlers") as $filename) {
    $path = 'handlers/' . $filename;
    if (is_file($path)) {
        require_once $path;
    }
}


if (!empty($_POST['command']) && !empty($_POST['sessionId'])) {
    $command = $_POST['command'];
    $sessionId = $_POST['sessionId'];
    //handlers
    $handlers = array();
    $handlers[] = new NameHandler();
    $handlers[] = new AboutHandler();
    $handlers[] = new OnlineHandler();


    $sayHandler = new SayHandler();


    if ($command[0] == '/') {
        $command = substr($command, 1);
        foreach ($handlers as $handler) {
            if ($handler->canHandle($command)) {
                $handler->setSessionId($sessionId);
                $message = $handler->handle($command);
				$message->system = true;
                if ($message->global) {
                    sendGlobal($message);
                } else {
                    sendSingle($message, $sessionId);
                }
                exit(0);
            }
        }
    } else {
        $sayHandler->setSessionId($sessionId);
        $message = $sayHandler->handle($command);
        if ($message->global) {
            sendGlobal($message);
        } else {
            sendSingle($message, $sessionId);
        }
        exit(0);
    }

    //Defaul action for unknown commands
    $message = new Message();
    $message->addLine("Unknown command '$command'");
	$message->system = true;
    sendSingle($message, $sessionId);
}

function sendGlobal($message) {
    $mysqli = new mysqli(Config::dbhost, Config::dbuser, Config::dbpassword, Config::dbname);
    $stmt = $mysqli->prepare("INSERT INTO `message`(`session_id`,`message`) VALUES (?, ?)");
    $stmt->bind_param('ss', $onlineUserSessId, $json);

    $time = time() - 25; //25 sec timeout
    $res = $mysqli->query("SELECT * FROM `online` where `last_update` > '$time'");
    $json = json_encode($message);
    while ($row = $res->fetch_assoc()) {
        $onlineUserSessId = $row['session_id'];
        if (!$stmt->execute()) {
            error_log("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
        }
    }
}

function sendSingle($message, $sessionId) {
    $mysqli = new mysqli(Config::dbhost, Config::dbuser, Config::dbpassword, Config::dbname);
    $stmt = $mysqli->prepare("INSERT INTO `message`(`session_id`,`message`) VALUES (?, ?)");

    $stmt->bind_param('ss', $sessionId, $json);

    $json = json_encode($message);

    if (!$stmt->execute()) {
        error_log("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
    }
}

function saveCommand($command, $sessionId) {
    $mysqli = new mysqli(Config::dbhost, Config::dbuser, Config::dbpassword, Config::dbname);
    $stmt = $mysqli->prepare("INSERT INTO `command`(`session_id`,`command`) VALUES (?, ?)");
    $stmt->bind_param('ss', $sessionId, $command);
    if (!$stmt->execute()) {
        error_log("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
    }
}

?>
