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
            'subtipo' => 'required|in:Educantabria,Google Classroom,Dominio,YedraAltavoces,PC,Monitor,Proyector,Pantalla interactiva,Portátil,Impresoras,Iesmiguelherrero,WIECAN,Instalación,Actualización',
            'subsubtipo' => 'in:Ratón,Ordenador,Teclado,Portátil proporcionado por Consejería,Portátil de aula',
            'duracion' => 'required',
            'descripcion' => 'required|min:5',
            'prioridad' => 'required|in:baja,media,alta,urgente',
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
            'subtipo.required' => 'El subtipo es obligatorio.',
            'subtipo.in' => 'El sub-tipo debe ser uno del select.',
            'subsubtipo.in' => 'El sub-sub-tipo debe ser uno del select',
            'duracion.required' => 'La duracion es obligatoria',
            'descripcion.required' => 'La descripción es obligatoria.',
            'descripcion.min' => 'La descripción debe tener almenos 5 caracteres.',
            'prioridad.required' => 'La prioridad es obligatria.',
            'prioridad.in' => 'La prioridad debe ser una del select.',
            'fichero.mimes' => 'El fichero adjunto debe tener un formato valido'
        ];
    }
}
