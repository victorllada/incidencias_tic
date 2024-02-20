<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    use HasFactory;

    /**
     * Nombre de la tabla en la base de datos.
     *
     * @var string
     */
    protected $table = 'equipos';

    /**
     * Define la relación muchos a uno con la tabla 'aulas'.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function aula()
    {
        return $this->belongsTo(Aula::class, 'aula_id');
    }

    /**
     * Define la relación uno a muchos con la tabla 'incidencias'.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function incidencias()
    {
        return $this->hasMany(Incidencia::class, 'equipo_id');
    }
}
