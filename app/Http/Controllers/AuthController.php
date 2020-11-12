<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends ApiController
{

    /**
     * Create user
     *
     * @param [string] name
     * @param [string] email
     * @param [string] password
     * @param [string] password_confirmation
     * @param [string] message
     */
    public function signup(Request $request){

        $rules = [
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed',
        ];

        $this->validate($request,$rules);

        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $user->save();

        return response()->json([
            'message' => $user->name.', your account has been created successfully!'
        ], 201);
    }


    /**
     * Login user and create token
     *
     * @param [string] email
     * @param [string] password
     * @param [string] remember_me
     * @param [string] access_token
     * @param [string] expires_at
     */
    public function login(Request $request){

        $rules = [
            'email'=> 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ];

        $this->validate($request,$rules);

        $credentials = request(['email', 'password']);

        if(!Auth::attempt($credentials)){
            return $this->showMessage('Unauthorized', 401);
        }

        $user = $request->user();

        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;

        if($request->remember_me){
            $token->expires_at = Carbon::now()->addWeek();
        }

        $token->save();

        return response()->json([
//            'data' => $user,
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString(),
        ]);
    }


    /**
     * Logout user(Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request){
        $request->user()->token()->revoke();

        return $this->showMessage('successfully logged out');

//        return response()->json([
//            'message' => 'Successfully logged out'
//        ]);

    }


    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request){

        $user = $request->user();
        return $this->showOne($user);
    }

    public function users(){

        $users = User::all();
        return $this->showAll($users);
    }
}
