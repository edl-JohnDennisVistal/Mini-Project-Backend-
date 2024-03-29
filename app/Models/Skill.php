<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class Skill extends Model
{
    use HasFactory;

    public function users() {
        return $this->belongsToMany(User::class, 'users_has_skills', 'skill_id', 'user_id');
    }

}
