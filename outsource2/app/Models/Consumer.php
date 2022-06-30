<?php
namespace App\Models;

class Consumer{

    protected   $consumerId;
    protected   $consumerType;
    
    public function __construct($db){
        $this->database = $db;
    }


    /**
     * Get the value of consumerId
     */ 
    public function getConsumerId()
    {
        return $this->consumerId;
    }

    /**
     * Set the value of consumerId
     *
     * @return  self
     */ 
    public function setConsumerId($consumerId)
    {
        $this->consumerId = $consumerId;

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
}

?>