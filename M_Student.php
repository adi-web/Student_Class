<?php
/**
 * 
 *
 * @author Admir Mucaj
 *   
 */
//$pathArray = explode('/', $_SERVER['REQUEST_URI']);
$requestMethod = $_SERVER["REQUEST_METHOD"];
$pathArray = explode('/', $_SERVER['REQUEST_URI']);
//echo 'id: '.$pathArray[3]; // <---- qui c'è il parametro*/
//echo  $_SERVER["REQUEST_METHOD"];
include('C:\xampp\htdocs\jquery\Student.php');

$student = new Student();
switch($requestMethod) {
  case 'GET':

		$id = '';	
		if(!empty($pathArray[3])) {
    
			$id =$pathArray[3];
			$student->_id = $id;
	
		
			$data = $student->list();
		}
		if(!empty($data)) {
          $js_encode = json_encode(array('status'=>true, 'studentInfo'=>$data), true);
        } else {
          $js_encode = json_encode(array('status'=>FALSE, 'message'=>'There is no record yet.'), true);
        }
        header('Content-Type: application/json');
		echo $js_encode;
		break;
    
    case 'POST':
        
      $obj=json_decode(file_get_contents("php://input"),true);
      $student->_name =$obj['name'];
      $student->_surname=$obj['surname'];
      $student->_sidiCode=$obj['sidiCode'];
      $student->_taxCode=$obj['taxCode'];
        $dataI=$student->insert();
        if($dataI==1)
        {
            $id=$student->ultimoID();
           
            $student->_id=$id;
            $data=$student->one();

            if(!empty($data)) {
                //echo "hai inserito <br>";
                $js_encode = json_encode(array('status'=>TRUE, 'studentInfo'=>$data), true);
              } else {
                $js_encode = json_encode(array('status'=>FALSE, 'message'=>'There is no record yet.'), true);
              }
              header('Content-Type: application/json');
              echo $js_encode;
        }
      break;
    case 'DELETE':
        if(!empty($pathArray[3]))
        {
          $id = '';	
         // echo $_GET['id'];
          $id = $pathArray[3];
          $student->_id =$id;
          $data=$student->one();

          if(!empty($data)) {
            

          $result=$student->delete();
          $js_encode = json_encode(array('status'=>TRUE, 'studentInfo'=>"ok"), true);
          echo $js_encode;
          }
          else
          {
            $js_encode = json_encode(array('status'=>FALSE, 'studentInfo'=>"not"), true);
          echo $js_encode;
          }
        }
        break;

        
    case 'PUT':
      
      $obj=json_decode(file_get_contents("php://input"),true);

  
      if(!empty($obj['id']))
      {
        $student->_id =$obj['id'];
        if(!empty($obj['name']))
        { 
          $student->_name =$obj['name'];
       
        }
        else
        {
          
          $student->_name="null";
        }
        if(!empty($obj['surname']))
        {
          $student->_surname=$obj['surname'];
        }
        else
        {
          $student->_surname="null";
        }
        if(!empty($obj['sidiCode']))
        {
          $student->_sidiCode=$obj['sidiCode'];
        }
        else
        {
          $student->_sidiCode="null";
        }
        if(!empty($obj['taxCode']))
        {
          $student->_taxCode=$obj['taxCode'];
        }
        else
        {
          $student->_taxCode="null";
        }
        $data=$student->one();
      }
      else
      {
        $js_encode = json_encode(array('status'=>false, 'studentInfo'=>"non modificato"), true);
        echo $js_encode;
      }
     
      if(!empty($data)) 
      {
        $student->put();
        $js_encode = json_encode(array('status'=>TRUE, 'studentInfo'=>"Inserito"), true);
        echo $js_encode;
      } else
      {
        $js_encode = json_encode(array('status'=>false, 'studentInfo'=>"non modificato"), true);
        echo $js_encode;
      }
    
        break;
    default:
	    header("HTTP/1.0 405 Method Not Allowed");
	    break;
}
?>	