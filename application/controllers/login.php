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
		$user = $mapper->findByEmail( trim($_POST['username']) );
		/* проверяем в таблице админов*/
		if (!$user) {
		    $admins = new Model_AdminsMapper($this->registry->db);
		    $user = $admins->findByEmail( trim($_POST['username']) );
		}

		if (!$user) {
		    $errors[] = 'Такого пользователя нет в системе';
		} elseif ($user['password'] == md5($_POST['password'])) {
		    if (!$user['lockout']) {	
			$this->setStorage($user);
			if ($user['category']==1)
			    header('Location: ' . $this->registry->url . '/pictures');
			elseif ($user['category']==0)
			    header('Location: ' . $this->registry->url . '/gallery');
			elseif ($user['category']==9)
			    header('Location: ' . $this->registry->url . '/admin/customs');
		    } else {
			$errors[] = 'Неактивированный пользователь.<br />По всем ворпосам обращайтесь к администратору системы.';
			$_POST = array();
		    }
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
	if (!$email)
	    $errors[] = 'Не заполнено обязательное поле E-mail';
	elseif (!filter_var($email, FILTER_VALIDATE_EMAIL))
	    $errors[] = 'Введен не верный E-mail';
	if (!trim($_POST['password']))
	    $errors[] = 'Не заполнено обязательное поле Пароль';
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
	$data['nickname']   = $user['nickname'];
	$data['email']	    = $user['email'];
	$data['category']   = $user['category'];
	$_SESSION['user_data'] = $data;
    }
}
