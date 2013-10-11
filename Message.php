<?php
require_once ("Line.php");

class Message {

    public $text;
    public $color;
    public $global = false;
    public $sessionId;
    public $lines = array();

    public function addLine($text, $color = null) {
		$line = new Line();
		$line->addShard($text, $color);
        $this->lines[] = $line;
    }
	
	public function add($text, $color = null){
		if(count($this->lines)>0){
			$line = $this->lines[count($this->lines) - 1];
			$line->addShard($text, $color);
		}else{
			$this->addLine($text, $color);
		}
	}

}

?>
