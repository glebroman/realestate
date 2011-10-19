<?php

/**
 * 
 *
 * @author Breeze
 */
class Controller_Messages Extends AbsctractController {

    public function __construct() {
	parent::__construct();
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
	
	$table = $this->registry->config->sets['db']['prefix'] . '$' . 'Customer Notification';
	$where = ' and t."Customer Code"='."'".$this->registry->user['id']."'";
	$paginator = new Paginator ( $table, $where );
//	$paginator::setDefaultItemCountPerPage(15);
	$paginator->setCurrentPageNumber($this->registry->router->getRequest('page') ? $this->registry->router->getRequest('page') : 1);
//	$paginator->setItemCountPerPage(7);
	$this->registry->template->set('paginator', $paginator);
	$this->registry->template->show('messages/input');
    }
}