<?php 
namespace App\Interfaces;

interface ITransferMoney 
{
    /**
     * interface for transfer money between accounts
     */
    public function transfer($requset, $user_id);
    public function bankResponse();
    public function authorize($source_card);
    public function loging();   
}