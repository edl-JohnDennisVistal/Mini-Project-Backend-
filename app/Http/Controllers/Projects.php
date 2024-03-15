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
        $created = Project::create($validatedData);
        if($created){
            return response()->json(['response' => true], 201);
        }
        return response()->json(['response' => false], 201);
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

    /** 
     *   This method is used to fetch all projects.  
    **/
    public function fetchProjects(){
        $data = [];
        $projects = Project::with(['owner' => function ($query) {
            $query->select('id');
            $query->with(['userDetails' => function ($query) {
                $query->select('user_id', 'first_name', 'last_name');
            }]);
        }])->get();
        foreach($projects as $project){
            $start_date = strtotime($project->start_date);
            $end_date = strtotime($project->end_date);
            $formattedDate1 = date("F j Y", $start_date);
            $formattedDate2 = date("F j Y", $end_date);
            $data[] = [
                'id' => $project->id,
                'name' => $project->owner['userDetails'][0]->first_name . ' ' . $project->owner['userDetails'][0]->last_name,
                'project' => $project->project_name,
                'start_date' => $formattedDate1,
                'end_date' => $formattedDate2,
                'description' => $project->description,
            ];
        }
        return response()->json(['response' => $data], 201);
    }
}
