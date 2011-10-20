<?php

/**
 * 
 *
 * @author Breeze
 */
class Model_Agreement extends AbstractModel {
    protected $_customer_no_;
    protected $_customer_2_no_;
    protected $_customer_3_no_;
    protected $_no_;
    protected $_agreement_date;
    protected $_agreement_type;
    protected $_status;
    protected $_description;
    protected $_external_agreement_no_;
    protected $_building_turn_code;
    protected $_house_code;
    protected $_object_of_investing;
    protected $_agreement_amount;
    protected $_payed;
    protected $_remainder;

    public function getStatus() {
	switch ($this->_status) {
	    case 0:
		return "В работе";
	    case 1:
		return "Подписан";
	    case 2:
		return "Изменение условий";
	    case 3:
		return "Регистрация ФРС";
	    case 4:
		return "Зарегистрирован ФРС";
	    case 5:
		return "Регистрация расторжения";
	    case 6:
		return "Зарегистрировано расторжение";
	    case 7:
		return "Расторгнут";
	}
    }
    
    public function getDescription() {
	return iconv("cp1251", "UTF-8", $this->_description);
    }


    public function getAgreementNo() {
	return iconv("cp1251", "UTF-8", $this->_external_agreement_no_);
    }
    
    public function getRemainder() {
	return $this->_agreement_amount - $this->_payed;
    }
    
}
