<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Http\Requests\ProjectValidation;
use Illuminate\Http\Request;

/**  
 *   Docu: This class is used to create project.
 *   This must be only accessible for Admins.
 *   This class is authorized by middleware.
**/
class Projects extends Controller
{
    /**  
     *   This method is used to create project. 
     *   This is validated by ProjectValidation.php
     *   Returns created project
    **/
    public function createProject(ProjectValidation $request){
        $validatedData = $request->validated();
        $user = Project::create($validatedData);
        return $user;
    }
    /**  
     *   This method is used to update project.
     *   Only Admins can update projects.
     *   Returns updated project
    **/
    public function updateProject(ProjectValidation $request){
        $validatedData = $request->validated();
        $validatedData['updated_at'] = date('Y-m-d H:i:s');
        $user = Project::where('id', $validatedData['id'])->update($validatedData);
        if($user){
            return "Updated";
        }
        return "Not Updated";
    }
}
