<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class DocumentoGenerico extends Model
{
    use HasFactory;

    protected $table = "documento_genericos";
    protected $primaryKey = 'id';

    protected $fillable = ['uuid', 'n_documento', 'fecha_documento', 'observacion', 'tipo_documento_id', 'profesional_id', 'usuario_add_id', 'fecha_add', 'usuario_update_id', 'fecha_update'];

    public static function booted()
    {
        static::creating(function ($convenio) {
            $convenio->uuid = Str::uuid();
        });
    }

    public function tipoDocumento()
    {
        return $this->hasOne(TipoDocumento::class, 'id','tipo_documento_id');
    }

    public function profesional()
    {
        return $this->hasOne(Profesional::class, 'id','profesional_id');
    }

    public function userAdd()
    {
        return $this->hasOne(User::class, 'id','usuario_add_id');
    }

    public function userUpdate()
    {
        return $this->hasOne(User::class, 'id','usuario_update_id');
    }
}
