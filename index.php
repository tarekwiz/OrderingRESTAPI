<?php
require 'vendor/autoload.php';

use Parse\ParseObject;
use Parse\ParseQuery;
use Parse\ParseACL;
use Parse\ParsePush;
use Parse\ParseUser;
use Parse\ParseInstallation;
use Parse\ParseException;
use Parse\ParseAnalytics;
use Parse\ParseFile;
use Parse\ParseCloud;
use Parse\ParseClient;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


	ParseClient::initialize('tarek', '', 'tarek');
	ParseClient::setServerURL('http://localhost:1337', 'parse');
	$config = [
	    'settings' => [
	        'displayErrorDetails' => true,
	    ],
	];
	$app = new \Slim\App($config);
		

	
	
	
	
	
	$app->get('/getorder/orderId/{id}', function (Request $request, Response $response) {
		
	    	$id = $request->getAttribute('id');	
		$query = new ParseQuery("Order");

		try {
			  $order = $query->get($id);
			  $user  = $order->get("user");
			  $user->fetch();
			  $order = json_decode($order->_encode());
			  $response = $response->withJson($order);
	  		}
		catch (ParseException $ex) {
			if($ex->getCode() == 101) //OBJECT NOT FOUND ERROR CODE = 101
			{
					$result = array('objectId' => NULL, 'total' => NULL, 'status' => 'NOT FOUND');
					$response = $response->withJson($result);
			}
		}	
	    return $response;
	});
	

	$app->get('/cancelorder/orderId/{id}', function (Request $request, Response $response) {
		
	    	$id = $request->getAttribute('id');
		$query = new ParseQuery("Order");

		try {
			  $order = $query->get($id); 
			  
			  if($order->get('status') == 2)
			  {
				$result = array('objectId' => $order->getObjectId(), 'status' => 'Already Canceled');
				$response = $response->withJson($result);
				return $response;
			  }
			
			  $order->set('status', 2);
			  $order->save();
			
			  $order = json_decode($order->_encode()); // THIS LINE IS BECAUSE SLIM CAN'T ACCEPT ENCODED JSON, NEEDS TO BE PHP ARRAY OR OBJECT.
			  $response = $response->withJson($order);
			
	  		}
		catch (ParseException $ex) {
			if($ex->getCode() == 101) //OBJECT NOT FOUND ERROR CODE = 101
			{
					$result = array('objectId' => NULL, 'total' => NULL, 'status' => 'NOT FOUND');
					$response = $response->withJson($result);
			}
		}	
	    return $response;
	});
	
	
	
	$app->run();
?>
