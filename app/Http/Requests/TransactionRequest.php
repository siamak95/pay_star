<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class TransactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth('sanctum')->check();
    }

    /**
     * return validation errors 
     * @return json response
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors(),
           
        ]));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'deposit' =>'required|numeric|digits:16',
            'destination_number' => 'required|numeric|digits:16',
            'mount' => 'required|numeric|gt:10000',
            "description"=> 'required|alpha' ,
            "destination_firstname"=> 'required|alpha' ,
            "destination_lastname"=> 'required|alpha' ,
            "payment_number"=> 'required|numeric' ,
            "source_firstName"=> 'required|alpha' ,
            "source_lastName"=> 'required|alpha' ,
            "reason_description"=> 'required|alpha'
        ];
    }
}
