<?php
namespace App\Models;
class Result{
protected   $requestId;
protected   $result;
protected   $resultUrl;
protected   $qstatus;
protected   $db;
public function __construct($db){

   
    $this->db=$db;
   
}
public function PostResult($data){
    $this->requestId=$data->requestId;
    $this->result=$data->result;
    $this->findResultUrl();
    
    return $this->postData();
}

private function postData(){
    //code block to post to external server
    /* $data = array('result'=>$this->result);
    $postvars = http_build_query($data) . "\n";
    $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $this->resultUrl);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $postvars);

  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

  $server_output = curl_exec ($ch);

  curl_close ($ch); */
  $this->qstatus="Work done Successfully";
  $this->updateStatus();
    return true;
}
private function updateStatus(){
    $marshaler = $this->db->getMarshaler();
    $client = $this->db->getClient();
    $eav = $marshaler->marshalJson('
    {
    
     ":qstatus" : "'.$this->qstatus.'"
    }
    '); 
    $key = $marshaler->marshalJson('                                               
   {                                                                          
       "requestId" : "'.$this->requestId.'"
   }                                                                          
');
$params = [
  'TableName' => "request",
  'Key' => $key,
  'ExpressionAttributeValues' => $eav,
  'UpdateExpression' => 'SET  qstatus = :qstatus',
  'ReturnValues' => 'UPDATED_NEW'
];

try {
 $result = $client->updateItem($params);
    
     return true;
}
catch (DynamoDbException $e){
echo "Unable to update Item : \n";
}
  
  }
private function findResultUrl(){
    $dyndb = $this->db->getClient();
    $result = $dyndb->getItem(array(
        'ConsistentRead' => true,
        'TableName' => 'request',
        'Key'       => array(
            'requestId'   => array('S' => $this->requestId)
           
        )
    ));
   

    $this->resultUrl=$result['Item']['resultUrl']['S']; 

}

}