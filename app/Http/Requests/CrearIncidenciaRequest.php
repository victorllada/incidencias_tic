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
            'id' => 'required',
            'fecha_hora' => 'required',
            'nombre' => 'required',
            'departamento' => 'required',
            'tipo' => 'required|in:cuentas,equipos,wifi,internet,software',
            'subtipo' => 'required|in:Educantabria, Google Classroom, Dominio, YedraAltavoces,PC,Monitor,Proyector,Pantalla interactiva,Portátil,Impresoras,Iesmiguelherrero, WIECAN, Instalación, Actualización',
            'subsubtipo' => 'in:Ratón, Ordenador, Teclado, Portátil proporcionado por Consejería, Portátil de aula',
            'descripcion' => 'required|min:5',
            'estado' => 'required|in:abierta, asignada, en proceso, enviada a Infortec, resuel',
            'actuaciones' => 'required',
            'prioridad' => 'required|in:baja, media, alta, urgente',
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
            'id.required' => 'El id es obligatorio.',
            'fecha_hora.required' => 'La fecha y hora son obligatorias.',
            'nombre.required' => 'El nombre es obligatorio.',
            'departamento.required' => 'El departamento el obligatorio.',
            'tipo.required' => 'El tipo es obligatorio.',
            'tipo.in' => 'El tipo debe ser uno del select.',
            'subtipo.required' => 'El subtipo es obligatorio.',
            'subtipo.in' => 'El sub-tipo debe ser uno del select.',
            'subsubtipo.in' => 'El sub-sub-tipo debe ser uno del select',
            'descripcion.required' => 'La descripción es obligatoria.',
            'descripcion.min' => 'La descripción debe tener almenos 5 caracteres.',
            'estado.required' => 'El estado es obligatrio.',
            'estado.in' => 'El estado debe ser uno del select.',
            'estado.required' => 'El estado es obligatrio.',
            'prioridad.required' => 'La prioridad es obligatria.',
            'prioridad.in' => 'La prioridad debe ser una del select.',
        ];
    }
}
