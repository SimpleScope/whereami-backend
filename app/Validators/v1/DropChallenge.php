<?php


namespace App\Validators\v1;

use Illuminate\Http\Request;
use Illuminate\Validation\Factory as IlluminateValidator;
use Illuminate\Validation\Rule;

class DropChallenge extends \App\Validators\ShivEnigma\Validator
{
    public $rules = array(
        'user_id' => 'required|exists:App\Models\User,id'
    );
    public function __construct(IlluminateValidator $validator, Request $request)
    {
        $this->rules['user_challenge_id'] = [
            'required',
            'exists:App\Models\UserChallenges,id',
            Rule::exists('user_challenges', 'id')->where(function ($query) use ($request) {
                $query->where('user_id', $request->get('user_id'));
            })];
        parent::__construct($validator);
    }
}
