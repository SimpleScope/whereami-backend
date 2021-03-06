<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserChallenges extends Model
{
    protected $with = ['challenge'];
    public function updates() {
        return $this->hasMany('App\Models\ChallengeUpdates', 'user_challenge_id', 'id');
    }
    public function challenge() {
        return $this->belongsTo('App\Models\Challenge');
    }
}
