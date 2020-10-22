<?php
/*
 --------------------------------------------------------------------------------------------------------------------------
 | ID (int, AI, primary key) | name (Varchar(64))| code (Varchar(64)) | progression (Varchar(1)) | syllabus (Varchar(512)) 
 --------------------------------------------------------------------------------------------------------------------------

 Request:
 Methods - http://localhost/moment5/api
 */

//headers
header('Content-Type: application/json; charset=UTF-8');
header('Acces-Control-Allow-Origin: *'); //Tillåter anrop ifrån alla domäner
header('Access-Control-Allow-Origin: POST, GET, DELETE, PUT'); //Bestämmer vilka metoder som webbtjänsten tillåter
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Access-Control-Allow-Origin, Authorization, X-Requested-With');

//includes
include 'config/config.php'; //this loads all classfiles

//set variable for request method
$method = $_SERVER['REQUEST_METHOD']; //Variabel för att lagra medskickad metod

//checks if id is sent
if(isset($_GET['id'])) {
    $id = $_GET['id'];
}

//set new instance of Courses class
$c = new Courses();

//Switch statement returns different data based on type of method
switch ($method){

    case 'GET': //Get stored classes from database
        $result = $c->read();
        if (count($result) > 0) {
            http_response_code(200); //OK
        } else {
            http_response_code(404); //Not found
            $result = array('message' => 'No courses found.'); //Error message
        }
        // if(!isset($id)) {
        //     $result = $c->read();
        // } else {
        //     $result = $c->readOne($id);
        // }

        // //Checks if query returns any data
        // if(count($result) > 0) {        
        //     http_response_code(200); //OK
        // } else {
        //     http_response_code(400); //Not found
        //     $result = array('message' => 'No courses found.'); //Error message
        // }

        break;

    case 'PUT' : 
        if(!isset($id)) {
            http_response_code(510); 
            $result = array('message' => 'No id sent');
        } else {
            $input = json_decode(file_get_contents('php://input'));
            if ($c->updateCourse($input->name, $input->code, $input->progression, $input->syllabus, $id)) {
                http_response_code(200); //OK
                $result = array('message' => 'Course updated.');
            } else {
                http_response_code('503');
                $result = array('message' => 'Error updating course.'); //Error message
        } 
    }
    break;

    case 'POST' : //Add course to database
        $input = json_decode(file_get_contents('php://input'));
        if($c->addCourse($input->name, $input->code, $input->progression, $input->syllabus)){
            http_response_code(200); //OK
            $result = array('message' => 'Course added');
        } else {
            http_response_code(503); //Not found
            $result = array('message' => 'Could not add course'); //Error message
        }
    break;

    case 'DELETE' : //Delete course from database
            $input = json_decode(file_get_contents('php://input'));
            if ($c->deleteCourse($id)) {
                http_response_code(200); //OK
                $result = array('message' => 'Course deleted.');
            } else {
                http_response_code('503');
                $result = array('message' => 'Error deleting course.'); //Error message
        }
    break;
}

//Return result in JSON-format
echo json_encode($result);