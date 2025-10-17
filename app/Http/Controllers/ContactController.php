<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    // User posts message
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        $contact = Contact::create($data);
        return response()->json(['message' => 'Message sent', 'id' => $contact->id], 201);
    }

    // Admin: list messages
    public function index()
    {
        $messages = Contact::latest()->get();
        return response()->json($messages);
    }

    // Admin: delete message
    public function destroy($id)
    {
        $m = Contact::find($id);
        if(!$m) return response()->json(['message'=>'Not found'],404);
        $m->delete();
        return response()->json(['message'=>'Deleted']);
    }
}
