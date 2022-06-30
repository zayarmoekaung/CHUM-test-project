<?php
namespace App\Controllers\ApiControllers;

use App\Models\Result;
use App\Database;
use Symfony\Component\Routing\RouteCollection;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

class ResultController{
    public function postResult(RouteCollection $routes){
        
        $data = json_decode(file_get_contents("php://input"));
        $db= new Database();
        $result = new Result($db);
        if ($result->PostResult($data)) {
            http_response_code(200);
            echo json_encode("Post Success");
        }else{
            http_response_code(500);
            echo json_encode("Post Failed");
        }
       
    }
}