<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreSetupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
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
            'setup_type' => 'nullable|string',
            'best_lap_time' => 'nullable|numeric',
            'data' => 'nullable|json',
            'description' => 'nullable|string',
            'is_public' => 'boolean',
        ];
    }
}
