<?php

require_once 'handler.php';

class HelpHandler extends iActionHandler {

    public function canHandle($command) {
        return $command == "help";
    }

    public function handle($command) {
        $message = new Message();

        $message->addLine("---- List of commands ----");
		$message->addLine(" /about - amazing ascii art");
		$message->addLine(" /clear - clears the terminal");
        $message->addLine(" /help - this is what you've just used");
        $message->addLine(" /name {%your_name%} - sets your name in the chat room  (if no argument passed shows your current name)");
		$message->addLine(" /online - list of online users");
		$message->addLine("--------------------------");
        return $message;
    }

}

?>
