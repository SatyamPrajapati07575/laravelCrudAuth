<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Display a list of all users
    public function index()
    {
        // Fetch users with pagination (you can change the number of items per page)
        $users = User::paginate(10);
        return view('users.index', compact('users'));
    }

    // Show the form for editing the specified user
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    // Update the specified user
    public function update(Request $request, $id)
    {
        // Validate the incoming request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'phone' => 'required|string|max:15',
            'gender' => 'required|in:male,female,other',
            'skills' => 'required|string|max:500',
            'profile_img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Find the user and update their data
        $user = User::findOrFail($id);
        
        // Handle profile image upload
        if ($request->hasFile('profile_img')) {
            $imagePath = $request->file('profile_img')->store('profile_images', 'public');
            $user->profile_img = $imagePath;
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'skills' => $request->skills,
        ]);

        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }

    // Delete the specified user
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        
        return redirect()->route('users.index')->with('success', 'User deleted successfully!');
    }
}
