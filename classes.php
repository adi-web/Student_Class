<?php
/**
 * 
 *
 * @author Admir Mucaj
 *   
 */
 
include("DBConnection.php");
class classes 
{
    protected $db;
    public $_id;
    public $_year;
    public $_section;
 
    public function __construct() {
        $this->db = new DBConnection();
        $this->db = $this->db->returnConnection();//chiedere spiegazioni
    }
 
    //insert ok
    public function insert() {
		try {

    		$sql = 'INSERT INTO class (year,section)  VALUES (:year, :section)';
    		$data = [
			    'year' => $this->_year,
			    'section' => $this->_section,
			   
			];
	    	$stmt = $this->db->prepare($sql);
	    	$stmt->execute($data);
			$status = $stmt->rowCount();
			//echo $status;
            return $status;
 
		} catch (Exception $e) {
    		die("errore insert ". $e);
		}
 
	}
	//ultimo id ok
   public function ultimoID()
   {
	   try
	   {
			$sql="SELECT max(id) as 'id' FROM class";
			$stmt = $this->db->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $result['id'];
 
	   }
	   catch (Exception $e) 
	   {
		die("get ultimo errore  ". $e);
	}
   }


    // stampa tutto ok
    public function list() {
    	try {
			
    		$sql = "SELECT class.* FROM fi_itis_meucci.class order by section" ;
		    $stmt = $this->db->prepare($sql);
 
		    $stmt->execute();
		    $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
		} catch (Exception $e) {
		    die("errore getAll". $e);
		}
    }

    // getOne ok
    public function one() {

		
    	try {
			
    		$sql = "SELECT * FROM class WHERE id=:id";
		    $stmt = $this->db->prepare($sql);
		    $data = [
		    	'id' => $this->_id
			];
		    $stmt->execute($data);
		    $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $result;
		} catch (Exception $e) {
		    die("errore getOne" . $e);
		}
    }
 
    //delete ok
	public function delete() 
	{
		try
		{
			$sql = "DELETE FROM student_class WHERE id_class=:id ";
			$stm = $this->db->prepare($sql);
			$data=[ 
				'id'=>$this->_id
			];

		$stm->execute($data);
			//echo $this->_id;
			$sql = "DELETE FROM class WHERE id=:id ";
			$stm = $this->db->prepare($sql);
			$data=[ 
				'id'=>$this->_id
			];

			$stm->execute($data);

            return "ok";
 
		} catch (Exception $e) {
    		die("errore delete ".$e);
		}
 
    }

    // put funziona
	public function put() 
	{
		try
		{
		$sql="UPDATE class SET year='$this->_year',section='$this->_section' WHERE id=:id";
		$data=[
			'id' => $this->_id
		];
		$stm=$this->db->prepare($sql);
        $stm->execute($data);
        return "PUT fatta";
		}
		catch(Exception $e)
		{
			die("errore put". $e);
		}
		
    }
 
}
?>