<?php

class SendMailer {

    protected $_from; // required
    protected $_to;  // required
    protected $_subject; // required
    protected $_text;
    protected $_from_name;

    public function __construct() {
	//
    }

    public function __set($key, $val) {
	$var = '_' . strtolower($key);
	$this->$var = $val;
	return;
    }

    public function __get($key) {
	$var = '_' . strtolower($key);
	if (!isset($this->$var)) {
	    throw new Exception('Invalid getter for [' . $var . '] property in [' . get_class($this) . ']');
	}
	return $this->$var();
    }

    /**
     * Присваеваем параметр from
     * @return string 
     */
    private function getFrom() {
	if (!empty($this->_from_name)) {
	    $from = $this->_from_name . " <" . $this->_from . ">";
	} else {
	    $from = $this->_from;
	}
	return $from;
    }

    /**
     * Собираем header письма
     * @return string - header письма
     */
    private function setHeader() {
	$from = $this->getFrom();
	return "From: $from\n"
		. "Reply-To: $from\n"
		. "Content-Type: text/html; charset=UTF-8\n"
		. "MIME-Version: 1.0\n"
		. "Content-Transfer-Encoding: 8bit \n"
		. "X-Mailer: PHP/" . phpversion() . "\n";
    }

    /**
     * Собираем subject письма
     * @return string - subject письма 
     */
    private function setSubject() {
	return "=?UTF-8?B?" . base64_encode($this->_subject) . "?=\n";
    }

    /**
     * Собираем письмо (шапка, футер, оформление)
     * @return string - текст письма
     */
    private function assemble_mail() {
	$text = '<center>';
	$text .= $this->_text;
	$text .= '</center>';
	return $text;
    }

    /**
     * Отправка сообщения
     * @return boolean 
     */
    public function send() {
	$body = $this->assemble_mail();
	return mail($this->_to, $this->setSubject(), $this->assemble_mail(), $this->setHeader(), "-f" . $this->_from);
    }

}
