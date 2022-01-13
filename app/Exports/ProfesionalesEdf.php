<?php

namespace App\Exports;

use App\Models\Profesional;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;

class ProfesionalesEdf implements WithTitle, FromView
{

    use Exportable;

    public function __construct($profesionales, $cantidad_destinacion, $cantidad_formacion)
    {
        $this->profesionales        = $profesionales;
        $this->cantidad_destinacion = $cantidad_destinacion;
        $this->cantidad_formacion   = $cantidad_formacion;
    }

    public function title(): string
    {
        return 'EDF';
    }

    public function view(): View
    {
        return view('excel.edf', [
            'profesionales' => $this->profesionales,
            'cantidad_destinacion' => $this->cantidad_destinacion,
            'cantidad_formacion'    => $this->cantidad_formacion
        ]);
    }
}
