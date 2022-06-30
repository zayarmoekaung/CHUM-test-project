<?php 

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

// Routes system
$routes = new RouteCollection();
$routes->add('homepage', new Route(constant('URL_SUBFOLDER') . '/', array('controller' => 'PageController', 'method'=>'indexAction'), array()));
$routes->add('sendqueue', new Route(constant('URL_SUBFOLDER') . '/sendqueue', array('controller' => 'Apicontrollers\QueMsgController', 'method'=>'sendQueue')));
$routes->add('getstatus',new Route(constant('URL_SUBFOLDER') . '/get_status/{id}',array('controller'=>'Apicontrollers\QueMsgController','method'=>'getStatus')));
$routes->add('getqueue', new Route(constant('URL_SUBFOLDER') . '/req_queue', array('controller' => 'Apicontrollers\QueReqController', 'method'=>'getQueueReq')));
$routes->add('postresult', new Route(constant('URL_SUBFOLDER') . '/post_result', array('controller' => 'Apicontrollers\ResultController', 'method'=>'postResult')));
