<?php

namespace App\Http\Controllers\Api;
use App\Models\Prediction;
use App\Models\User;
use App\Models\History;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\Model;

class DetectionController extends Controller
{
   public function detect(Request $request)
{
    $request->validate([
        'user_id'  => 'required|integer|exists:users,id',
        'symptoms' => 'required|array',
    ]);

    // Get the user manually
    $user = User::findOrFail($request->user_id);

    $result = [
        ['issue' => 'Common Cold', 'probability' => 70],
        ['issue' => 'Flu', 'probability' => 30],
    ];

    // Save history
    $history = $user->histories()->create([
        'symptoms' => $request->symptoms, // History model casts to array
        'result'   => $result,
    ]);

    return response()->json(['result' => $result]);
}

   public function history(Request $request)
{
    $request->validate([
        'user_id' => 'required|integer|exists:users,id',
    ]);

    $user = User::findOrFail($request->user_id);

    $histories = $user->histories()->latest()->get();

    return response()->json($histories);
}

    public function storeFromAI(Request $request)
{
    $validated = $request->validate([
        'user_id' => 'required|integer|exists:users,id',
        'symptoms' => 'required|string',
        'prediction' => 'required|string',
    ]);

    $history = \App\Models\Prediction::create([
        'user_id' => $validated['user_id'],
        'symptoms' => $validated['symptoms'],
        'prediction' => $validated['prediction'],
    ]);

    return response()->json([
        'message' => 'Prediction saved successfully',
        'data' => $history,
    ]);
}

}
