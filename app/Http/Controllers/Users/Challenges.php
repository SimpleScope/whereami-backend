<?php

namespace App\Http\Controllers\Users;

use App\Exceptions\ShivEnigma\ValidationError;
use App\Http\Controllers\Controller;
use App\Models\UserChallenges;
use App\Validators\v1\DropChallenge;
use App\Validators\v1\StartChallenge;
use App\Validators\v1\UpdateProgress;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class Challenges extends Controller
{
    public function startChallenge(Request $request, StartChallenge $validator) {
        try {
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
    public function dropChallenge(Request $request, DropChallenge $validator) {
        try {
            $validator->rules['user_challenge_id'] = [
                'required',
                'exists:App\Models\UserChallenges,id',
                Rule::exists('user_challenges', 'id')->where(function ($query) use ($request) {
                    $query->where('user_id', $request->get('user_id'));
                })];
            $validator->validate($request->all());
            $userChallenge = UserChallenges::where('id',$request->get('user_challenge_id'))->firstOrFail();
            $userChallenge->dropped = true;
            $userChallenge->is_active = false;
            $userChallenge->end_date = CarbonImmutable::now();
            $userChallenge->save();
            return response()->created($userChallenge, 'messages.DROP-SUCCESS');
        } catch (ValidationError $validationError) {
            throw new HttpResponseException(response()->invalid($validationError));
        } catch (\Exception $e) {
            Log::debug($e);
            throw new HttpResponseException(response()->error());
        }
    }
    public function getUserChallenges($user_id) {
        try {
          $challenges = UserChallenges::where('user_id', $user_id)->get();
          return $challenges->toJSON();
        } catch (\Exception $e) {
            Log::debug($e);
            throw new HttpResponseException(response()->error());
        }
    }
}
