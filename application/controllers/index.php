<?php

/**
 * 
 *
 * @author Breeze
 */
class Controller_Index Extends AbsctractController {

    private function auth() {
	if (!isset($_SESSION['user_data'])) {
	    header('Location: ' . $this->registry->url . '/login');
	    exit;
	} else
	    $this->registry->user = $_SESSION['user_data'];
    }

    public function index() {
	//$this->auth();
	$this->registry->template->set('title', 'Главная страница');
	$this->registry->template->show('index');
    }
}

