<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    use HasFactory;

    /**
     * Nombre de la tabla en la base de datos.
     *
     * @var string
     */
    protected $table = 'comentarios';

    /**
     * Define la relación muchos a uno con la tabla 'incidencias'.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function incidencia()
    {
        return $this->belongsTo(Incidencia::class, 'incidencia_num');
    }

    /**
     * Define la relación muchos a uno con la tabla 'personal'.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function personal()
    {
        return $this->belongsTo(Personal::class, 'personal_id');
    }
}
