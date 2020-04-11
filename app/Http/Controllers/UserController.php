<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\HelperService;
use Validator;
use Auth;
use App\Classes;
use Session;
use App\AcademicYearHistory;

class UserController extends Controller{
    
    /**
     * load js and service helper
     *
     * @param HelperService $helperService
     */
    public function __construct(HelperService $helperService){
        header('Access-Control-Allow-Origin', '*');
        $this->helperService = $helperService;
        $this->data['js'] = array('login');
    }

    // renders login page
    public function index(){
                
        return view('login',$this->data);
    }

    /**
     * authenticate user
     *
     * @param Request $request
     * @return Illuminate\Http\RedirectResponse
     */
    public function processLogin(Request $request){
        info('login process starts');
        $email     = $request->email;
        $password  = $request->password;
        $validator = Validator::make(request()->input(), [
             'email' => 'required',
             'password' => array('required','min:8')
        ]);

        if ($validator->fails()){
            info('login validation request Failed');        
            foreach ($validator->errors()->all() as $key => $value){
                return redirect()->back()->with('error',$value);
            }
        }

        //Check user credentials corresponding given email and password
        if (Auth::attempt(['email' => $email, 'password' => $password])){    
            info('user validated successfully');
            Session::put('user_id', Auth::user()->id);
            Session::put('user_name', Auth::user()->name);
            Session::put('user_email',   Auth::user()->email);

            info('redirecting user to dashboard');
            
            if(Auth::check() && Auth::user()->is_active!="1")
                return redirect()->back()->with('error','Sorry your account is not active. Please contact admin.');

            // Authentication passed...
            if (Auth::check()){
                return redirect()->route('dashboard');
            }
        }
        else{
            return redirect()->back()->with('error','Email or Password is Incorrect');
        }
    }


    public function dashboard(){
        return view('dashboard');
    }

    public function logout(){
        Session::flush();
        Auth::logout();
        return redirect('/');
    }
}
