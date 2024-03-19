<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\Request;

use App\Models\User;

/** 
 *  Docu: This class is used to manage skills.
 *  Only an Admin can access it.
 *  This is many to many relationship with users.
**/
class Skills extends Controller
{

    public function fetchSkills($id){
        $user = User::find($id);
        $skillsUserHas = $user->skills()->pluck('id');
        $skillsUserDoesNotHave = Skill::whereNotIn('id', $skillsUserHas)->get();
        return response()->json(['response' => $skillsUserDoesNotHave], 201);
    }

    public function getUserSkills($id){
        $skills = User::find($id)->skills()->get();
        return response()->json(['response' => $skills], 201);
    }
    
}
