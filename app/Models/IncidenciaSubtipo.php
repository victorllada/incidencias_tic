<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncidenciaSubtipo extends Model
{
    use HasFactory;

    /**
     * Nombre de la tabla en la base de datos.
     *
     * @var string
     */
    protected $table = 'incidencias_subtipos';

    /**
     * Define la relación uno a muchos con la tabla 'incidencias'.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function incidencias()
    {
        return $this->hasMany(Incidencia::class, 'subtipo_id');
    }
}
