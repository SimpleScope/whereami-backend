<?php


namespace App\Validators\v1;

use Illuminate\Http\Request;
use Illuminate\Validation\Factory as IlluminateValidator;
use Illuminate\Validation\Rule;

class StartChallenge extends \App\Validators\ShivEnigma\Validator
{
    public $rules = array(
        'user_id' => 'required|exists:App\Models\User,id',
        'challenge_id' => ['required', 'exists:App\Models\Challenge,id'],
    );
    public function __construct(IlluminateValidator $validator, Request $request)
    {
        $this->rules['challenge_id'][] = Rule::unique('user_challenges')->where(function ($query) use($request) {
            return $query->where([
                ['user_id', '=' ,$request->get('user_id')],
                ['is_active', '=', true],
            ])->orWhere('round', $request->input('round', 1));
        });
        parent::__construct($validator);
    }
}
