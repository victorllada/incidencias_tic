<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CrearUsuarioRequest extends FormRequest
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
            'nombre_completo' => 'required',
            'name' => 'required',
            'email' => 'required',
            'departamento' => 'required',
            'rol' => 'required|in:administrador,profesor',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'nombre_completo.required' => 'El nombre es obligatorio.',
            'name.required' => 'El usuario es obligatorio.',
            'email.required' => 'El email es obligatrio.',
            'departamento.required' => 'El departamento es obligatrio.',
            'rol.required' => 'El rol es obligatrio.',
            'rol.in' => 'El rol debe ser profesor o administrador',
        ];
    }
}
