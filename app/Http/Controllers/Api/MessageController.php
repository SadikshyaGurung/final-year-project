<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;

class MessageController extends Controller
{
    // List all messages (Admin only)
    public function index()
    {
        return Message::latest()->get();
    }

    // Store message from contact form
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        Message::create($data);

        return response()->json(['success' => true, 'message' => 'Message sent successfully']);
    }

    // Optional: delete a message
    public function destroy($id)
    {
        $message = Message::findOrFail($id);
        $message->delete();

        return response()->json(['success' => true, 'message' => 'Message deleted']);
    }
}
