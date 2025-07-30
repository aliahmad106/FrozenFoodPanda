<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail; 

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    public function showResetPasswordForm($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/^.*(?=.{8,})(?=.*[a-z])(?=.*[A-Z])(?=.*[\d])(?=.*[!@#$%^&*? ]).*$/'
            ],
            'contact_info' => 'required|string',
        ]);
    
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'contact_info' => $request->contact_info,
            'default_address' => $request->default_address,
        ]);
    
        Auth::login($user);
    
        return redirect('/')->with('success', 'Registration successful!');
    }
    
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect('/');
        }
    
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
    
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);
    
        $user = User::where('email', $request->email)->first();
    
        if ($user) {
            try {
                $token = Str::random(64);
                $user->password_reset_token = $token;
                $user->password_reset_token_expiry = now()->addHours(1);
                $user->save();
    
                Mail::send('emails.reset-password', ['token' => $token], function($message) use($request) {
                    $message->to($request->email)
                           ->subject('Reset Your Password - Frozen Food Panda')
                           ->from(env('MAIL_FROM_ADDRESS'), 'Frozen Food Panda');
                });
    
                return back()->with('status', 'Password reset link has been sent to your email!');
            } catch (\Exception $e) {
                \Log::error('Password reset email failed: ' . $e->getMessage());
                return back()->withErrors(['email' => 'Unable to send password reset link. Please try again later.']);
            }
        }
    
        return back()->with('status', 'If your email exists in our system, you will receive a password reset link shortly.');
    }    
    
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'password' => [
                'required',
                'confirmed',
                'min:8',
                'regex:/^.*(?=.{8,})(?=.*[a-z])(?=.*[A-Z])(?=.*[\d])(?=.*[!@#$%^&*? ]).*$/'
            ]
        ]);
    
        $user = User::where('password_reset_token', $request->token)
                   ->where('password_reset_token_expiry', '>', now())
                   ->first();
    
        if (!$user) {
            return back()->withErrors(['token' => 'This password reset token is invalid or has expired.']);
        }
    
        $user->password = Hash::make($request->password);
        $user->password_reset_token = null;
        $user->password_reset_token_expiry = null;
        $user->save();
    
        return redirect()->route('login')
            ->with('status', 'Your password has been reset! You can now log in with your new password.');
    }
    

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}