<?php


namespace App\Validators\v1;


class StartChallenge extends \App\Validators\ShivEnigma\Validator
{
    public $rules = array(
        'user_id' => 'required',
        'challenge_id' => 'required',
    );
}
