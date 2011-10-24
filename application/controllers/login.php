<?php

/**
 * 
 * 
 * @author Breeze
 */
class Controller_Login Extends AbsctractController {

    /**
     * Авторизация пользователя
     * @return void
     */
    public function index() {
	$errors = array();
	if (isset($_POST['username']) && isset($_POST['password'])) {
	    if (!$errors = $this->checkRequested()) {
		/* проверяем по таблице пользователей */
		$mapper = new Model_CustomsMapper();
		$user = $mapper->findByWebLogin(trim($_POST['username']));
		if (!$user) {
		    $errors[] = 'Такого пользователя нет в системе';
		} elseif ($user['Web Pwd'] == $_POST['password']) {
		    $this->setStorage($user);
		    header('Location: ' . $this->registry->url . '/index');
		} else {
		    $errors[] = 'Неправильно введен пароль';
		}
	    }
	}
	$this->registry->template->set('errors', $errors);
	$this->registry->template->show('login/login');
    }

    /**
     * Проверка POST - данных
     * @return array $errors 
     */
    private function checkRequested() {
	$errors = array();
	$login = trim($_POST['username']);
	$password = trim($_POST['password']);
	if (!$login || !$password)
	    $errors[] = 'Не заполнено обязательное поле'; 
	elseif (preg_match( '/[^0-9a-z]/i', $login )) 
	    $errors[] = 'Введен не верный Логин';
	return $errors;
    }
    
    /**
     * Выход их системы
     * @return void
     */
    public function logout() {
	unset($_SESSION['user_data']);
	header('Location: ' . $this->registry->url . '/login');
    }
    
    /**
     * Сохранение сессии
     * @return void
     */
    private function setStorage($user) {
	$data = array();
	$data['id']	    = $user['No_'];
	$data['Name']	    = $user['Name'];
	$data['NewMes']	    = 0;
	$_SESSION['user_data'] = $data;
    }
}
