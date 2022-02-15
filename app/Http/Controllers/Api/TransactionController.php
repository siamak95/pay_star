<?php

namespace App\Http\Controllers\Api;

use App\Classes\Consts;
use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionRequest;
use App\Interfaces\ITransferMoney;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

class TransactionController extends Controller
{
    public function create(TransactionRequest $request, ITransferMoney $transfer)
    {
        try {
            return $transfer->transfer($request, auth()->id());
        } catch (Exception $e) {
        }
    }

    public function show()
    {
        try {
            if (auth('sanctum')->check())
                return Auth::user()->histories;
            return [
                'message' => Consts::NOT_AUTHORIZE_ERROR
            ];
        } catch (RouteNotFoundException $e) {
            return $e->getMessage();
        }
    }
}
