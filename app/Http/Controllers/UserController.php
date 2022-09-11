<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function __construct(private UserService $userService)
    {
        
    }

    public function login():Response{
        return response()->view("users.login", ["title" => "Login Page"]);
    }

    public function doLogin(Request $request):Response|RedirectResponse{
        $username = $request->input("user");
        $password = $request->input("password");

        if(empty($username) || empty($password)){
            return response()->view("users.login", [
                "title" => "Login",
                "error" => "Username and Password is required"
            ]);
        }

        if($this->userService->login($username, $password)){
            $request->session()->put("user", $username);
            return redirect("/");
        }

        return response()->view("users.login", [
            "title" => "Login",
            "error" => "Username or Password is wrong"
        ]);
    }

    public function logout(Request $request):RedirectResponse{
        $request->session()->forget("user");
        return redirect("/");
    }
}
