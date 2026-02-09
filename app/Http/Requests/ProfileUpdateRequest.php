<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        // Si c'est une université et que le champ name est manquant, on utilise nom_universite
        if ($this->has('nom_universite') && !$this->has('name')) {
            $this->merge([
                'name' => $this->input('nom_universite'),
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'nom_universite' => ['nullable', 'string', 'max:255'],
            'telephone' => ['nullable', 'string', 'max:20'],
            'localisation' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'vision' => ['nullable', 'string'],
            'site_web' => ['nullable', 'url'],
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
        ];
    }
}
