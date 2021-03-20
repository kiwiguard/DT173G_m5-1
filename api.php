<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
/*
 --------------------------------------------------------------------------------------------------------------------------
 | ID (int, AI, primary key) | name (Varchar(64))| code (Varchar(64)) | progression (Varchar(1)) | syllabus (Varchar(512)) 
 --------------------------------------------------------------------------------------------------------------------------

 Request:
 Methods - http://localhost/DT173G_m5-1/api
 Methods - https://dt173g.susanne-nilsson.se/src/api.php
 */
 //includes
require 'classes/database.class.php';
require 'classes/courses.class.php';

//headers
header('Content-Type: application/json; charset=UTF-8');
header('Acces-Control-Allow-Origin: *'); //Tillåter anrop ifrån alla domäner
header('Access-Control-Allow-Origin: POST, GET, DELETE, PUT'); //Bestämmer vilka metoder som webbtjänsten tillåter
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Access-Control-Allow-Origin, Authorization, X-Requested-With');

//set variable for request method
$method = $_SERVER['REQUEST_METHOD']; //Variabel för att lagra medskickad metod

//If an ID i sent in URL
if(isset($_GET['id'])) {
    $id = $_GET['id'];
}

// db connection
$database = new Database();
$db = $database->connect();

//set new instance of Courses class
$c = new Courses();

//Switch statement returns different data based on type of method
switch ($method){

    case 'GET': //Get stored classes from database
        if(isset($id)){
            $result = $c->readOne($id);
        } else {
            $result = $c->read();
            if (count($result) > 0) {
                http_response_code(200); //OK
            } else {
                http_response_code(404); //Not found
                $result = array('message' => 'No courses found.'); //Error message
            }
        }
        break;

    case 'POST' : // add post to db
        $d = json_decode(file_get_contents('php://input'));

        $c->name = $d->name;
        $c->code = $d->code;
        $c->progression = $d->progression;
        $c->syllabus = $d->syllabus;

        if($c->addCourse()) {
            http_response_code(200); //OK
            $result = array('message' => 'Post added.'); //Success message
        } else {
            http_response_code(503); //Not found
            $result = array('message' => 'Could not add post.'); //Error message
        }

    break;

    case 'PUT' : 
        if(!isset($id)) {
            http_response_code(510); 
            $result = array('message' => 'No id sent');
        } else {
            $d = json_decode(file_get_contents('php://input'));

            $c->name = $d->name;
            $c->code = $d->code;
            $c->progression = $d->progression;
            $c->syllabus = $d->syllabus;

            if ($c->updateCourse($id)) {
                http_response_code(200); //OK
                $result = array('message' => 'Course updated.');
            } else {
                http_response_code('503');
                $result = array('message' => 'Error updating course.'); //Error message
        } 
    }
    break;

    case 'DELETE' : //Delete course from database
        if(!isset($id)) {
            http_response_code(510);
            $result = array("message" => "No ID was sent");
        }else {
            if ($c->deleteCourse($id)) {
                http_response_code(200); //OK
                $result = array('message' => 'Course deleted.');
            } else {
                http_response_code('503');
                $result = array('message' => 'Error deleting course.'); //Error message
            }
        }
    break;
}

//Return result in JSON-format
echo json_encode($result);