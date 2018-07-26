<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function show(){
        if(Auth::check()){
            return redirect('dashboard');
        }
        return view('pages.login');
    }
    /**
     * Store the incoming blog post.
     *
     * @param  LoginFormRequest  $request
     * @return Response
    */
    public function log_in(Request $request){
        $validatedData = $request->validate([
            'username' => 'required|max:25',
            'password' => 'required|max:25',
        ]);
        if(!$validatedData){
            return redirect('login')->with('status', 'Oops! Incorrectly entered data!');
        }else{
            $userdata = array(
                'username'     => $request->get('username'),
                'password'  => $request->get('password')
            );

            // attempt to do the login
            if (Auth::attempt($userdata)) {
        
                // validation successful!
                // redirect them to the secure section or whatever
                // return Redirect::to('secure');
                // for now we'll just echo success (even though echoing in a controller is bad)
                return redirect('dashboard');
        
            } else {        
        
                // validation not successful, send back to form 
                return redirect('login')->with('status', 'Oops! User does not exist!');
        
            }
        }
    }
    public function logout(){
        if(Auth::check()){
            Auth::logout();
            Session::flush();
            return redirect('login'); // redirect the user to the login screen
        }
    }
}
