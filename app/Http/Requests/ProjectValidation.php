<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectValidation extends FormRequest{
    public function rules(){
        return [
            'user_id' => 'required',
            'project_name' => 'required|string|max:50',
            'start_date' => 'required',
            'end_date' => 'required',
            'description' => 'required|max:500',
        ];
    }
}
