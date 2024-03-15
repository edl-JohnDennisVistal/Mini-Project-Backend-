<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Role;
use App\Models\userDetails;
use App\Models\Project;

use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username', 
        'email', 
        'password', 
        'first_name', 
        'last_name', 
        'date_of_birth',
        'role', 
        'gender', 
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */

    public function roles(){
        return $this->belongsToMany(Role::class, 'users_has_roles', 'user_id', 'role_id');
    }

    public function ownedProjects() {
        return $this->hasMany(Project::class, 'owner_id');
    }

    public function userDetails(){
        return $this->hasMany(userDetail::class);
    }

    public function projects(){
        return $this->belongsToMany(Project::class, 'users_has_projects', 'user_id', 'project_id');
    }

    public function hasRole($role){
        if ($this->roles()->where('role', $role)->first()) {
            return true;
        }
        return false;
    }

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function getJWTIdentifier(){
        return $this->getKey();
    }

    public function getJWTCustomClaims(){
        return [];
    }

}
