<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ModificarIncidenciaRequest extends FormRequest
{
    /**
     * Validaciones para el request
     */
    public function rules(): array
    {
        return [
            'tipo' => 'required|in:CUENTAS,EQUIPOS,WIFI,INTERNET,SOFTWARE',
            'sub-tipo' => 'in:EDUCANTABRIA,GOOGLE CLASSROOM,DOMINIO,YEDRA,ALTAVOCES,PC,MONITOR,PROYECTOR,PANTALLA INTERACTIVA,PORTATIL,IMPRESORA,IESMIGUELHERRERO,WIECAN,INSTALACION,ACTUALIZACION',
            'sub-sub-tipo' => 'in:RATON,ORDENADOR,TECLADO,PORTATIL PROPORCIONADO POR CONSERJERIA,DE AULA,DE PUESTO',
            'estado' => 'required|in:ABIERTA,ASIGNADA,EN PROCESO,ENVIADA A INFORTEC,RESUELTA,CERRADA',
            'descripcion' => 'required|min:5',
            'prioridad' => 'required|in:BAJA,MEDIA,ALTA,URGENTE',
            'fichero' => 'mimes:jpeg,jpg,png,gif,pdf,doc,docx,txt,xls,xlsx,ppt,pptx,zip',
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
            'tipo.required' => 'El tipo es obligatorio.',
            'tipo.in' => 'El tipo debe ser uno del select.',
            'sub-tipo.in' => 'El sub-tipo debe ser uno del select.',
            'sub-sub-tipo.in' => 'El sub-sub-tipo debe ser uno del select',
            'estado.required' => 'El estado es obligatorio.',
            'estado.in' => 'El estado debe ser uno del select.',
            'descripcion.required' => 'La descripción es obligatoria.',
            'descripcion.min' => 'La descripción debe tener almenos 5 caracteres.',
            'prioridad.required' => 'La prioridad es obligatria.',
            'prioridad.in' => 'La prioridad debe ser una del select.',
            'fichero.mimes' => 'El fichero adjunto debe tener un formato valido'
        ];
    }
}
