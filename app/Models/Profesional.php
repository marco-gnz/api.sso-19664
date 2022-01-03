<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Profesional extends Model
{
    use HasFactory;

    protected $table = "profesionals";
    protected $primaryKey = 'id';

    protected $fillable = ['uuid', 'rut', 'dv', 'rut_completo', 'nombres', 'apellidos', 'nombre_completo', 'email', 'n_contacto', 'ciudad', 'etapas_id', 'situacion_actual_id', 'calidad_juridica_id', 'planta_id', 'estado', 'genero_id', 'usuario_add_id', 'fecha_add', 'usuario_update_id', 'fecha_update'];

    protected $guarded = ['id'];

    public function etapa()
    {
        return $this->hasOne(Etapa::class, 'id', 'etapas_id');
    }

    public function calidad()
    {
        return $this->hasOne(CalidadJuridica::class, 'id', 'calidad_juridica_id');
    }

    public function especialidades()
    {
        return $this->hasMany(Especialidad::class);
    }

    public function facturas()
    {
        return $this->hasMany(Factura::class);
    }

    public function etapasDestinacion()
    {
        return $this->hasMany(EtapaDestinacion::class);
    }

    public function destinaciones()
    {
        return $this->hasMany(EtapaDestinacion::class);
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
        static::creating(function ($profesional) {
            $profesional->uuid = Str::uuid();
        });
    }

    //search
    public function scopeGeneral($query, $search)
    {
        if ($search)
            return $query->where('rut_completo', 'like', '%' . $search . '%')->orWhere('nombre_completo', 'like', '%' . $search . '%');
    }
    public function scopeEtapa($query, $search)
    {
        if ($search)
            return $query->whereIn('etapas_id', $search);
    }
    public function scopePerfeccionamiento($query, $search)
    {
        if ($search)
            $query->whereHas('especialidades', function ($query) use ($search) {
                $query->whereIn('perfeccionamiento_id', $search);
            });
    }

    public function scopeDestinacion($query, $inicio_f_ed, $termino_f_ed)
    {
        if ($inicio_f_ed && $termino_f_ed)
            $query->whereHas('destinaciones', function ($query) use ($inicio_f_ed, $termino_f_ed) {
                $query->whereBetween('inicio_periodo', array($inicio_f_ed, $termino_f_ed));
            });
    }

    public function scopeFormacion($query, $inicio_f_ef, $termino_f_ef)
    {
        if ($inicio_f_ef && $termino_f_ef)
            $query->whereHas('especialidades', function ($query) use ($inicio_f_ef, $termino_f_ef) {
                $query->where('origen', 'EDF')->whereBetween('inicio_formacion', array($inicio_f_ef, $termino_f_ef));
            });
    }

    public function scopePaos($query, $inicio_f_pao, $termino_f_pao)
    {
        if ($inicio_f_pao && $termino_f_pao)
            $query->whereHas('especialidades', function ($query) use ($inicio_f_pao, $termino_f_pao) {
                $query->whereHas('paos', function ($query) use ($inicio_f_pao, $termino_f_pao) {
                    $query->whereBetween('periodo_inicio', array($inicio_f_pao, $termino_f_pao));
                });
            });
    }

    public function scopeEstablecimiento($query, $etapas, $esatablecimiento_id)
    {
        //edf
        if (in_array(2, $etapas) && $esatablecimiento_id) {
            $query->whereHas('etapasDestinacion', function ($query) use ($esatablecimiento_id) {
                $query->where('establecimiento_id', $esatablecimiento_id);
            });
        } else if (in_array(1, $etapas) && $esatablecimiento_id) { //pao
            $query->whereHas('especialidades', function ($query) use ($esatablecimiento_id) {
                $query->whereHas('paos', function ($query) use ($esatablecimiento_id) {
                    $query->whereHas('devoluciones', function ($query) use ($esatablecimiento_id) {
                        $query->where('establecimiento_id', $esatablecimiento_id);
                    });
                });
            });
        }
    }
}
