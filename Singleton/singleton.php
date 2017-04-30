<?php
	/*	
	=======================[SINGLETON]=======================
	Порождающий шаблон проектирования, гарантирующий, 
	что в однопроцессном приложении будет единственный 
	экземпляр некоторого класса.
	=========================================================
	*/

	final class DB //Класс не сможет быть унаследован.
	{
		public $db, $check;

		private static $_ins = NULL;

		//Единственный способ получить объект - воспользоваться статическим методом.
		public static function get_instance() {
			//При первом обращении класс сам создаст экземляр и положит его в $_ins.
			//При след. обращениях метод будет возвращать тот же, ранее созданный, экземляр класса.
			if (self::$_ins instanceof self) {
				return self::$_ins;
			} else {
				return self::$_ins = new self;
			}
		}

		//Все магические методы закрыты для обеспечения существования только одного экземпляра.
		private function __clone(){}
		private function __sleep(){}
		private function __wakeup(){}
		
		private function __construct()
		{
			echo "<b>Connection to the database...</b>";
			@$this->db = new mysqli("127.0.0.1", "root", "", "test");

			if ($this->db->connect_errno) {
				echo "<b style='color: red;'> [BAD]</b><br>";
    			exit('Connect Error ('.$this->db->connect_errno.') '.$this->db->connect_error);
			} else echo "<b style='color: green;'> [GOOD]</b><br>";
		}

		public function get_data() 
		{
			$query = "SELECT * FROM users";

			$result = $this->db->query($query);
			if (!$result) exit('Error ('.$this->db->errno.') '.$this->db->error);

			$rows = $result->num_rows;

			echo "<pre>";
			for ($i=0; $i < $rows; ++$i) { 
				$row = $result->fetch_array(MYSQLI_ASSOC);
				print_r($row);
			}
			$result->close();
			echo "</pre>";
		}
	}

	//$obj = new DB; - запрещенно!
	$obj1 = DB::get_instance();
	$obj2 = DB::get_instance();
	//$obj1 и $obj2 - есть ни что иное, как ссылка на один и тот же объект.
	$obj1->check = 100000000;

	var_dump($obj1);
	var_dump($obj2);