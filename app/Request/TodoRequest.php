<?php

namespace App\Request;

use App\Models\Todo;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class TodoRequest extends FormRequest
{

    public function authorize()
    {
       return Auth::check();
    }

    public function prepareForValidation()
    {
        $this->merge([
            'description' => strip_tags($this->description),
        ]);
    }

    public function rules()
    {
        $rules = [
            'title' => ['required','string'],
            'description' => ['required','string','min:10'],
            'image' => ['sometimes','file', 'mimes:jpeg,png,jpg,webp','max:5048'],
        ];

        if ($this->isMethod('put')) {
            $rules['due_date'] = ['required','date'];
            $rules['status'] = ['required', Rule::in(array_keys(Todo::STATUS))];
        } else {
            $rules['due_date'] = 'required|date|after_or_equal:today';
            $rules['status'] = ['nullable','string',Rule::in(array_keys(Todo::STATUS))];
        }

        return $rules;
    }

}
