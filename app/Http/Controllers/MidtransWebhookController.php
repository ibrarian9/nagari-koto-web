<?php

namespace App\Http\Controllers;

use App\Services\MidtransService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MidtransWebhookController extends Controller
{
    public function handle(Request $request): JsonResponse
    {
        try {
            $result = (new MidtransService())->handleNotification();
            return response()->json($result);
        } catch (\Exception $e) {
            report($e);
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}
