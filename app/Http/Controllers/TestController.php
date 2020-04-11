<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Redirect;
use App\Category;
use App\PositiveVibe;
use DB;


class TestController extends Controller{

	//it's constructor and it load js and mail service helper
    public function __construct(){
    }

    public function index(){
    	return view('category');
    }

    public function getPositiveVibes(){
        $positiveVibes = DB::table('positive_vibes')
            ->select('positive_vibes.id as positive_vibes_id','positive_vibes.name as positive_vibes_name','positive_vibes.category_id as category_id','positive_vibes.image','categories.name as category_name')
            ->join('categories', 'categories.id', '=', 'positive_vibes.category_id')
            ->get();
    	return view('positive-vibes',compact('positiveVibes'));
    }

    public function addCategory(Request $request){    
    	if(!empty($request->file('emoji_image'))){
	        $file = $request->file('emoji_image');
	        $destinationPath = public_path('positive-vibes');
	        $vendor_product_name = md5(time() . uniqid()) . '.' . $file->getClientOriginalExtension();
	        $file->move($destinationPath, $vendor_product_name);
        }
    }


}