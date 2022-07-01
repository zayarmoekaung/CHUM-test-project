Queue Administration System

Used frameworks and SDK/s
 - Symfony 
 - Simple MVC PHP Framework by gmaccario
 - AWS PHP SDK : AWS DynamoDb , AWS SQS



Configuration 
to setup on your server you may need to reconfigure the config.php

config/config.php

'URL_ROOT'      - you have to define the root directory of the project. default will be '/'
'URL_SUBFOLDER' - to define the subfolder for the url, can leave blank  if you are running the project at root directory.  

API 

Send Queue Message - POST 

{{baseUrl}}/sendqueue 
Body {
    "requesterId":{requesterId},
   
    "message":{Message},
    "priority":{requestId},
    "resultUrl":{resultUrl}
    
}

Response : {
    "RequestId": "18be2e80-6bd4-4e02-87ef-388e24c92ef6"
}


Get Status - GET

{{baseUrl}}/get_status/{RequestId}

Response : {
    "requestId": "{requestId}",
    "status": "{Status}"
}

Request Message - GET

{{baseUrl}}/req_queue/

Body: {
    "consumerId":"688688",
     "consumerType":"TypeA"
    }

Response : {
    "RequestId": "{requestId}",
    "Message": "{message}"
}    


Post Result - POST

{{baseUrl}}/post_result

Body : {
    "requestId":"{requestId}",
     "result":"{result}"
    
}

Response : 200 



