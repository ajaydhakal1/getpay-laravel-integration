<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GetPayController extends Controller
{
    public function getOprSecret(Request $request)
    {
        $clientRequestId = $request->input('clientRequestId');

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post('https://uat-bank-getpay.nchl.com.np/api/merchant/transaction-status', [
                    'clientRequestId' => $clientRequestId,
                ]);

        if ($response->successful()) {
            $responseData = $response->json();
            $oprSecret = $responseData['oprSecret'] ?? null;

            if ($oprSecret) {
                return response()->json([
                    'success' => true,
                    'opr_secret' => $oprSecret,
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'opr-secret not found in response.',
                ], 422);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve transaction status.',
            ], $response->status());
        }
    }
}