<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    use HasFactory;

    /**
     * Nombre de la tabla en la base de datos.
     *
     * @var string
     */
    protected $table = 'personal';

    /**
     * Define la relación muchos a uno con la tabla 'departamentos'.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'departamento_id');
    }

    /**
     * Define la relación uno a uno con la tabla 'departamentos' (si el personal es jefe de departamento).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function jefeDepartamento()
    {
        return $this->hasOne(Departamento::class, 'jefedep_id');
    }

    /**
     * Define la relación uno a uno con la tabla 'perfiles'.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function perfiles()
    {
        return $this->hasOne(Perfil::class, 'personal_id');
    }

    /**
     * Define la relación uno a muchos con la tabla 'incidencias' (incidencias creadas por el personal).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function incidenciasCreadas()
    {
        return $this->hasMany(Incidencia::class, 'creador_id');
    }

    /**
     * Define la relación uno a muchos con la tabla 'incidencias' (incidencias asignadas al personal).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function incidenciasAsignadas()
    {
        return $this->hasMany(Incidencia::class, 'responsable_id');
    }

    /**
     * Define la relación uno a muchos con la tabla 'comentarios' (comentarios realizados por el personal).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'personal_id');
    }
}
