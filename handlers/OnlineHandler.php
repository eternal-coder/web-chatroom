<?php

class OnlineHandler extends iActionHandler {

    public function canHandle($command) {
        return $command == 'online';
    }

    public function handle($command) {
            $sessionId = $this->sessionId;
			$time = time()- 25; //25 sec timeout
            $res = $this->mysqli->query("select * from `online` where `last_update` > '$time'");
            $message = new Message();
			$message->addLine("---------- Online users -----------");
            while($row = $res->fetch_assoc()) {
				if(!empty($row['name'])){
					$message->addLine($row['name']);
				}else{
                    $message->addLine($row['session_id']);
				}
            } 
			$message->addLine("-----------------------------------");
            return $message;
    }

}

?>
