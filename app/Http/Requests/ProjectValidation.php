<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectValidation extends FormRequest{
    public function rules(){
        return [
            'id' => 'numeric',
            'project_name' => 'required|string|max:50',
            'details' => 'required|max:500',
        ];
    }
}
