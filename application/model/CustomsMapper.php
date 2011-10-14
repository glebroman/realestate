<?php

/**
 * 
 *
 * @author Breeze
 */
class Model_CustomsMapper {
    
    protected $table_name = 'customs';
    protected $db = NULL;
    
    /**
     * Конструктор
     * @param $db дескриптор базы данных
     */
    public function __construct($db) {
	$this->db = $db;
    }
    
    /**
     * Извлечение информации о пользователе по id пользователя
     * @param integer $id
     * @param boolean $use_md5 optional
     * @return object дескриптор состояния 
     */
    public function findById($id, $use_md5=FALSE) {
	$col = $use_md5 ? 'md5(id)' : 'id';
	$smtp = $this->db->query("SELECT * from customs where $col = '$id'");
	return $smtp->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Извлечение информации о пользователе по E-mail
     * @param string  $email
     * @return object дескриптор состояния 
     */
    public function findByEmail($email) {
	$smtp = $this->db->query("SELECT * from customs where email = '$email'");
	return $smtp->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Вставка, редактирование пользователя
     * @param Model_Customs $user
     * @return integer 
     */
    public function save(Model_Customs $user) {
        $data = array();
	foreach ($user->toArray() as $prop_name => $prop_val)
	    if (!is_null($prop_val))
		$data[$prop_name] = $prop_val;
	if (!$id = $user->getId()) {
            unset($data['id']);
	    $smtp = $this->db->prepare("INSERT INTO `customs` (nickname, password, email, family, phone, city, adress, description, category, lockout) value (:nickname, md5(:password), :email, :family, :phone, :city, :adress, :description, :category, :lockout)");
	    $smtp->execute($data);
	    return $this->db->lastInsertId();
	} else {
	    $smtp = $this->db->prepare("UPDATE `customs` SET id=:id, nickname=:nickname, password=:password, email=:email, family=:family, phone=:phone, city=:city, adress=:adress, description=:description, category=:category, lockout=:lockout where id=:id");
	    return $smtp->execute($data);
	}
    }
    
}
