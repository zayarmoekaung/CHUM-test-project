<?php 

namespace App\Controllers;

use App\Models\QueMsg;
use App\Database;
use Symfony\Component\Routing\RouteCollection;

class PageController
{
    // Homepage action
	public function indexAction(RouteCollection $routes)
	{
		
		$db= new Database();
		$QueMsg = new QueMsg($db);
		
		
		if (isset($_POST ['requestId'])) {
			
			$reqs = $QueMsg->SearchById($_POST['requestId']);	
		    $keyword = "RequestId : " . $_POST['requestId'];	
		
		}elseif (isset($_POST ['qstatus'])) {
			$reqs = $QueMsg->SearchByStatus($_POST['qstatus']);
			$keyword = "Queue Status : " . $_POST['qstatus'];	
		}elseif (isset($_POST ['consumerType'])) {
			$reqs = $QueMsg->SearchByType($_POST['consumerType']);
			$keyword = "Consumer Type : " . $_POST['consumerType'];	
		} else {
			$reqs = $QueMsg->getAll();
		}
		
        require_once APP_ROOT . '/views/home.php';
	}
}