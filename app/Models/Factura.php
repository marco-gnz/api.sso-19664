<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Factura extends Model
{
    use HasFactory;

    protected $table        = "facturas";
    protected $primaryKey   = 'id';
    protected $guarded      = ['id'];
    protected $fillable     =
    [
        'uuid',
        'n_resolucion',
        'fecha_resolucion',
        'n_resolucion_convenio',
        'fecha_convenio',
        'envio_finanza',
        'fecha_pago',
        'anio_academico',
        'n_factura',
        'fecha_emision_factura',
        'fecha_vencimiento_factura',
        'cargo_item',
        'anios_pago',
        'monto_total',
        'observacion',
        'profesional_id',
        'tipo_contrado_id',
        'situacion_factura_id',
        'convenio_id',
        'centro_formador_id',
        'red_hospitalaria_id',
        'perfeccionamiento_id',
        'ip_user_add',
        'usuario_add_id',
        'fecha_add',
        'ip_user_update',
        'usuario_update_id',
        'fecha_update'
    ];

    protected $casts = [
        'anios_pago' => 'array'
    ];

    public function profesional()
    {
        return $this->hasOne(Profesional::class, 'id', 'profesional_id');
    }

    public function tipoContratoProfesional()
    {
        return $this->hasOne(TipoContratos::class, 'id', 'tipo_contrado_id');
    }

    public function situacionActual()
    {
        return $this->hasOne(SituacionFactura::class, 'id', 'situacion_factura_id');
    }

    public function convenio()
    {
        return $this->hasOne(Convenio::class, 'id', 'convenio_id');
    }

    public function centroFormador()
    {
        return $this->hasOne(CentroFormador::class, 'id', 'centro_formador_id');
    }

    public function redHospitalaria()
    {
        return $this->hasOne(RedHospitalaria::class, 'id', 'red_hospitalaria_id');
    }

    public function perfeccionamiento()
    {
        return $this->hasOne(Perfeccionamiento::class, 'id', 'perfeccionamiento_id');
    }

    public function tipos()
    {
        return $this->belongsToMany(TipoFactura::class);
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
        static::creating(function ($factura) {
            $factura->uuid = Str::uuid();
        });
    }
}
