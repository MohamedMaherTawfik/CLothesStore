<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class userAddresses extends FormRequest
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
            'address'=>'required|min:3',
            'city'=>'required|min:3',
            'postal_code'=>'required|min:3',

        ];
    }
}
