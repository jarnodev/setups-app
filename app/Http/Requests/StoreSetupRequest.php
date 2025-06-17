<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSetupRequest extends FormRequest
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
            'simulator_id' => 'required|exists:simulators,id',
            'track_id' => 'required|exists:tracks,id',
            'car_id' => 'required|exists:cars,id',
            'lap_time_ms' => 'nullable|string',
            'lap_time_recorded_at' => 'nullable|date',
            'setup_type' => 'required|string',
            'setup_data' => 'required|file|mimetypes:application/json',
            'is_public' => 'boolean',
        ];
    }
}
