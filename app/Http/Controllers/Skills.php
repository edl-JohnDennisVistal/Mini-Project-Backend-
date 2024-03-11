<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\Request;

/** 
 *  Docu: This class is used to manage skills.
 *  Only an Admin can access it.
 *  This is many to many relationship with users.
**/
class Skills extends Controller
{
    public function addSkill(Request $request){
        $this->validate($request,[
            'skill' => 'required|string',
        ]);
        $skill = new Skill();
        $skill->skill = $request->skill;
        $skill->save();
        return $skill;
    }

    public function removeSkill(Request $request){
        $skill = Skill::find($request->id);
        $skill->delete();
        if($skill){
            return "Skill deleted";
        }
        return "Skill not found";
    }

    public function updateSkill(Request $request){
        $skill = Skill::find($request->id);
        $skill->skill = $request->skill;
        $skill['updated_at'] = date('Y-m-d H:i:s');
        $skill->save();
        if($skill){
            return "Skill updated";
        }
        return "Skill not found";
    }
    
}
