<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'project_name',
        'start_date',
        'end_date',
        'description'
    ];

    public function users() {
        return $this->belongsToMany(User::class, 'users_has_projects', 'user_id', 'project_id');
    }

    public function owner() {
        return $this->belongsTo(User::class, 'user_id');
    }

}
