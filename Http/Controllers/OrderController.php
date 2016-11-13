<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\Http\Requests;
use App\User;
use Illuminate\Support\Facades\Auth;
use Session;

class OrderController extends Controller
{
    public function getOrder($id)
	{
		$order = Order::find($id); //FIND THE ORDER
		
		if($order) //CHECK IF ORDER IS FOUND.
		{
			$user = $order->user; //GETS THE USER OF THE ORDER
			return response()->json(['status' => 'OK', 'order' => $order]); //RETURN JSON
		}
		else //IF ORDER IS NOT FOUND
		{
			return response()->json(['status' => 'NOT FOUND', 'order' => 'NULL']); //RETURN JSON
		}
	}
	public function cancelOrder($id)
	{
		$order = Order::find($id); // FIND THE ORDER
		if($order) // CHECK IF ORDER IS FOUND
		{
			if(!$order->status == 2) // CHECK IF ORDER IS NOT ALREADY CANCELED
			{
				$order->status = 2; //SET STATUS = 2 (CANCELED)
				$order->save(); //SAVE THE ORDER TO DATABASE
				return response()->json(['status' => 'OK', 'order' => $order]); //RETURNS STATUS = OK, with order details
			}
			else //IF ORDER IS ALREADY CANCELED
			{
				//RETURNS STATUS = ALREADY CANCELED, with order details
				return response()->json(['status' => 'ALREADY CANCELED', 'order' => $order]);
				
			}
			
		}
		else // IF ORDER IS NOT FOUND
		{
			return response()->json(['status' => 'NOT FOUND', 'order' => 'NULL']);
		}
	}
}
