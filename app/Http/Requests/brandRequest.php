<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class brandRequest extends FormRequest
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
            'name' => 'required|min:3|max:25',
            'description' => 'required|min:5|max:100',
            'image'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}
