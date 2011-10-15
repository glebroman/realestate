<?php

/**
 * 
 *
 * @author Breeze
 */
class Controller_Index Extends AbsctractController {

    public function __construct($registry) {
	parent::__construct($registry);
	if (!isset($_SESSION['user_data'])) {
	    header('Location: ' . $this->registry->url . '/login');
	    exit;
	} else
	    $this->registry->user = $_SESSION['user_data'];
    }
    
    public function index() {
	$users = new Model_CustomsMapper($this->registry->db);
	$user = $users->findById($this->registry->user['id']);
	$this->registry->template->set('user', $user->getName());
	$this->registry->template->show('index');
    }
}

