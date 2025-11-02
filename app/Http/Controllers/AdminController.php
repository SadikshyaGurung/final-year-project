<?php 
namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\User;
use App\Models\History;
use App\Models\Message;
use App\Models\Diagnosis;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Get Dashboard Data: Total messages, users, and diagnosis count
    public function getDashboardData()
    {
        $totalMessages = Message::count();
        $totalUsers = User::count();
        $totalDiagnoses = Diagnosis::count();

        return response()->json([
            'totalMessages' => $totalMessages,
            'totalUsers' => $totalUsers,
            'totalDiagnoses' => $totalDiagnoses
        ]);
    }

    // List all users (users page) - UPDATED TO INCLUDE AGE & GENDER
    public function users()
    {
        $users = User::select('id', 'name', 'email', 'age', 'gender', 'role', 'created_at')
            ->latest()
            ->get();
        return response()->json($users);
    }

    // Delete a user (users page)
    public function deleteUser($id)
    {
        $user = User::find($id);
        if (!$user) return response()->json(['message' => 'User not found'], 404);
        $user->delete();
        return response()->json(['message' => 'User deleted']);
    }

    // View all histories (dashboard or other pages)
    public function histories()
    {
        $histories = History::with('user')->latest()->get();
        return response()->json($histories);
    }

    // Delete a history entry (admin functionality)
    public function deleteHistory($id)
    {
        $history = History::find($id);
        if (!$history) return response()->json(['message' => 'Not found'], 404);
        $history->delete();
        return response()->json(['message' => 'Deleted']);
    }

    // Get all messages (messages page)
    public function messages()
    {
        $messages = Contact::latest()->get();
        return response()->json($messages);
    }

    // Optionally, get messages from the 'Message' model if separate from Contact
    public function showMessages()
    {
        $messages = Message::latest()->get();
        return view('admin.messages', compact('messages'));
    }
}