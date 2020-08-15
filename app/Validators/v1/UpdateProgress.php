<?php


namespace App\Validators\v1;

class UpdateProgress extends \App\Validators\ShivEnigma\Validator
{
    public $rules = array(
        'user_id' => 'required|exists:App\Models\User,id',
        'update' => 'required_without:skipped',
        'skipped' => 'required_without:update|boolean'
    );
}
