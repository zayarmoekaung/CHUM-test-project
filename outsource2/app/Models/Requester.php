<?php
namespace   App\Models;

class   Requester{
protected   $requesterId;
protected   $requesterName;

public function __construct($db){
    $this->database = $db;
}




/**
 * Get the value of requesterId
 */ 
public function getRequesterId()
{
return $this->requesterId;
}

/**
 * Set the value of requesterId
 *
 * @return  self
 */ 
public function setRequesterId($requesterId)
{
$this->requesterId = $requesterId;

return $this;
}

/**
 * Get the value of requesterName
 */ 
public function getRequesterName()
{
return $this->requesterName;
}

/**
 * Set the value of requesterName
 *
 * @return  self
 */ 
public function setRequesterName($requesterName)
{
$this->requesterName = $requesterName;

return $this;
}
}


?>