<?php

namespace App\Http\Controllers\Users;

use App\Exceptions\ShivEnigma\ValidationError;
use App\Http\Controllers\Controller;
use App\Validators\v1\StartChallenge;
use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;

class Challenges extends Controller
{
    public function startChallenge(Request $request, StartChallenge $validator) {
        try {
            $validator->validate($request->all());
        } catch (ValidationError $validationError) {
            throw new HttpResponseException(response()->invalid($validationError));
        } catch (\Exception $e) {
            Log::debug($e);
            throw new HttpResponseException(response()->error());
        }
    }
}
