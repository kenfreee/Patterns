<?php
	/*	
	=======================[SINGLETON]=======================
	Порождающий шаблон проектирования, гарантирующий, 
	что в однопроцессном приложении будет единственный 
	экземпляр некоторого класса.
	=========================================================
	*/
	final class Database
	{
		public static $id_map = array(); //Хранилище идентификаторов
		private $connection;
		public $check = false;
		
		//Все магические методы закрыты для обеспечения существования только одного экземпляра.
		private function __clone(){}
		private function __sleep(){}
		private function __wakeup(){}

		private function __construct() {
			$this->connection = new mysqli("127.0.0.1", "root", "", "test");
		}
		
		//Единственный способ получить объект - воспользоваться статическим методом.
		public static function get_instance($id) {
			//Метод проверяет существует ли переданный идентификатор, если нет - создается новый объект, если да - возвращается созданный ранее объект.
			return array_key_exists($id, self::$id_map)	? 
						self::$id_map[$id] : self::$id_map[$id] = new Database();
		}
	}
	
	//$obj1 и $obj2 - есть ни что иное, как ссылка на один и тот же объект.
	$obj1 = Database::get_instance(1001);
	$obj2 = Database::get_instance(1001);
	$obj2->check = true;

	$obj3 = Database::get_instance(1002);

 	print_r(Database::$id_map);