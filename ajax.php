<?php

session_start();
session_write_close();
require_once 'config.php';
$mysqli = new mysqli(Config::dbhost, Config::dbuser, Config::dbpassword, Config::dbname);
$sessionId = $_POST['sessionId']; //session_id();

$time = time();
$res = $mysqli->query("SELECT * FROM `online` WHERE `session_id` = '$sessionId'");
if ($res->num_rows != 0) {
    $mysqli->query("UPDATE `online` SET `last_update` = '$time' WHERE `session_id` = '$sessionId'");
} else {
    $mysqli->query("INSERT INTO `online` (`session_id`,`last_update`) VALUES ('$sessionId', '$time')");
}

$count = 0;
$data = array();
$message = null;
$messageId = null;
while ($count < Config::timeout) {
    usleep(Config::step);
    $res = $mysqli->query("SELECT * FROM `message` WHERE `processed` = '0' AND `session_id` = '$sessionId'");
    if ($res->num_rows > 0) {
        $row = $res->fetch_assoc();
        $message = $row['message'];
        $messageId = $row['id'];
        $mysqli->query("UPDATE `message` SET `processed` = '1' WHERE `id` = '$messageId'");

        if (!empty($message)) {
            $data['result'] = 'success';
            $data['message'] = $message;
            break;
        }
    }


    $count+=Config::step;
}
if (empty($data['result'])) {
    $data['result'] = 'empty';
}
echo json_encode($data);
?>
