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
		$mapper = new Model_CustomsMapper($this->registry->db);
		$user = $mapper->findByEmail(trim($_POST['username']));
		if (!$user) {
		    $errors[] = 'Такого пользователя нет в системе';
		} elseif ($user['password'] == $_POST['password']) {
		    $this->setStorage($user);
		    header('Location: ' . $this->registry->url . '/index');
		} else {
		    $errors[] = 'Неправильно введен пароль';
		}
	    }
	}
	$this->registry->template->set('errors', $errors);
	$this->registry->template->set('title', 'Вход в систему');
	$this->registry->template->show('login/login');
    }

    /**
     * Проверка POST - данных
     * @return array $errors 
     */
    private function checkRequested() {
	$errors = array();
	$email = trim($_POST['username']);
	$password = trim($_POST['password']);
	if (!$email || !$password)
	    $errors[] = 'Не заполнено обязательное поле';
	elseif (!filter_var($email, FILTER_VALIDATE_EMAIL))
	    $errors[] = 'Введен не верный E-mail';
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
	$data['id']	    = $user['id'];
	$data['name']	    = $user['name'];
	$_SESSION['user_data'] = $data;
    }
}
