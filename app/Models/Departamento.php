<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    use HasFactory;

    /**
     * Nombre de la tabla en la base de datos.
     *
     * @var string
     */
    protected $table = 'departamentos';

    /**
     * Define la relación uno a muchos con la tabla 'users' (id_departamento).
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function users()
    {
        return $this->hasMany(User::class, 'id_departamento');
    }

    /**
     * Define la relación muchos a uno con la tabla 'personal' (jefe de departamento).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    /*public function jefeDepartamento()
    {
        return $this->belongsTo(User::class, 'jefedep_id');
    }*/
}
