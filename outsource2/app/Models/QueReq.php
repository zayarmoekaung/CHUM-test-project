<?php
namespace App\Models;
class   QueReq{

    protected   $requestId;
    protected   $consumerId;
    protected   $consumerType;
    protected   $qstatus;

    protected   $message;
    private     $queueUrl;
    private   $db;

    public function __construct($db){
        
        $this->db = $db;
    
    }

    /**
     * Set the value of consumerId
     *
     * @return  self
     */ 
    public function setData($data)
    {
        $this->consumerId = $data->consumerId;
        $this->consumerType = $data->consumerType;

        return $this;
    }
    

    public function pollOne(){
        $sqs = $this->db->getSqsClient();
        
        try {
           
            $result= $this->getresult($sqs);
            if (!empty($result->get('Messages'))) {
                $this->message= $result->get('Messages')['0']['Body'];
                $this->requestId= $result->get('Messages')['0']["MessageAttributes"]["requestId"]["StringValue"]; 
           $result = $sqs->deleteMessage([
                    'QueueUrl' => $this->queueUrl, // REQUIRED
                    'ReceiptHandle' => $result->get('Messages')[0]['ReceiptHandle'] // REQUIRED
                    
                ]);
              
            return $this->updateStatus();       
            } else {
             return false;   
            }
        } catch (AwsException $e) {
            // output error message if fails
            error_log($e->getMessage());
        }
        
    }
    private function getresult($sqs){
    $queueUrl = $this->db->getQueUrl();  
     for ($i=2; $i>=0 ; $i--) { 
       
        $this->queueUrl =$queueUrl[$i] ;
        $result = $sqs->receiveMessage(array(
            'AttributeNames' => ['SentTimestamp'],
            'MaxNumberOfMessages' => 1,
            'MessageAttributeNames' => ['All'],
            'QueueUrl' => $this->queueUrl , // REQUIRED
            'WaitTimeSeconds' => 0,
        ));
        if (!empty($result->get('Messages'))){
            return($result);
           }elseif ($i==0) {
            return($result);
           }
     }
       
       
    }
    private function updateStatus(){
      $marshaler = $this->db->getMarshaler();
      $client = $this->db->getClient();
      $eav = $marshaler->marshalJson('
      {
       ":consumerId" : '.$this->consumerId.',
       ":qstatus" : "Working on Consumer",
       ":consumerType" : "'. $this->consumerType .'"
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
    'UpdateExpression' => 'SET consumerId = :consumerId , consumerType = :consumerType ,  qstatus = :qstatus',
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

    /**
     * Get the value of requestId
     */ 
    public function getRequestId()
    {
        return $this->requestId;
    }

    /**
     * Get the value of message
     */ 
    public function getMessage()
    {
        return $this->message;
    }
}