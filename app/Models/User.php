<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

// LdapRecord
use LdapRecord\Laravel\Auth\LdapAuthenticatable;
use LdapRecord\Laravel\Auth\AuthenticatesWithLdap;

//Spatie
use Spatie\Permission\Traits\HasRoles;

/**
 * Clase que representa un usuario en la aplicación.
 *
 * Extiende la clase Authenticatable de Laravel e implementa la interfaz LdapAuthenticatable para la autenticación LDAP.
 */
class User extends Authenticatable implements LdapAuthenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    // LdapRecord
    use Notifiable, AuthenticatesWithLdap;

    // Spatie
    use HasRoles;

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

    // Usamos esto para que no de este error: The given role or permission should use guard `` instead of `web`.
    protected $guard_name = 'web';

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
     * Define la relación uno a muchos con la tabla 'incidencias' (incidencias creadas por el user).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function incidenciasCreadas()
    {
        return $this->hasMany(Incidencia::class, 'creador_id');
    }

    /**
     * Define la relación uno a muchos con la tabla 'users' (incidecnias asignadas al user).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function incidenciasAsignadas()
    {
        return $this->hasMany(Incidencia::class, 'responsable_id');
    }

    /**
     * Define la relación uno a muchos con la tabla 'comentarios' (comentarios realizados por el user).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'personal_id');
    }

    /**
     * Obtiene las incidencias resueltas asignadas al user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function incidenciasResueltas()
    {
        return $this->hasMany(Incidencia::class, 'responsable_id')->where('estado', 'RESUELTA');
    }

    /**
     * Obtiene las incidencias abiertas del user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function incidenciasAbiertas()
    {
        return $this->hasMany(Incidencia::class, 'responsable_id')->where('estado', 'ABIERTA');
    }

    /**
     * Obtiene las incidencias resueltas o cerradas asignadas al user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function incidenciasResueltasOcerradas()
    {
        return $this->hasMany(Incidencia::class, 'responsable_id')->whereIn('estado', ['RESUELTA', 'CERRADA']);
    }

    /**
     * Obtener el nombre de la columna utilizada para la búsqueda por ruta (en lugar del ID).
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'name';
    }
}
