<?php

namespace App\Exports;

use App\Models\Profesional;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ProfesionalesPao implements WithTitle, FromView
{
    use Exportable;
    /**
     * @return \Illuminate\Support\Collection
     */

    public function __construct($profesionales, $cantidad, $cantidad_devo)
    {
        $this->profesionales    = $profesionales;
        $this->cantidad         = $cantidad;
        $this->cantidad_devo    = $cantidad_devo;
    }

    public function title(): string
    {
        return 'PAO';
    }

    public function view(): View
    {
        return view('excel.pao', [
            'profesionales' => $this->profesionales,
            'cantidad'      => $this->cantidad,
            'cantidad_devo' => $this->cantidad_devo
        ]);
    }
}
