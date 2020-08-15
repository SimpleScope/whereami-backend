<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public function challenges() {
        return $this->hasMany('App\Models\UserChallenges');
    }
}
