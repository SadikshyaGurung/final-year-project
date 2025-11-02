<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\History;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;


class DiagnosisController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'symptoms' => 'required|array',
            'result' => 'required',
        ]);

        $user = Auth::user();

        $history = History::create([
            'user_id' => $user->id,
            'symptoms' => $request->symptoms,
            'result' => [$request->result],
        ]);

        return response()->json([
            'message' => 'Diagnosis saved successfully',
            'history' => $history,
        ], 201);
    }

    // Optionally, get user's history
    public function index()
{
    $user = Auth::user();
    $histories = History::where('user_id', $user->id)->latest()->get();
    return response()->json($histories);
}

    public function downloadDiagnosis(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'symptoms' => 'required|array',
            'diagnosis' => 'required|string',
            'date' => 'required|date',
        ]);

        $user = User::findOrFail($request->user_id);

        $data = [
            'name' => $user->name,
            'age' => $user->age ?? 'N/A',
            'gender' => $user->gender ?? 'N/A',
            'symptoms' => $request->symptoms,
            'diagnosis' => $request->diagnosis,
            'date' => $request->date,
            'created_at' => now(),
        ];

        $pdf = PDF::loadView('diagnosis_report', $data);

        return $pdf->download('Health_Diagnosis_Report.pdf');
    }
}
