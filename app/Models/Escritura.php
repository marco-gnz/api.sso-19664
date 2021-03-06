<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Escritura extends Model
{
    use HasFactory;

    protected $table = "escrituras";
    protected $primaryKey = 'id';

    protected $fillable = ['uuid', 'escritura_firmada', 'valor_garantia', 'n_resolucion', 'fecha_resolucion', 'n_repertorio', 'anio_repertorio', 'observacion', 'especialidad_id', 'usuario_add_id', 'fecha_add', 'usuario_update_id', 'fecha_update'];

    protected $guarded = ['id'];

    public function especialidad()
    {
        return $this->hasOne(Especialidad::class, 'id', 'especialidad_id');
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
        static::creating(function ($escritura) {
            $escritura->uuid = Str::uuid();
        });
    }
}
