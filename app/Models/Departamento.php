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
     * Define la relación muchos a uno con la tabla 'personal' (jefe de departamento).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function jefeDepartamento()
    {
        return $this->belongsTo(Personal::class, 'jefedep_id');
    }
}
