<?php
	class second_class
	{
		public $uploaded = false;
		
		public function __construct() {
			echo "This class is ".__CLASS__."<br>";
		}

		public function init() {
			$this->uploaded = true;
		}
	}