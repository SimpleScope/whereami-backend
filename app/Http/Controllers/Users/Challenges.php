<?php

namespace App\Http\Controllers\Users;

use App\Exceptions\ShivEnigma\ValidationError;
use App\Http\Controllers\Controller;
use App\Models\UserChallenges;
use App\Validators\v1\StartChallenge;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class Challenges extends Controller
{
    public function startChallenge(Request $request, StartChallenge $validator) {
        try {
            $validator->rules['challenge_id'] = [
                'required',
                'exists:App\Models\Challenge,id',
                // TODO: Fix this validation, scope issue
                /*Rule::unique('user_challenges')->where(function ($query) {
                    return $query->where('user_id', $request->get('user_id'))
                        ->where('challenge_id', $request->get('challenge_id'))
                        ->where('round', '<=', $request->get('round'));
                }), */
            ];
            $validator->validate($request->all());
            $startDate = CarbonImmutable::now();
            $endDate = $startDate->addDays(100);
            $challenge = new UserChallenges();
            $challenge->user_id = $request->get('user_id');
            $challenge->challenge_id = $request->get('challenge_id');
            $challenge->start_date = $startDate;
            $challenge->end_date = $endDate;
            $challenge->save();
            return response()->created($challenge);
        } catch (ValidationError $validationError) {
            throw new HttpResponseException(response()->invalid($validationError));
        } catch (\Exception $e) {
            Log::debug($e);
            throw new HttpResponseException(response()->error());
        }
    }
}
