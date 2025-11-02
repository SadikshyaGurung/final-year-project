<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;

class MessageController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'email' => 'required|email|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        Message::create($request->only('name', 'email', 'subject', 'message'));

        return response()->json([
            'success' => true,
            'message' => 'Message saved successfully!',
        ], 201);
    }
}
