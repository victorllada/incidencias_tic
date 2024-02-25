<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incidencia extends Model
{
    use HasFactory;

    /**
     * Nombre de la tabla en la base de datos.
     *
     * @var string
     */
    protected $table = 'incidencias';

    /**
     * Define la relación muchos a uno con la tabla 'incidencias_subtipos'.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subtipo()
    {
        return $this->belongsTo(IncidenciaSubtipo::class, 'subtipo_id');
    }

    /**
     * Define la relación muchos a uno con la tabla 'personal' (creador de la incidencia).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creador()
    {
        return $this->belongsTo(User::class, 'creador_id');
    }

    /**
     * Define la relación muchos a uno con la tabla 'Users' (responsable de la incidencia).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function responsables()
    {
        return $this->belongsToMany(User::class, 'incidencia_user', 'incidencia_id', 'user_id');
    }

    /**
     * Define la relación muchos a uno con la tabla 'equipos'.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function equipo()
    {
        return $this->belongsTo(Equipo::class, 'equipo_id');
    }

    /**
     * Define la relación uno a muchos con la tabla 'comentarios'.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'incidencia_num');
    }
}
