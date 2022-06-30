<?php

namespace App\Controllers\ApiControllers;

use App\Models\QueReq;
use App\Database;
use Symfony\Component\Routing\RouteCollection;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

class QueReqController{
public function getQueueReq( RouteCollection $routes){
    $db = new database();
    $QueReq = new QueReq($db);
    $data = json_decode(file_get_contents("php://input"));
        $QueReq->setData($data);
        
        if($QueReq->pollOne()){
            http_response_code(200);
            echo json_encode(array("RequestId" => $QueReq->getRequestId(),
                                    "Message" => $QueReq->getMessage() ));
        }else{
            http_response_code(404);
            echo json_encode("The Message Queues Are Empty");
        }

    
  
    
  
}

}
