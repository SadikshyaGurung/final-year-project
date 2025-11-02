<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    /**
     * Send reset code to user's email
     */
    public function sendResetCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $email = $request->email;
        
        // Generate a 6-digit code
        $code = random_int(100000, 999999);
        
        // Store the code in cache for 15 minutes
        Cache::put("password_reset_{$email}", $code, now()->addMinutes(15));

        try {
            // Send email with the code
            Mail::send('emails.reset-password', ['code' => $code], function ($message) use ($email) {
                $message->to($email)
                        ->subject('Password Reset Code');
            });

            return response()->json([
                'success' => true,
                'message' => 'Reset code sent to your email. Valid for 15 minutes.',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send email. Please try again.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Reset password using the code
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'code' => 'required|numeric',
            'newPassword' => 'required|string|min:8',
        ]);

        $email = $request->email;
        $code = $request->code;
        $newPassword = $request->newPassword;

        // Check if code exists in cache
        $storedCode = Cache::get("password_reset_{$email}");

        if (!$storedCode) {
            return response()->json([
                'success' => false,
                'message' => 'Reset code has expired. Please request a new one.',
            ], 400);
        }

        if ($storedCode != $code) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid reset code.',
            ], 400);
        }

        // Update the password
        $user = User::where('email', $email)->first();
        $user->password = Hash::make($newPassword);
        $user->save();

        // Clear the code from cache
        Cache::forget("password_reset_{$email}");

        return response()->json([
            'success' => true,
            'message' => 'Password reset successfully!',
        ], 200);
    }
}