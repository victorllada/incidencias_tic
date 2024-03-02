<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use PHPUnit\Framework\Constraint\IsTrue;

class CrearComentarioRequest extends FormRequest
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
            'texto' => 'required',
            //'fichero' => 'mimes:jpeg,jpg,png,gif,pdf,doc,docx,xls,xlsx,ppt,pptx,zip',
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
            'texto.required' => 'El texto del comentario es obligatorio.',
            //'fichero.mimes' => 'El fichero adjunto debe tener un formato valido'
        ];
    }
}
