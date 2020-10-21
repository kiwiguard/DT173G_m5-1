<?php
//headers som sätter information om webbtjänsten
header("Content-Type: application/json; charset=UTF-8");
header("Acces-Control-Allow-Origin: *"); //Tillåter anrop ifrån alla domäner
header("Access-Control-Allow-Origin: POST, GET, DELETE, PUT"); //Bestämmer vilka metoder som webbtjänsten tillåter
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Access-Control-Allow-Origin, Authorization, X-Requested-With');

$method = $_SERVER['REQUEST_METHOD']; //Variabel för att lagra medskickad metod
if(isset($_GET['id'])) {
    $id = $_GET['id']; // Kontrollerar om id har skickats med i url, sparas i variabel id
}

//Initiate connection to database
$databse = new Database();
$db = $database->connect();

//Skapar instans av klassen för att skicka SQL-frågor till databasen
//Skickar med databasanslutningen som parameter
$c = new Courses($db);

switch ($method){
    case "GET": //Get stored classes from database
        if(isset($id)) {
            $response = $c->readOne($id); //Runs function to read course with matching id
        } else {
            $response = $c->read(); //If no id, read all courses
        }

        //Checks if query returns any data
        if(sizeof($response)>0) {
            http_response_code(200); //OK
        } else {
            http_response_code(400); //Not found
            $response = array("message" => "No courses found."); //Error message
        }
        break;

    case "PUT" : 
        if(!isset($id)) {
            http_response_code(510); //Not Extended
            $result = array('message' => 'No id sent');
        } else {
            $input = json_decode(file_get_contents('php://input'));
        }

        if ($c->updateCourse($input->name, $input->code, $input->progression, $input->syllabus)) {
                http_response_code(200); //OK
                $response = array('message' => "Course updated.");
        } else {
            http_response_code('500');
            $response = array('message' => 'Error updating course.'); //Error message
        }
        break;

    case "POST" : //Add course to database
        $input = json_decode(file_get_contents('php://input'));

        if($c->addCourse($input->name, $input->code, $input->progression, $input->syllabus)) {
            http_response_code(201); // Created
            $response = array("message" => "Courses updated.");
        } else {
            http_response_code(500);
            $response = array ("message" => "Error adding course."); //Error message
        }
        break;

    case "DELETE" : //Delete course from database
        if(!isset($id)) {
            http_response_code(510); //Not Extended
            $result = array('message' => 'No id sent');
        } else {
            //Run function to delete course
            if($c->deleteCourse($id)) {
                http_response_code(200); //Ok
                $response = array("message" => "Course deleted.");
            } else {
                http_response_code(500); //Server error
                $response = array("message" => "Error deleting course."); //Error message
            }
        }
        break;
}

//Return result in JSON-format
echo json_encode($respose);

//Close database connection
$db = $database->close();