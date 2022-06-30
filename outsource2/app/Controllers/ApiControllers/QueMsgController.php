<?php
namespace App\Controllers\ApiControllers;

use App\Models\QueMsg;
use App\Database;
use Symfony\Component\Routing\RouteCollection;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

class QueMsgController{

    public function sendQueue( RouteCollection $routes)
	{   
        $data = json_decode(file_get_contents("php://input"));
        $db= new Database();
       
        $QueMsg = new QueMsg($db);
        $QueMsg->setValues($data);
      
        if($QueMsg->sendMsg()){
            http_response_code(200);
            echo json_encode(array("RequestId" => $QueMsg->getRequestId()));
        }

        
       

        
        
	}
    public function getStatus( $id,RouteCollection $routes){
       
        $db= new Database();
       
        $QueMsg = new QueMsg($db);
        $QueMsg->readOne($id);
      
        if($QueMsg->getRequestId() !=Null){
            $queArr = array(
                "requestId"=>$QueMsg->getRequestId(),
                "status"=>$QueMsg->getqstatus()
            );
            http_response_code(200); 
            echo json_encode($queArr);
        }else{
       
            http_response_code(404);
          
       
            echo json_encode(
                array("message" => "Request ID Not Found")
            );
        }   
    }

}