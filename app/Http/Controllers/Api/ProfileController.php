<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ProfileController extends Controller
{
    // Get current logged-in user
    public function show(Request $request)
    {
        return response()->json($request->user());
    }

    // Update profile
    public function update(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'age' => 'sometimes|integer|min:0|max:150',
            'gender' => 'sometimes|string|in:male,female,non-binary,prefer-not-to-say',
        ]);

        $user->update($request->only('name', 'age', 'gender'));

        return response()->json([
            'message' => 'Profile updated successfully',
            'user' => $user
        ]);
    }

    // Change password
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = $request->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['message' => 'Current password is incorrect'], 422);
        }

        $user->update(['password' => Hash::make($request->new_password)]);

        return response()->json(['message' => 'Password updated successfully']);
    }

    // Fetch user by username
    public function showByUsername($username)
    {
        $user = User::where('name', $username)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json([
            'name' => $user->name,
            'email' => $user->email,
            'age' => $user->age,
            'gender' => $user->gender,
        ]);
    }
}
