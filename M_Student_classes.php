<?php

$requestMethod = $_SERVER["REQUEST_METHOD"];
include('C:\xampp\htdocs\jquery\stude_classes.php');
$studentC = new studentC();
switch($requestMethod) {

    case 'POST':
        $obj=json_decode(file_get_contents("php://input"),true);
        $studentC->_idStudent =$obj['student'];;
        $studentC->_idclass=$obj['class'];;
        $data=$studentC->insertCS();
        if($data==1)
        {
            
            $js_encode = json_encode(array('status'=>TRUE, 'studente_classe'=>"inserito"), true);
        }
        else
        {
            $js_encode = json_encode(array('status'=>TRUE, 'studente_classe'=>"Errore"), true);
        }
        header('Content-Type: application/json');
              echo $js_encode;


    break;
    default:
	    header("HTTP/1.0 405 Method Not Allowed");
	    break;
}

?>