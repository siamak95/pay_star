<?php
namespace App\Interfaces;

interface ICardAuth 
{
    public function authorize($card_number, $national_code);
}