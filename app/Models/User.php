<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'nombre_completo', // Cambiado desde 'name'
        'email',
        'password',
        'id_departamento',
        'guid',
        'dominio',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    /*protected $appends = [
        'profile_photo_url',
    ];*/

    /**
     * Define la relación muchos a uno con la tabla 'departamentos'.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'id_departamento');
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
