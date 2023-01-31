<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserHandler;


class PagesController extends Controller
{
    /**
     * Home page that contains the form
     *
     * @param  Request  $request
     * @return void
     */
    public function home(Request $request)
    {
        return view('welcome');

    }

    /**
     * Form POST request
     *
     * @param  Request  $request
     * @return void
     */


    public function register(Request $request)
    {   
        $register = new UserHandler();
        $register->setRegisterParam([$request->all()]);
        $result = $register->registerUser();
        if ($result == true) {
            return response()->json($result);
        } else {
            return response()->json($result); 
        }

    }

     public function login(Request $request)
     {   
         
         $login = new UserHandler();
         $login->setLoginParam([$request->all()]);
         $result = $login->loginUser();
         if ($result == true) {
             return response()->json($result);
         } else {
             return response()->json($result); 
         }
 
     }

    /**
     * Confirmation Page
     *
     * @param  Request  $request
     * @return void
     */
    public function confirmation(Request $request)
    {
        $register = new UserHandler();
        $allowedEntry = $register->confirmEntry();
        if ($allowedEntry == true) {
            return response()->json($allowedEntry);
        } else {
            return response()->json($allowedEntry);
        }
       
    }

    public function processUser() {

    }
}
