<?php

namespace App\Http\Controllers;


use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Symfony\Component\Console\Input\Input;


class LoginController extends Controller
{

    public function __construct()
    {

    }

    public function login(Request $request) {
        $response = array();
        $validatedData = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validatedData->fails()) {
            $response = array();
            $response['code'] = 201;
            $response['content'] = $validatedData->errors();

            return response($response, $response['code'])
                ->header('content-type', 'application/json');
        }

        $checkUser = User::where('email', '=', $request->email)->first();

        if(isset($checkUser)) {
            if (Hash::check($request->password,$checkUser->password)) {
                $response["code"] = 200;
                $response["status"] = "success";
                $response["message"] = "success";
                $response["content"] = $checkUser;
            } else {
                $response["code"] = 201;
                $response["status"] = "error";
                $response["message"] = "Invalid Password";
                $response["content"] = "";
            }

        } else {
            $response["code"] = 201;
            $response["status"] = "error";
            $response["message"] = "Invalid username or password";
            $response["content"] = "";
        }

        return response($response, $response["code"])
            ->header('Content-Type', "application/json");
    }
}