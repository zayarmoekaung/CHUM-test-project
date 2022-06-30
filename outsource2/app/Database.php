<?php
namespace App;

use Aws\DynamoDb\DynamoDbClient;
use Aws\DynamoDb\Marshaler;
use Aws\Sqs\SqsClient; 
use Aws\Exception\AwsException;
class Database{

    protected   $queUrl = array("https://sqs.us-east-1.amazonaws.com/342701055469/Regular",
                                "https://sqs.us-east-1.amazonaws.com/342701055469/Prior",
                                "https://sqs.us-east-1.amazonaws.com/342701055469/Immediate"); 
   
    

    public function __construct(){
       
    } 
    public function getClient(){
        $client = DynamoDbClient::factory(array(
            'credentials' => array(
                'key'    => 'AKIAU7SUTDXW5N77EVWS',
                'secret' => '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',
            ),
            'region'  => 'us-east-1'
        ));
        return $client;
    }
    public function getSqsClient(){
        $client = SqsClient::factory(array(
            'credentials' => array(
                'key'    => 'AKIAU7SUTDXW5N77EVWS',
                'secret' => '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',
            ),
            'region'  => 'us-east-1'
        ));
        
        return $client;
    }

    public function getMarshaler(){
        $marshaler = new Marshaler();
        return $marshaler; 
    }
   

    /**
     * Get the value of queUrl
     */ 
    public function getQueUrl()
    {
        return $this->queUrl;
    }
    public function guidv4()
    {
        $data = $data ?? random_bytes(16);
        assert(strlen($data) == 16);
    
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10
    
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
}
?>