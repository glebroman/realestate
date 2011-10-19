<?php

/**
 * 
 *
 * @author Breeze
 */
class Controller_Index Extends AbsctractController {

    public function __construct() {
	parent::__construct();
	if (!isset($_SESSION['user_data'])) {
	    header('Location: ' . $this->registry->url . '/login');
	    exit;
	} else
	    $this->registry->user = $_SESSION['user_data'];
    }
    
    public function index() {
	$users = new Model_CustomsMapper($this->registry->db);
	$user = $users->findByField('No_', $this->registry->user['id']);
	$this->registry->template->set('user', iconv("cp1251", "UTF-8", $user->getName()));
	$this->registry->template->show('index');
    }
}

