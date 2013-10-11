<?php
require_once 'handler.php';

class AboutHandler extends iActionHandler{
    public function canHandle($command) {
        return $command == "about";
    }

    public function handle($command) {
        $message = new Message();
        $message->addLine("-----------------------------------------------------------------------------------------------------");
        $message->addLine("                ._____.   .__                            .___             __  .__               ");
        $message->addLine("  ________  _  _|__\\_ |__ |  |   _____________  ____   __| _/_ __   _____/  |_|__| ____   ____  ");
        $message->addLine(" /  ___/\\ \\/ \\/ /  || __ \\|  |   \\____ \\_  __ \\/  _ \\ / __ |  |  \\_/ ___\\   __\\  |/  _ \\ /    \\ ");
        $message->addLine(" \\___ \\  \\     /|  || \\_\\ \\  |__ |  |_> >  | \\(  <_> ) /_/ |  |  /\\  \___|  | |  (  <_> )   |  \\");
        $message->addLine("/____  >  \\/\\_/ |__||___  /____/ |   __/|__|   \\____/\\____ |____/  \\___  >__| |__|\\____/|___|  /");
        $message->addLine("     \\/                 \\/       |__|                     \\/           \\/                    \\/ ");
        $message->addLine("");
        $message->addLine("                                                                          California, 2013");
        $message->addLine("-----------------------------------------------------------------------------------------------------");
        return $message;
    }
}

?>
