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
    public function editProject(ProjectValidation $request){
        $validatedData = $request->validated();
        $result = Project::where('id', $validatedData['id'])->update($validatedData);
        return response()->json(['response' => $validatedData], 201);
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
    /** 
     *  Use for fetching project's member. This is a many to many, Users and projects.
    **/
    public function fetchProjectUsers($id){
        $projects = Project::with('users.userDetails')->where('id', $id)->get();
        return response()->json(['response' => $projects], 201);
    }
    /** 
     *  Use for edit project. Admin privilages only.
    **/
    public function deleteProject($id){
        $result = Project::where('id', $id)->delete();
        if($result){
            return response()->json(['response' => true], 201);
        }
        return response()->json(['response' => false], 201);
    }
    /** 
     *  Use to display project members.
    **/
    public function projectMembers($id){
        $members = Project::with('users.userDetails')->where('id', $id)->get();
        return response()->json(['response' => $members], 201);
    }
    /** 
     *  Add member to project. Admin privilages only. Using many to many relationship.
    **/
    public function addProjectMember(Request $id){
        $user_id = $id->user_id;
        $project_id = $id->project_id;
        $project = Project::find($project_id);
        $intPrj_id = intval($project_id);;
        $project->users()->attach($user_id);
        return response()->json([],201);
    }

}
