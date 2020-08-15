<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserChallenges extends Model
{
    public function updates() {
        return $this->hasMany('App\Models\ChallengeUpdates', 'user_challenge_id', 'id');
    }
}
