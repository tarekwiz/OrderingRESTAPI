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
		/*
		Testing
		*/
		$order = new ParseObject("Order");

		$order->set("total", 1337);
		$order->set("status", 1);

		$user = new ParseObject("Order");

		$user->set("username", 'tarek');
		$user->set("email", 'email@email.com');
		$user->set("firstname", 'tarek');
		$user->set("lastname", 'adel');
		$user->set("phone", '+123456');
		$user->save();
		$order->set('user', $user);
		$order->save();
		//echo 'New order created with objectId: ' . $order->getObjectId();
		//echo 'New user created with objectId: ' . $user->getObjectId();
	
		/*Testing END*/
		
		
	    $id = $request->getAttribute('id');	
		$query = new ParseQuery("Order");

		try {
			  $order = $query->get($order->getObjectId()); // should be $id instead of $order->getObjectID but im using it for testing
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
		
		/*
			Testing
		*/
		$order = new ParseObject("Order");

		$order->set("total", 1337);
		$order->set("status", 1);

		$user = new ParseObject("Order");

		$user->set("username", 'tarek');
		$user->set("email", 'email@email.com');
		$user->set("firstname", 'tarek');
		$user->set("lastname", 'adel');
		$user->set("phone", '+123456');
		$user->save();
		$order->set('user', $user);
		$order->save();
		//echo 'New order created with objectId: ' . $order->getObjectId();
		//echo 'New user created with objectId: ' . $user->getObjectId();
	
		/*
			Testing END
		*/
		
	    $id = $request->getAttribute('id');
		$query = new ParseQuery("Order");

		try {
			  $order = $query->get($order->getObjectId()); // should be $id instead of $order->getObjectID but im using it for testing
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
