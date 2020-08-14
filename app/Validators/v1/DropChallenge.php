<?php


namespace App\Validators\v1;

class DropChallenge extends \App\Validators\ShivEnigma\Validator
{
    public $rules = array(
        'user_id' => 'required|exists:App\Models\User,id'
    );
}
