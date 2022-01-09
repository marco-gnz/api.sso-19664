<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'uuid',
        'rut',
        'dv',
        'rut_completo',
        'primer_nombre',
        'segundo_nombre',
        'apellido_materno',
        'apellido_paterno',
        'nombre_completo',
        'sigla',
        'email',
        'password',
        'estado',
        'genero_id',
        'usuario_add_id',
        'fecha_add',
        'usuario_update_id',
        'fecha_update',
        'last_login_at',
        'last_login_ip'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function genero()
    {
        return $this->hasOne(Etapa::class, 'id', 'genero_id');
    }

    public function redesHospitalarias(){
        return $this->belongsToMany(RedHospitalaria::class); // Muchos a muchos
    }

    public function userAdd()
    {
        return $this->hasOne(User::class, 'id', 'usuario_add_id');
    }

    public function userUpdate()
    {
        return $this->hasOne(User::class, 'id', 'usuario_update_id');
    }

    public static function booted()
    {
        static::creating(function ($usuario) {
            $usuario->uuid = Str::uuid();
        });
    }

    public function scopeGeneral($query, $search)
    {
        if ($search)
            return $query->where('rut_completo', 'like', '%' . $search . '%')
                        ->orWhere('nombre_completo', 'like', '%' . $search . '%')
                        ->orWhere('primer_nombre', 'like', '%' . $search . '%')
                        ->orWhere('segundo_nombre', 'like', '%' . $search . '%')
                        ->orWhere('apellido_materno', 'like', '%' . $search . '%')
                        ->orWhere('apellido_paterno', 'like', '%' . $search . '%')
                        ->orWhere('sigla', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%');
    }

    public function scopePerfil($query, $perfil)
    {
        if($perfil)
        return $query->whereHas('roles', function ($query) use ($perfil) {
            $query->where('id', $perfil);
        });
    }
}
