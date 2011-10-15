<?php

/**
 * 
 *
 * @author Breeze
 */
class Model_CustomsMapper extends AbstractMapper {
    
    protected $_model_object_name = 'customs';
    
    protected $table_name = 'users';
        
    public function findByEmail($email) {
	$smtp = sqlsrv_query($this->db, "SELECT * from " . $this->table_name . " where name = '$email'");
	return sqlsrv_fetch_array( $smtp, SQLSRV_FETCH_ASSOC);
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
