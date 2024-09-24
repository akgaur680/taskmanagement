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

class WebAuthController extends Controller
{
    public function index()
    {
        return view('web.login');
    }
    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'email' => 'required|unique:users',
                'contact' => 'required|min:10|max:10',
                'password' => 'required',
                'confirm_password' => 'required|same:password',
                // 'profile_img'=>'nullable',
            ]);
            $user = $request->all();
            $user['password'] = bcrypt($request->password);
            if ($request->hasFile('profile_img')) {
                $profile_img = $request->file('profile_img');
                $customNameprofile_img = time() . "_" . $profile_img->getClientOriginalName();
                $path = $profile_img->storeAs('public/images', $customNameprofile_img);
                $user['profile_img'] = 'storage/images/' . $customNameprofile_img;
            }
            User::create($user);
            $subject = "Welcome to 01 Synergy Task Management System";
            $email = $request->email;
            dispatch(new SendUserMail($user, $subject, $email));
            return redirect()->route('login')->with('success', 'User Registered Successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6'
        ]);
        $credentials = $request->only('email', 'password');

    // Attempt to log the user in with session-based authentication
    if (Auth::attempt($credentials)) {
        // If successful, redirect to the intended page (default is dashboard)
        return redirect()->intended('/')->with('success', 'Login successful');
    } else {
        // If login fails, redirect back to the login form with an error message
        return redirect()->back()->withErrors(['email' => 'The provided credentials do not match our records.'])->withInput();
    }
    }

    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'name' => 'required',
                'contact' => 'required',
            ]);
    
            $user = User::findOrFail($id);
            $user->update($request->only(['name', 'contact']));
    
            return redirect()->route('profile')->with('success', 'Profile Updated Successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
    }
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        // Remove or comment out JWT related code if not using JWT for this context
        return redirect()->route('login')->with('success', 'User Logout Successfully');
    }
    
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}
