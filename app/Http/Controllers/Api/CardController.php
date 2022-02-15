<?php

namespace App\Http\Controllers\Api;

use App\Classes\Consts;
use App\Http\Controllers\Controller;
use App\Http\Requests\CardRequest;
use App\Interfaces\ICardAuth;
use App\Models\Card;
use Exception;
use Illuminate\Http\Request;

class CardController extends Controller
{
    public function store(CardRequest $request, ICardAuth $card_auth)
    {
        try {
            if ($card_auth->authorize($request->card_number, auth()->user()->id)) {
                Card::create([
                    'user_id' => auth()->user()->id,
                    'card_number' => $request->card_number
                ]);
                return response()->json([
                    'data' => Consts::CARD_STORE_MSG
                ], 201);
            }
            return response()->json([
                'data' => Consts::CARD_STORE_ERR
            ], 403);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show()
    {
        try {
            return auth()->user()->CardsInfo();
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
