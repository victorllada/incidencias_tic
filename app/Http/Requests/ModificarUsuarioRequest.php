<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ModificarUsuarioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validaciones para el request
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nombre_completo' => 'required|string',
            'email' => 'required|email',
            'rol' => 'required|in:administrador,profesor',
        ];
    }

    /**
     * Mostrar mensajes personalizados de error
     *
     * @return array
     */
    public function messages()
    {
        return [
            'nombre_completo.required' => 'El nombre es obligatorio.',
            'nombre_completo.string' => 'El nombre debe ser una cadena de texto.',
            'email.required' => 'El email es obligatrio.',
            'email.email' => 'El email debe ser una dirección de correo electrónico válida.',
            'rol.required' => 'El rol es obligatrio.',
            'rol.in' => 'El rol debe ser profesor o administrador.',
        ];
    }
}
