<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class DeveloperRequest extends FormRequest
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
     * @return array
     */
    #[ArrayShape(['name' => "string", 'time' => "string", 'difficulty' => "string"])] public function rules(): array
    {
        return [
            'name' => 'required|unique:developers',
            'time' => 'required|integer',
            'difficulty' => 'required|integer'
        ];
    }
}
