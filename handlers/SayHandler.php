<?php

require_once 'handler.php';

class SayHandler extends iActionHandler {

    public function handle($command) {
        $name = $this->sessionId;
        $res = $this->mysqli->query("select * from `online` where `session_id` = '$this->sessionId'");
        if ($row = $res->fetch_assoc()) {
            if (!empty($row['name'])) {
                $name = $row['name'];
            }
        }
        $text = $command;
        $message = new Message();
        $message->add($name . ": ", 'E0E0E0');
        $message->add($text);
        $message->global = true;
        return $message;
    }

    public function canHandle($command) {
        return preg_match("/^say (.*)/", $command);
    }

}

?>
