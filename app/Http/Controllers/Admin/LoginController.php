<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
           if(!is_null(Auth::user())){
               if (Auth::user()->hasRole("admin")) {
                   Redirect::route("admin.dashboard");
               }
           }
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        return view("admin.login");
    }

    public function loginAttempt(Request $request)
    {
        $mail = $request->post("email");
        $password = $request->post("password");
        if(Auth::attempt(['email' => $mail, 'password' => $password])) {
            return Redirect::route("admin.dashboard");
        }else {
            return Redirect::back()->withErrors(['msg' => 'Kullanıcı Yada Şifreniz Yanlış Lütfen Kontrol Ediniz..']);
        }
    }

    public function logout(Request $request)
    {
         if(Auth::logout()){
             Redirect::route("login");
         }
    }
}
