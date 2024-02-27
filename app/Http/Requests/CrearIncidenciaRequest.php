<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CrearIncidenciaRequest extends FormRequest
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
            'tipo' => 'required|in:CUENTAS,EQUIPOS,WIFI,INTERNET,SOFTWARE',
            'sub-tipo' => 'in:EDUCANTABRIA,GOOGLE CLASSROOM,DOMINIO,YEDRA,ALTAVOCES,PC,MONITOR,PROYECTOR,PANTALLA INTERACTIVA,PORTATIL,IMPRESORA,IESMIGUELHERRERO,WIECAN,INSTALACION,ACTUALIZACION',
            'sub-sub-tipo' => 'in:RATON,ORDENADOR,TECLADO,PORTATIL PROPORCIONADO POR CONSERJERIA,DE AULA,DE PUESTO',
            'descripcion' => 'required|min:5',
            'prioridad' => 'required|in:BAJA,MEDIA,ALTA,URGENTE',
            'fichero' => 'mimes:jpeg,jpg,png,gif,pdf,doc,docx,xls,xlsx,ppt,pptx,zip',
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
            'tipo.required' => 'El tipo es obligatorio.',
            'tipo.in' => 'El tipo debe ser uno del select.',
            'sub-tipo.in' => 'El sub-tipo debe ser uno del select.',
            'sub-sub-tipo.in' => 'El sub-sub-tipo debe ser uno del select',
            'descripcion.required' => 'La descripción es obligatoria.',
            'descripcion.min' => 'La descripción debe tener almenos 5 caracteres.',
            'prioridad.required' => 'La prioridad es obligatria.',
            'prioridad.in' => 'La prioridad debe ser una del select.',
            'fichero.mimes' => 'El fichero adjunto debe tener un formato valido'
        ];
    }
}
