<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    // Show the registration form
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // Handle the registration process
    public function register(Request $request)
    {
        // Custom error messages
        $messages = [
            'name.required' => 'Please provide your full name.',
            'email.required' => 'We need your email address to register.',
            'email.email' => 'Please provide a valid email address.',
            'email.unique' => 'This email is already taken, please use another one.',
            'phone.required' => 'A phone number is required to complete your registration.',
            'phone.max' => 'Phone number should not exceed 15 characters.',
            'gender.required' => 'Please select your gender.',
            'skills.required' => 'Please tell us about your skills.',
            'skills.max' => 'Your skills description is too long. Please keep it under 500 characters.',
            'password.required' => 'Please create a password.',
            'password.min' => 'Password must be at least 8 characters long.',
            'password.confirmed' => 'Password confirmation does not match.',
            'profile_img.image' => 'The profile image must be an image (jpeg, png, jpg, or gif).',
            'profile_img.mimes' => 'Profile image must be of type jpeg, png, jpg, or gif.',
            'profile_img.max' => 'Profile image should not be larger than 2MB.',
        ];

        // Validate the incoming data with custom messages
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:15',
            'gender' => 'required|in:male,female,other',
            'skills' => 'required|string|max:500',
            'password' => 'required|string|min:8|confirmed',
            'profile_img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], $messages); // Passing custom messages array

        // Handle profile image upload
        $imagePath = null;
        if ($request->hasFile('profile_img')) {
            $imagePath = $request->file('profile_img')->store('profile_images', 'public');
        }

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'skills' => $request->skills,
            'password' => Hash::make($request->password),
            'profile_img' => $imagePath,
        ]);

        // Log the user in
        Auth::login($user);

        // Redirect to the dashboard with a success message
        return redirect()->route('dashboard')->with('success', 'Registration successful! Welcome.');
    }

    // Show the login form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Handle the login process
    public function login(Request $request)
    {
        // Validate login credentials
        $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        // Attempt to login
        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect()->route('dashboard');
        }

        // Flash error message and redirect back if login fails
        return back()->withErrors(['email' => 'These credentials do not match our records.']);
    }

    // Log the user out
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
