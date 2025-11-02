<?php
namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Controllers\Controller;
class PasswordResetController extends Controller
{
    public function resetPassword(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'code' => 'required|string', // token from email
        'newPassword' => 'required|string|min:8|confirmed', // optionally add confirmation
    ]);

    $status = Password::reset(
        [
            'email' => $request->email,
            'password' => $request->newPassword,
            'password_confirmation' => $request->newPassword, // for confirmation
            'token' => $request->code,
        ],
        function ($user, $password) {
            $user->password = Hash::make($password);
            $user->save();
        }
    );

    return $status === Password::PASSWORD_RESET
        ? response()->json(['message' => 'Password reset successfully'], 200)
        : response()->json(['message' => 'Failed to reset password'], 400);
}

    public function sendResetLink(Request $request)
{
    $request->validate(['email' => 'required|email']);

    $user = User::where('email', $request->email)->first();
    if (!$user) {
        return response()->json(['message' => 'User not found'], 404);
    }

    // Send reset password link
    $status = Password::sendResetLink($request->only('email'));

    return $status === Password::RESET_LINK_SENT
        ? response()->json(['message' => 'Code sent to your email'], 200)
        : response()->json(['message' => 'Failed to send reset code'], 500);
}

}
