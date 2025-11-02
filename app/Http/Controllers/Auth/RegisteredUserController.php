<?php 
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade as PDF;


class RegisteredUserController extends Controller
{
    public function store(Request $request)
{
    try {
        // Validate incoming data
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:8'],
            'age' => 'nullable|integer|min:1|max:120',
            'gender' => 'nullable|string|in:male,female,other',
        ]);

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'age' => $request->age,
            'gender' => $request->gender,
        ]);

        // Fire the Registered event
        event(new Registered($user));

        // Create API token
        $token = $user->createToken('YourAppName')->plainTextToken;

        // Return success response
        return response()->json([
            'message' => 'User registered successfully.',
            'user' => $user,
            'token' => $token,
        ], 201);

    } catch (\Exception $e) {
        // Log error details for debugging
        Log::error('Registration error: ' . $e->getMessage());

        return response()->json([
            'message' => 'An error occurred during registration.',
            'error' => $e->getMessage(),
        ], 500);
    }
}

}
