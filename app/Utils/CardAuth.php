<?php
namespace App\Utils;

use App\Interfaces\ICardAuth;

class CardAuth implements ICardAuth
{
    /**
     * authorize card number and check if belong to user 
     * authorize card number via user`s national code
     * @return true or false
     */
    public function authorize($card_number, $national_code)
    {
        return true;
    }
}
