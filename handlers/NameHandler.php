<?php

class NameHandler extends iActionHandler {

    public function canHandle($command) {
        return preg_match("/^name (.*)/", $command) || $command == 'name';
    }

    public function handle($command) {
        if (preg_match("/^name ([a-zA-Z]{3,16})$/", $command, $matches)) {
            $name = $matches[1];
            $sessionId = $this->sessionId;
            $this->mysqli->query("update `online` set `name`='$name' where `session_id` = '$sessionId'");
            $message = new Message();
            $message->addLine("Name changed to $name");
            return $message;
        }
        elseif ($command == 'name') {
            $sessionId = $this->sessionId;
            $res = $this->mysqli->query("select `name` from `online` where `session_id` = '$sessionId'");
            $message = new Message();
            if ($row = $res->fetch_assoc()) {
                if (!empty($row['name'])) {
                    $message->addLine("Your name: ".$row['name']);
                } else {
                    $message->addLine("Name is not set");
                }
            } else {
                $message->addLine("Name is not set");
            }
            return $message;
        }else{
			$message = new Message();
			$message->addLine("Name can contain only latin letters (3-16)");
			return $message;
		}
    }

}

?>
