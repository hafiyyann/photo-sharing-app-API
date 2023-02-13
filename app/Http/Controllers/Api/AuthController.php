<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\userService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    
    /**
     * Registering new user
     * 
     * @param Request $request
     * 
     * @return json
     * 
     */
    public function register(Request $request){
        try{
            
            $user = $this->userService->storeUser($request->all());

            return response()->json([
                'status'    => true,
                'text'      => 'Registration Success',
                'data'      => [
                    'name'  => $user->name,
                    'email' => $user->email,
                    'token' => $user->createToken('myApp')->plainTextToken
                ]
            ], 200);
        } catch (Exception $e){
            return response()->json([
                'status'    => false,
                'text'      => "Registration failed"
            ], 500);
        }
    }

    /**
     * Logged in registered users
     * 
     * @param Request $request
     * 
     * @return json
     */
    public function login(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'email'         => 'required',
                'password'      => 'required' 
            ]);

            if($validator->fails()){
                return response()->json([
                    'status'    => false,
                    'text'      => 'Validation error',
                    'data'      => [
                        'errors' => $validator->errors()
                    ]
                ], 422);
            }

            $user = $this->userService->getUserByEmail($request->email);

            if(!$user){
                return response()->json([
                    'status'    => false,
                    'text'      => 'User not found',
                ], 404);
            }

            if(Hash::check($request->password, $user->password)){
                return response()->json([
                    'status'    => true,
                    'text'      => 'User logged in successfully',
                    'data'      => [
                        'name'  => $user->name,
                        'email' => $user->email,
                        'token' => $user->createToken('myApp')->plainTextToken
                    ]
                ], 200);
            } else {
                return response()->json([
                    'status'    => false,
                    'text'      => 'Wrong Password',
                ], 403);
            }

        } catch(Exception $e) {
            return response()->json([
                'status'    => false,
                'text'      => "Login failed"
            ], 500);
        }
    }
}
