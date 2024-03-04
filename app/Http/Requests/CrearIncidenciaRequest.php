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
     * Validaciones para el request
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'tipo' => 'required|in:CUENTAS,EQUIPOS,WIFI,INTERNET,SOFTWARE',
            'sub-tipo' => 'in:EDUCANTABRIA,GOOGLE CLASSROOM,DOMINIO,YEDRA,ALTAVOCES,PC,MONITOR,PROYECTOR,PANTALLA INTERACTIVA,PORTATIL,IMPRESORA,IESMIGUELHERRERO,WIECAN,INSTALACION,ACTUALIZACION',
            'sub-sub-tipo' => 'in:RATON,ORDENADOR,TECLADO,PORTATIL PROPORCIONADO POR CONSERJERIA,DE AULA,DE PUESTO',
            'descripcion' => 'required|min:5',
            'prioridad' => 'required|in:BAJA,MEDIA,ALTA,URGENTE',
            'fichero' => 'mimes:jpeg,jpg,png,gif,pdf,doc,docx,txt,xls,xlsx,ppt,pptx,zip',
        ];

        //Si el usuario no tiene email, pondremos que el campo email sea requerido
        if (is_null(auth()->user()->email)) {
            $rules['email'] = 'required';
        }

        //Si el usuario no tiene departamento_id o nombre_departamento, pondremos que el campo departamento sea requerido
        if (is_null(auth()->user()->id_departamento) || is_null(auth()->user()->nombre_departamento)) {
            $rules['departamento'] = 'required';
        }

        return $rules;
    }

    /**
     * Mostrar mensajes personalizados de error
     *
     * @return array
     */
    public function messages()
    {
        $mensajes = [
            'tipo.required' => 'El tipo es obligatorio.',
            'tipo.in' => 'El tipo debe ser uno del select.',
            'sub-tipo.in' => 'El sub-tipo debe ser uno del select.',
            'sub-sub-tipo.in' => 'El sub-sub-tipo debe ser uno del select',
            'descripcion.required' => 'La descripción es obligatoria.',
            'descripcion.min' => 'La descripción debe tener almenos 5 caracteres.',
            'prioridad.required' => 'La prioridad es obligatria.',
            'prioridad.in' => 'La prioridad debe ser una del select.',
            'fichero.mimes' => 'El fichero adjunto debe tener un formato valido.'
        ];

        //Si el usuario no tiene email, y no pone/selecciona un valor en email se mostrará este mensaje
        if (is_null(auth()->user()->email)) {
            $mensajes['email.required'] = 'El email es obligatorio';
        }

        //Si el usuario no tiene departamento_id o nombre_departamento, y no pone/selecciona un valor en departamento se mostrará este mensaje
        if (is_null(auth()->user()->id_departamento) || is_null(auth()->user()->nombre_departamento)) {
            $mensajes['departamento.required'] = 'El departamento es obligatorio';
        }

        return $mensajes;
    }
}
