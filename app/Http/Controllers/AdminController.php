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
        $totalDiagnoses = Message::count();

        return response()->json([
            'total_users' => User::count(),      
            'total_messages' => Message::count(),
            'total_diagnoses' => History::count(),        ]);
    }

    // List all users (users page) - UPDATED TO INCLUDE AGE & GENDER
    public function users()
    {
        $users = User::select('id', 'name', 'email', 'age', 'gender', 'role', 'created_at')
            ->latest()
            ->get();
        return response()->json($users);
    }

    // Get all messages (messages page)
    public function messages()
    {
        $messages = Message::latest()->get();
        return response()->json($messages);
    }

    // Optionally, get messages from the 'Message' model if separate from Contact
    public function showMessages()
    {
        $messages = Message::latest()->get();
        return view('admin.messages', compact('messages'));
    }
}