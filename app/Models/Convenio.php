<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Convenio extends Model
{
    use HasFactory;

    protected $table = "convenios";
    protected $primaryKey = 'id';

    protected $fillable = ['uuid', 'anios_arancel', 'valor_arancel', 'n_resolucion', 'fecha_resolucion', 'observacion', 'especialidad_id', 'usuario_add_id', 'fecha_add', 'usuario_update_id', 'fecha_update'];

    protected $guarded = ['id'];

    protected $casts = [
        'anios_arancel' => 'array'
    ];

    public function especialidad()
    {
        return $this->hasOne(Especialidad::class, 'id','especialidad_id');
    }

    public function userAdd()
    {
        return $this->hasOne(User::class, 'id','usuario_add_id');
    }

    public function userUpdate()
    {
        return $this->hasOne(User::class, 'id','usuario_update_id');
    }

    public static function booted()
    {
        static::creating(function ($convenio) {
            $convenio->uuid = Str::uuid();
        });
    }
}
