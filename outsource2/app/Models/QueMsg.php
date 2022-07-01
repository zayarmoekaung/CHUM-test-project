<?php
namespace App\Models;

class QueMsg{
    protected   $requestId;
    protected   $requesterId;
    protected   $consumerId;
    protected   $consumerType;
    protected   $message;
    protected   $qstatus;
    protected   $priority;
    protected   $resultUrl;
    protected   $dyndb;
    protected   $sqs;
    protected   $db;
    public function __construct($db){

        $dyndb = $db->getClient();
        $sqs    =$db->getSqsClient();
        $this->db=$db;
        $this->dyndb = $dyndb;
        $this->sqs=$sqs;
    }

    /**
     * Get the value of requesterId
     */ 
    public function getrequesterId()
    {
        return $this->requesterId;
    }

    /**
     * Set the value of requesterId
     *
     * @return  self
     */ 
    public function setrequesterId($requesterId)
    {
        $this->requesterId = $requesterId;

        return $this;
    }
    /**
     * Get the value of requestId
     */ 
    public function getRequestId()
    {
        return $this->requestId;
    }

    /**
     * Set the value of requestId
     *
     * @return  self
     */ 
    public function setRequestId($requestId)
    {
        $this->requestId = $requestId;

        return $this;
    }

    /**
     * Get the value of message
     */ 
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set the value of message
     *
     * @return  self
     */ 
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get the value of qstatus
     */ 
    public function getqstatus()
    {
        return $this->qstatus;
    }

    /**
     * Set the value of qstatus
     *
     * @return  self
     */ 
    public function setqstatus($qstatus)
    {
        $this->qstatus = $qstatus;

        return $this;
    }

    /**
     * Get the value of priority
     */ 
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * Set the value of priority
     *
     * @return  self
     */ 
    public function setPriority($priority)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * Get the value of resultUrl
     */ 
    public function getResultUrl()
    {
        return $this->resultUrl;
    }

    /**
     * Set the value of resultUrl
     *
     * @return  self
     */ 
    public function setResultUrl($resultUrl)
    {
        $this->resultUrl = $resultUrl;

        return $this;
    }
     /**
     * Get the value of consumerType
     */ 
    public function getConsumerType()
    {
        return $this->consumerType;
    }

    /**
     * Set the value of consumerType
     *
     * @return  self
     */ 
    public function setConsumerType($consumerType)
    {
        $this->consumerType = $consumerType;

        return $this;
    }

    public function getAll(){
        $dyndb = $this->db->getClient();
        $iterator = $dyndb->getIterator('Scan', array(
            'TableName' => 'request',
            
        ));
        return $iterator;
    }
   public function SearchById($requestId){
   
    $dyndb = $this->db->getClient();
    $result = $dyndb->getItem(array(
        'ConsistentRead' => true,
        'TableName' => 'request',
        'Key'       => array(
            'requestId'   => array('S' =>$requestId)
           
        )
    ));
    
    return $result;
   }
   public function SearchByType($contype){
    $dyndb = $this->db->getClient();
    $iterator = $dyndb->getIterator('Scan', array(
        'TableName' => 'request',
        'ScanFilter' => array(
            'consumerType' => array(
                'AttributeValueList' => array(
                    array('S' => $contype)
                ),
                'ComparisonOperator' => 'CONTAINS'
            )
        )
    ));
    return $iterator;
   }
   public function SearchByStatus($qstatus){
    $dyndb = $this->db->getClient();
    $iterator = $dyndb->getIterator('Scan', array(
        'TableName' => 'request',
        'ScanFilter' => array(
            'qstatus' => array(
                'AttributeValueList' => array(
                    array('S' => $qstatus)
                ),
                'ComparisonOperator' => 'CONTAINS'
            )
        )
    ));
    return $iterator;
   }
    public  function setValues($data){
       
      $this->requesterId=$data->requesterId;
        
      $this->message=$data->message;
      $this->priority=$data->priority;
      $this->resultUrl=$data->resultUrl;
      $this->qstatus='Waiting for Consumer'; 
      $this->requestId = $this->db-> guidv4();
     
      
    }
    public function sendMsg(){
        
        $sqs    =$this->db->getSqsClient();
        $queueUrls = $this->db-> getQueUrl();
        
        switch ($this->priority) {
            case 'Regular':
                $this->queueUrl = $queueUrls[0];
                break;
            case 'Prior':
                $this->queueUrl = $queueUrls[1];
                break;
            case 'Immediate':
                $this->queueUrl = $queueUrls[2];
                break;    
            default:
            $this->queueUrl = $queueUrls[0];
                break;
        }
        
        $params = [
            'DelaySeconds' => 10,
            'MessageAttributes' => [
                "requesterId" => [
                    'DataType' => "String",
                    'StringValue' => $this->requesterId
                ],
                "requestId" => [
                    'DataType' => "String",
                    'StringValue' => $this->requestId
                ],
                "priority" => [
                    'DataType' => "String",
                    'StringValue' => $this->priority
                ],
                "resultUrl" => [
                    'DataType' => "String",
                    'StringValue' => $this->resultUrl
                ]

            ],
            'MessageBody' =>$this->message,
            'QueueUrl' => $this->queueUrl
        ];
        
        try {
            $result = $sqs->sendMessage($params);
           
           
           
        return $this->saveData();
        } catch (AwsException $e) {
            // output error message if fails
            error_log($e->getMessage());
        }
    }
    private function saveData(){
   
        $dyndb = $this->db->getClient();
        $result = $dyndb->putItem(array(
            'TableName' => 'request',
            'Item' => array(
                'requestId'      => array('S' => $this->requestId),
                'requesterId'   => array('S' => $this->requesterId),
                'consumerId'    => array('N'=>00000),
                'consumerType'    => array('S'=>"N/A"),
                'message'   => array('S' => $this->message),
                'priority'   => array('S' => $this->priority),
                'resultUrl'   => array('S' => $this->resultUrl),
                'qstatus'   => array('S' => $this->qstatus),
            )
        ));

       
        return $result;
    }
    public function readOne($id){
        
        $dyndb = $this->db->getClient();
        $result = $dyndb->getItem(array(
            'ConsistentRead' => true,
            'TableName' => 'request',
            'Key'       => array(
                'requestId'   => array('S' => $id)
               
            )
        ));
       

        $this->requestId=$result['Item']['requestId']['S']; 
        $this->qstatus=$result['Item']['qstatus']['S'];     
    } 
    public function toString(){
        
        return 0;
    }
   

    

   
}

