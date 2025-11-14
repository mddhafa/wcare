<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatbotController extends Controller
{
    public function generate(Request $request)
    {
        $response = Http::post('http://127.0.0.1:5000/generate', [
            'user_input' => $request->message
        ]);

        // return response()->json([
        //     'response' => $response->json()['response'] ?? $response->body()
        // ]);

        return response()->json([
            'response' => $response->json()['response'] ?? 'Maaf, terjadi kesalahan pada server chatbot.'
        ]);
    }

}
