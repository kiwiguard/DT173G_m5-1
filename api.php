<?php
//headers som sätter information om webbtjänsten
header("Content-Type: application/json; charset=UTF-8");
header("Acces-Control-Allow-Origin: *"); //Tillåter anrop ifrån alla domäner
header("Access-Control-Allow-Origin: POST, GET, DELETE, PUT"); //Bestämmer vilka metoder som webbtjänsten tillåter
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Access-Control-Allow-Origin, Authorization, X-Requested-with');

$method = $_SERVER['REQUEST_METHOD']; //Variabel för att lagra medskickad metod



switch ($method){
    case "GET": //Get stored classes from database
        //Kod för get
        $response = $c->getCourse();
        if(sizeof($response)>0) {
            http_response_code(200); //OK
        } else {
            http_response_code(400); //Not found
            $response = array("message" => "No courses found."); //Error message
        }
        break;

    case "PUT" : 
        //Kod för put
        if($c->updateCourse($input['name'], $input['code'], $input['progression'], $input['syllabus'], $input['id'])) {
            http_response_code(200); //OK
            $response = array('message' => "Course updated.");
        } else {
            http_response_code('500');
            $response = array('message' => 'Error updating course.'); //Error message
        }
        break;

    case "POST" : //Add course to database
        //Kod för post
        if($c->addCourse($input['name'], $input['code'], $input['progression'], $input['syllabus'])) {
            http_response_code(201); // Created
            $response = array("message" => "Database updated.");
        } else {
            http_response_code(500);
            $response = array ("message" => "Error adding course."); //Error message
        }
        break;

    case "DELETE" :
        //Kod för delete
        if($c->deleteCourse($input['id'])) {
            http_response_code(200); //Ok
            $response = array("message" => "Course deleted.");
        } else {
            http_response_code(500); //Server error
            $response = array("message" => "Error deleting course."); //Error message
        }
        break;
}

//Returnerar resultat i JSON-format
echo json_encode($respose);