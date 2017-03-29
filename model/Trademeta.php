<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/model/MSQL.php');

//
// Менеджер пользователей
//
class Trademeta {
	private static $instance;	// экземпляр класса
	private $msql;				// драйвер БД

	//
	// Получение экземпляра класса
	// результат	- экземпляр класса MSQL
	//
	public static function Instance() {
		if (self::$instance == null)
			self::$instance = new Trademeta();
			
		return self::$instance;
	}

	//
	// Конструктор
	//
	public function __construct() {
		$this->msql = MSQL::Instance();
	}

	//
	// Авторизация
	// $login 		- логин
	// $password 	- пароль
	// $remember 	- нужно ли запомнить в куках
	// результат	- true или false
	//
	public function Login($login, $password, $remember = true) {
		// вытаскиваем пользователя из БД 
		$user = $this->GetByLogin($login);

		if ($user == null)
			return false;
		
		// проверяем пароль
		if ($user['pass'] != md5($password))
			return false;
				
		// запоминаем имя и md5(пароль)
		if ($remember)
		{
			$expire = time() + 3600 * 24 * 100;
			setcookie('login', $login, $expire);
			setcookie('pass', md5($password), $expire);
		}
				
		return true;
	}
	
	//
	// Выход
	//
	public function Logout() {
		setcookie('login', '', time() - 1);
		setcookie('pass', '', time() - 1);
		unset($_COOKIE['login']);
		unset($_COOKIE['pass']);
	}
	
	//
	// Получает пользователя по логину
	//
	public function GetByLogin($login) {
		$t = "SELECT * FROM users WHERE login = '%s'";
		$query = sprintf($t, $this->msql->getMsql()->real_escape_string($login));
		$result = $this->msql->Select($query);
		return $result[0];
	}

}
