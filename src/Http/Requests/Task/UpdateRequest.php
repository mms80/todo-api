<?php

namespace mms80\TodoApi\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use mms80\TodoApi\Task;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check() && $this->task->user_id == Auth::id();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "title" => "nullable|string|max:255",
            "description" => "nullable|string",
            "status" => ["nullable","numeric", "in:".implode(",", array_keys(Task::$enum))],
            "labels" => "nullable|array",
            "labels.*" => "nullable|string|max:255",
        ];
    }
}
