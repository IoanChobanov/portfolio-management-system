<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', Rule::unique('projects', 'slug')->ignore($this->project)],
            'description' => ['nullable', 'string'],
            'started_at' => ['required', 'date'],
            'finished_at' => ['nullable', 'date', 'after_or_equal:started_at','prohibited_unless:status,completed', 'required_if:status,completed'],
            'status' => ['required', 'in:idea,in_progress,completed,on_hold'],
            
            'cover_image' => ['nullable', 'image', 'max:5120'],
            
            'clients' => ['required', 'array', 'min:1'],
            'clients.*' => ['exists:clients,id'],
            'technologies' => ['required', 'array', 'min:1'],
            'technologies.*' => ['exists:technologies,id'],
        ];
    }
}
