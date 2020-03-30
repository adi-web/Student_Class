<?php
/**
 * 
 *
 * @author Admir Mucaj
 *   
 */
 
include("DBConnection.php");
class studentC 
{
    protected $db;
    public $_idStudent;
    public $_idclass;
   
 
    public function __construct() {
        $dbcon = new DBConnection();
        $this->db = $dbcon->returnConnection();//chiedere spiegazioni
    }

    public function insertCS() {
		try {
                
            $sql = 'INSERT INTO student_class (id_student,id_class) VALUES (:studente,:classe)';

    		$data = [
			    'studente'=> $this->_idStudent,
			    'classe'=> $this->_idclass,
			];
	    	$stmt = $this->db->prepare($sql);
	    	$stmt->execute($data);
			$status = $stmt->rowCount();
            return $status;
 
		} catch (Exception $e) {
    		die("errore insert ". $e);
		}
 
	}

}


?>