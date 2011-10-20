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
	$users = new Model_CustomsMapper();
	$data = $users->findByFields(array('No_' => $this->registry->user['id']));
	$user = new Model_Customs($data);
	$agreements = new Model_AgreementMapper();
	$items1 = $agreements->getAgreements();
	$investments = new Model_InvestmentMapper();
	$items2 = $investments->getPayments();
	$this->registry->template->set('user', $user->getName());
	$this->registry->template->set('agreements', $items1);
	$this->registry->template->set('payments', $items2);
	$this->registry->template->show('index');
    }

}

