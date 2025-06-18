<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GenerateSetupRequest extends FormRequest
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
            'query' => 'required|string',
            'simulator_id' => 'required|exists:simulators,id',
            'track_id' => 'required|exists:tracks,id',
            'setup_type' => 'required|string',
            'setup_data' => 'required|file|mimetypes:application/json',
        ];
    }
}
