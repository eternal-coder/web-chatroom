<?php

require_once ("Shard.php");

class Line{
	public $shards;
	
	public function addShard($text, $color = null) {
		$shard = new Shard();
		$shard->text = $text;
		$shard->color = $color;
        $this->shards[] = $shard;
    }
	
}

?>