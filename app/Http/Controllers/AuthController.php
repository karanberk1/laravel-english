<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\RegisterPostRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\LoginPostRequest;
use App\Models\user;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Nette\Utils\Json;
use Illuminate\Support\Facades\Hash;
use \Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $email = user::where('email', '=', $request->email)->get();
        $username = user::where('userName', '=', $request->username)->get();


        if ($username->first()) {
            return response()->json(["status" => "error", "message" => "username already use"], 400);
        }
        if ($email->first()) {
            return response()->json(["status" => "error", "message" => "email already use"], 400);
        }

        if ($request->password != $request->confirmpassword) {
            return response()->json(["status" => "error", "message" => "passwordler eşit değil"], 400);
        }


        $password = Hash::make($request->password);
        $user = new user;

        $user->userName = $request->username;
        $user->email = $request->email;
        $user->password = $password;

        $user->save();
        return response()->json(["status" => "ok"], 200);
    }

    public function login(LoginRequest $request)
    {
        $user = user::where('email', '=', $request->email)->get();
        if (!$user->first()) {
            return response()->json(["status" => false, "message" => "user not found"], 400);
        }
        $password = Hash::check($request->password, $user[0]->password);
        if (!$password) {
            return response()->json(["status" => false, "message" => "password is not correct"], 400);
        }

        $token = JWT::encode([
            'id' => $user[0]->id,
            'iat' => time(),
            "exp" => time() + 60 * 60 * 24
        ], env('JWT_SECRET'), 'HS256');

        user::where('email', $request->email)
            ->update(['token' => $token]);
        return response()->json(["status" => "ok", "data" =>  $token], 200);
    }

    public function user(Request $request)
    {
        $user = user::find($request->id);
        return response()->json(["status" => "ok", "data" => $user], 200);
    }

    public function logout(Request $request)
    {
        $user = user::find($request->id);
        $user->token = null;
        $user->save();
        return response()->json(["status" => "ok", "data" => $user], 200);
    }

    public function loginPage(Request $request)
    {
        return view('login');
    }


    public function registerPage(Request $request)
    {
        return view('register');
    }

    public function logoutPage(Request $request)
    {
        $request->session()->forget('user');
        return redirect('/');
    }

    public function registerPost(RegisterPostRequest $request)
    {
        $email = user::where('email', '=', $request->email)->get();
        $username = user::where('userName', '=', $request->username)->get();


        if ($username->first()) {
            return response()->json(["status" => "error", "message" => ["username already use"]], 400);
        }
        if ($email->first()) {
            return response()->json(["status" => "error", "message" => ["email already use"]], 400);
        }

        if ($request->password != $request->passwordConfirm) {
            return response()->json(["status" => "error", "message" => ["passwordler eşit değil"]], 400);
        }
        $password = Hash::make($request->password);
        $user = new user;

        $user->userName = $request->username;
        $user->email = $request->email;
        $user->password = $password;

        $user->save();
        return response()->json(["status" => "ok", "data" => []], 200);
    }
    public function loginPost(LoginPostRequest $request)
    {
        $user = user::where('email', '=', $request->email)->get();
        if (!$user->first()) {
            return response()->json(["status" => false, "message" => "user not found"], 400);
        }
        $password = Hash::check($request->password, $user[0]->password);
        if (!$password) {
            return response()->json(["status" => false, "message" => "password is not correct"], 400);
        }
        $request->session()->put('user', $user[0]);
        return response()->json(["status" => "ok", "data" => []], 200);
    }
}
