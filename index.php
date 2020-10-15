<?php
//headers som sätter information om webbtjänsten
header("Content-Type: application/json; charset=UTF-8");
header("Acces-Control-Allow-Origin: *"); //Tillåter anrop ifrån alla domäner
header("Access-Control-Allow-Origin: POST, GET, DELETE, PUT"); //Bestämmer vilka metoder som webbtjänsten tillåter
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Access-Control-Allow-Origin, Authorization, X-Requested-with');

$method = $_SERVER['REQUEST_METHOD']; //Variabel för att lagra medskickad metod

switch ($method){
    case "GET":
        //Kod för get
        break;

    case "PUT" : 
        //Kod för put
        break;

    case "POST" :
        //Kod för post
        break;

    case "DELETE" :
        //Kod för delete
        break;
}