<?php

/**
 * 
 *
 * @author Breeze
 */
class Controller_Messages Extends AbsctractController {

    public function __construct($registry) {
	parent::__construct($registry);
	if (!isset($_SESSION['user_data'])) {
	    header('Location: ' . $this->registry->url . '/login');
	    exit;
	} else
	    $this->registry->user = $_SESSION['user_data'];
    }

    public function index()
    {
	//
    }

    public function input() {
	$pages = 7;
	$page = intval($this->registry->router->getRequest('page'));
	$this->registry->template->set('page', ($page && $page<=$pages) ? intval($this->registry->router->getRequest('page')) : 1);
	$this->registry->template->set('pages', $pages);
	$this->registry->template->set('title', 'Входящие сообщения');
	$this->registry->template->show('messages/input');
    }
}


