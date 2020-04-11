<?php
namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Redirect;
use App\Order;


class BurgerController extends Controller{

	//it's constructor and it load js and mail service helper
    public function __construct(){
    }

    public function index(Request $request){
    	$order = new Order();
    	$order->ingredients = json_encode($request->input('ingredients'));
    	$order->price = $request->input('price');
    	$order->customerDetails = json_encode($request->input('customer'));
    	$order->deliveryMethod = $request->input('deliveryMethod');
    	$order->save();

		$success_data = array(
    		"status" => 1,
            "data"    => array()
    	);        			
    	return response()->json($success_data);
    			
    }

    public function getOrderDetails(){
    	$order = Order::find(1);

    	return response()->json($order);
    }



Product name : HP Laptop 15-da0xxx
Product number : 3FR23AV
Serial number : CND91644M2
Software build ID : 18WW2P5T601#SABA#DABA
Motherboard ID : 84A6
BIOS : F.21-07/25/2019
Keyboard revision : 80.43
Processor name : Intel(R) Core(TM) i7-8550U CPU @ 1.80GHz
}


