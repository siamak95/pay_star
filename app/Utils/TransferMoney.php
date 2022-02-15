<?php

namespace App\Utils;

use App\Classes\Consts;
use App\Interfaces\ITransferMoney;
use App\Models\Card;
use App\Models\History;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class TransferMoney implements ITransferMoney
{
    public $mount;
    public $destination_number;
    public $deposit;
    public $response;
    public $user_id;

    /**
     * do transfer between accounts
     * @return response and messages
     */
    public function transfer($request, $user_id)
    {
        try {
            $this->setFunction($request->destination_number, $request->deposit, $request->mount, $user_id);

            if (!$this->authorize($this->deposit))
                return ['message' => Consts::CARD_AUTHORIZE_ERROR];

            $this->response = Http::withToken(Consts::CONST_TOCKEN)
                ->acceptJson()->post('https://sandboxapi.finnotech.ir/oak/v2/clients/1/transferTo?trackId={trackId}', [
                    'deposit' => $request->desposit,
                    'destinationNumber' => $request->destination_number,
                    'amount' => $request->mount,
                    "description" => $request->description,
                    "destinationFirstname" => $request->destination_firstname,
                    "destinationLastname" => $request->destination_lastname,
                    "paymentNumber" => $request->payment_number,
                    "sourceFirstName" => $request->source_firstname,
                    "sourceLastName" => $request->source_lastname,
                    "reasonDescription" => $request->reason_description
                ]);

            $message = $this->loging();
            return response()->json([
                'data' => $this->bankResponse(),
                'message' => $message
            ], $this->response->getStatusCode());
        } catch (Exception $e) {
            return response()->json([
                'data' => $e->getMessage()
            ], 500);
        }
    }
    public function setFunction($destination_number, $deposit, $mount, $user_id)
    {
        $this->destination_card = $destination_number;
        $this->source_card = $deposit;
        $this->mount = $mount;
        $this->user_id = $user_id;
    }

    /**
     * authorize if the card number is belongs to user
     */
    public function authorize($source_card)
    {
        return Card::where(['user_id' => $this->user_id, 'card_number' => $this->source_card])->exists();
    }


    /**
     * handle errors and show responses 
     * @return string message
     */

    public function bankResponse()
    {
        switch ($this->response->getStatusCode()) {
            case 400:
                return $this->response['error']['message'];
            case 403:
                return $this->response['error']['message'];
            case 200:
                return Consts::TRABSACTION_DONE;
        }
    }

    /**
     * records transactions in db
     * @return string messages 
     */
    public function loging()
    {
        try {
            History::create([
                'user_id' => $this->user_id,
                'status_code' => $this->response->getStatusCode(),
                'mount' => $this->mount,
                'source_code_id' => Card::where('card_number', $this->deposit)->first()->id,
                'destination_code' => $this->destination_number,
                'tackle_id' => $this->response['trackId'],
                'message'  => $this->response['error']['message'],
                'code' => $this->response['error']['code'],
            ]);

            return Consts::TRANSACTION_ADD_MSG;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
