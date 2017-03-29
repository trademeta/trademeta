<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/config.php');
//
// Класс для работы с БД
//
class MSQL {
	private static $instance;	// экземпляр класса
	private $mysqli;

	//
	// Получение экземпляра класса
	// результат	- экземпляр класса MSQL
	//
	public static function Instance() {
		if (self::$instance == null)
			self::$instance = new MSQL();
			
		return self::$instance;
	}

	private function __construct() {
		$this->mysqli = new mysqli(MYSQL_HOSTNAME, MYSQL_USERNAME, MYSQL_PASSWORD, MYSQL_DBNAME);
		if ($this->mysqli->connect_errno) {
			echo "Не удалось подключиться к MySQL: " . $this->mysqli->connect_error;
		}else{
			$this->mysqli->query("SET NAMES 'utf8'");
		}
	}

	public function getMsql() {
		return $this->mysqli;
	}

	//
	// Выборка строк
	// $query    	- полный текст SQL запроса
	// результат	- массив выбранных объектов
	//
	public function Select($query) {
		$result = $this->mysqli->query($query);
		
		if (!$result)
			die($this->mysqli->connect_error);
		
		$arr = array();

		while( $row = $result->fetch_assoc() ){
			$arr[] = $row;
		}

		return $arr;				
	}
	
	// Вставка строки
	// $table 		- имя таблицы
	// $object 		- ассоциативный массив с парами вида "имя столбца - значение"
	// результат	- идентификатор новой строки
	//
	public function Insert($table, $object) {
		$columns = array();
		$values = array();

		foreach ($object as $key => $value)
		{
			$key = $this->mysqli->real_escape_string($key . '');
			$columns[] = $key;

			if ($value === null)
			{
				$values[] = 'NULL';
			}
			else
			{
				$value = $this->mysqli->real_escape_string($value . '');
				$values[] = "'$value'";
			}
		}

		$columns_s = implode(',', $columns);
		$values_s = implode(',', $values);

		$query = "INSERT INTO $table ($columns_s) VALUES ($values_s)";
		$result = $this->mysqli->query($query);

		if (!$result)
			die($this->mysqli->connect_error);

		return $this->mysqli->insert_id;
	}

	//
	// Изменение строк
	// $table 		- имя таблицы
	// $object 		- ассоциативный массив с парами вида "имя столбца - значение"
	// $where		- условие (часть SQL запроса)
	// результат	- число измененных строк
	//
	public function Update($table, $object, $where) {
		$sets = array();

		foreach ($object as $key => $value)
		{
			$key = $this->mysqli->real_escape_string($key . '');

			if ($value === null)
			{
				$sets[] = "$key=NULL";
			}
			else
			{
				$value = $this->mysqli->real_escape_string($value . '');
				$sets[] = "$key='$value'";
			}
		}

		$sets_s = implode(',', $sets);
		$query = "UPDATE $table SET $sets_s WHERE $where";
		$result = $this->mysqli->query($query);

		if (!$result)
			die($this->mysqli->connect_error);

		return $this->mysqli->affected_rows;
	}

	//
	// Удаление строк
	// $table 		- имя таблицы
	// $where		- условие (часть SQL запроса)
	// результат	- число удаленных строк
	//
	public function Delete($table, $where) {
		$query = "DELETE FROM $table WHERE $where";
		$result = $this->mysqli->query($query);

		if (!$result)
			die($this->mysqli->connect_error);

		return $this->mysqli->affected_rows;
	}
}
