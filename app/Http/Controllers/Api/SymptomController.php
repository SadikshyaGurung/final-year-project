<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse; // ✅ THIS is the correct one

class SymptomController extends Controller
{
    public function index(): JsonResponse
    {
        $symptoms = [
            'Fever',
            'Cough',
            'Fatigue',
            'Headache',
            'Nausea',
            'Sore throat',
            'Runny nose',
            'Shortness of breath'
        ];

        return response()->json($symptoms);
    }
}
