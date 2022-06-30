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
			
		
		}else {
			$reqs = $QueMsg->getAll();
		}
		
        require_once APP_ROOT . '/views/home.php';
	}
}