<?php
namespace App\Http\Controllers;
use App\Models\Contact;
use App\Models\User;
use App\Models\History;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // List all users
    public function users()
    {
        $users = User::select('id','name','email','role','created_at')->latest()->get();
        return response()->json($users);
    }

    // Delete a user
    public function deleteUser($id)
    {
        $user = User::find($id);
        if (!$user) return response()->json(['message' => 'User not found'], 404);
        $user->delete();
        return response()->json(['message' => 'User deleted']);
    }

    // View all histories (with user)
    public function histories()
    {
        // eager load user to show basic info
        $histories = History::with('user')->latest()->get();
        return response()->json($histories);
    }

    // Optionally: delete a history entry
    public function deleteHistory($id)
    {
        $history = History::find($id);
        if (!$history) return response()->json(['message'=>'Not found'],404);
        $history->delete();
        return response()->json(['message'=>'Deleted']);
    }
    public function messages()
{
    $messages = Contact::latest()->get(); // assuming your model is ContactMessage
    return response()->json($messages);
}
public function showMessages() {
    $messages = \App\Models\Message::latest()->get();
    return view('admin.messages', compact('messages'));
}


}
