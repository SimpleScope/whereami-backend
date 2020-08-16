<?php

namespace App\Http\Controllers\Users;

use App\Exceptions\ShivEnigma\ValidationError;
use App\Http\Controllers\Controller;
use App\Models\ChallengeUpdates;
use App\Models\UserChallenges;
use App\Validators\v1\UpdateProgress;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class Progress extends Controller
{
    public function update($user_challenge_id, Request $request, UpdateProgress $validator) {
        try {
            $data = $request->all();
            $data['user_challenge_id'] = $user_challenge_id;
            $validator->validate($data);
            $update = new ChallengeUpdates();
            $update->user_challenge_id = $user_challenge_id;
            $update->skipped = $request->input('skipped', false);
            $update->update = $request->input('update', '');
            $update->save();
            return response()->created($update);
        } catch (ValidationError $validationError) {
            throw new HttpResponseException(response()->invalid($validationError));
        } catch (\Exception $e) {
            Log::debug($e);
            throw new HttpResponseException(response()->error());
        }
    }
    public function getHistory($user_challenge_id) {
        try {
            $updates = UserChallenges::findOrFail($user_challenge_id)
                ->updates()
                ->latest()
                ->get();
            return $updates->toJSON();
        } catch (ModelNotFoundException $validationError) {
            throw new HttpResponseException(response()->notFound('messages.INVALID-USER-CHALLENGE'));
        } catch (\Exception $e) {
            Log::debug($e);
            throw new HttpResponseException(response()->error());
        }
    }
}
