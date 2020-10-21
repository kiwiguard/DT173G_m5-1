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
if(isset($_GET['id'])) {
    $id = $_GET['id']; // Kontrollerar om id har skickats med i url, sparas i variabel id
}

$database = new Database();
$db = $database->connect();

//set new instance of Courses class
$c = new Courses($db);

//Switch statement returns different data based on type of method
switch ($method){

    case 'GET': //Get stored classes from database
        $response = $c->read();
        //Checks if query returns any data
        if(count($response) > 0) {        
                if(isset($id)) {
                $response = $c->readOne($id); //Runs function to read course with matching id
            } else {
                $response = $c->read(); //If no id, read all courses
            }
            http_response_code(200); //OK
        } else {
            http_response_code(400); //Not found
            $response = array('message' => 'No courses found.'); //Error message
        }




        break;

    case 'PUT' : 
        if(!isset($id)) {
            http_response_code(510); //Not Extended
            $response = array('message' => 'No id sent');
        } else {
            $input = json_decode(file_get_contents('php://input'));
        }

        if ($c->updateCourse($input->name, $input->code, $input->progression, $input->syllabus)) {
                http_response_code(200); //OK
                $response = array('message' => 'Course updated.');
        } else {
            http_response_code('500');
            $response = array('message' => 'Error updating course.'); //Error message
        }
        break;

    case 'POST' : //Add course to database
        $input = json_decode(file_get_contents('php://input'));

        if($c->addCourse($input->name, $input->code, $input->progression, $input->syllabus)) {
            http_response_code(201); // Created
            $response = array('message' => 'Courses updated.');
        } else {
            http_response_code(500);
            $response = array ('message' => 'Error adding course.'); //Error message
        }
        break;

    case 'DELETE' : //Delete course from database
        if(!isset($id)) {
            http_response_code(510); //Not Extended
            $response = array('message' => 'No id sent');
        } else {
            //Run function to delete course
            if($c->deleteCourse($id)) {
                http_response_code(200); //Ok
                $response = array('message' => 'Course deleted.');
            } else {
                http_response_code(500); //Server error
                $response = array('message' => 'Error deleting course.'); //Error message
            }
        }
        break;
}

//Return result in JSON-format
echo json_encode($respose);

//Close database connection
$db = $database->close();