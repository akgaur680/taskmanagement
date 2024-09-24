<?php

namespace App\Http\Controllers;

use App\Jobs\SendUserMail;
use App\Mail\UserMail;
use App\Models\User;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Auth::user());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
            if(!Auth::check()){
                return response()->json([
                    'status'=> false,
                    'message'=> 'Please Login First',
                ], 401);
            }
            $request->validate([
                 'name'=>'required',
                //  'email'=> 'required|unique:users',
                 // 'contact'=> 'required',
                 'password'=> 'required',
                 // 'confirm_password'=> 'required|same:password',
             ]);
             $user = $request->all();
            
             $id = User::findOrFail($id);
             $id->update($user);
     
             return response()->json([
                 'status'=> true,
                 'message'=> 'User Updated Successfully',
                 'user'=> $user
             ], 200);
         }
         catch (\Illuminate\Validation\ValidationException $e){
             return response()->json([
                 'status'=> false,
                 'message'=> 'Validation Errors',
                 'errors'=> $e->errors()
             ], 422);
         }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function register(Request $request){

        try{
       $request->validate([
            'name'=>'required',
            'email'=> 'required|unique:users',
            // 'contact'=> 'required',
            'password'=> 'required',
            // 'confirm_password'=> 'required|same:password',
            // 'profile_img'=>'nullable',
        ]);
        $user = $request->except(['profile_img']);
        if($request->hasFile('profile_img')){
            $profile_img = $request->file('profile_img');
            $customNameprofile_img = time()."_".$profile_img->getClientOriginalName();
            $path = $profile_img->storeAs('public/images',$customNameprofile_img);
            $user['profile_img'] = 'storage/images/'.$customNameprofile_img;
        }
        User::create($user);
        $subject = "Welcome to 01 Synergy Task Management System";
        $email = $request->email;

        dispatch(new SendUserMail($user, $subject, $email));
        return response()->json([
            'status'=> true,
            'message'=> 'User Registered Successfully',
            'user'=> $user
        ]);
    }
    catch (\Illuminate\Validation\ValidationException $e){
        return response()->json([
            'status'=> false,
            'message'=> 'Validation Errors',
            'errors'=> $e->errors()
        ], 422);
    }

    }

    public function login(Request $request){
       
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6'
        ]);
        $credentials = $request->only('email', 'password');


        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->respondWithToken($token);




    }

    public function logout(){
        JWTAuth::invalidate(JWTAuth::getToken());
        return response()->json([
            'status'=>true,
            'message'=> 'User successfully logged out',
        ], 200);
    }


    protected function respondWithToken($token){
        return response()->json([
            'access_token'=> $token,
            'token_type'=> 'bearer',
            'expires_in'=> auth('api')->factory()->getTTL()*60
        ]);
    }
}
