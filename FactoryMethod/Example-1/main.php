<?php
	interface GetClass {
		public static function load_class($classname);
	}

	class Factory implements GetClass {
		public static function load_class($classname) {
			$filename = __DIR__.DIRECTORY_SEPARATOR."classes".DIRECTORY_SEPARATOR.$classname.".php";
			if (file_exists($filename)) {
				include_once($filename);
				
				if (class_exists($classname)) {
					$object = new $classname();
					$object->init();

					return $object;
				}
			}
		}
	}

	$obj1 = Factory::load_class('first_class');
	print_r($obj1);

	$obj2 = Factory::load_class('second_class');
	print_r($obj2);