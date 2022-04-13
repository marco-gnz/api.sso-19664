<?php

namespace App\Exports;

use App\Models\Profesional;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeExport;
use \Maatwebsite\Excel\Sheet;



class ProfesionalesExport implements WithTitle, FromView, WithEvents
{

    use Exportable;

    public function __construct($profesionales, $total_especialidades,$total_pao, $total_devoluciones, $total_destinaciones)
    {
        $this->total_especialidades = $total_especialidades;
        $this->profesionales        = $profesionales;
        $this->total_pao            = $total_pao;
        $this->total_devoluciones   = $total_devoluciones;
        $this->total_destinaciones  = $total_destinaciones;
    }

    public function title(): string
    {
        return 'Profesionales';
    }

    public function registerEvents(): array
    {
        Sheet::macro('setOrientation', function (Sheet $sheet, $orientation) {
            $sheet->getDelegate()->getPageSetup()->setOrientation($orientation);
        });

        Sheet::macro('styleCells', function (Sheet $sheet, string $cellRange, array $style) {
            $sheet->getDelegate()->getStyle($cellRange)->applyFromArray($style);
        });

        $total = count($this->profesionales)+1;

        return [
            AfterSheet::class    => function (AfterSheet $event) use($total) {
                $event->sheet->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

                $event->sheet->styleCells(
                    "A1:BL{$total}",
                    [
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            ],
                        ],
                    ]
                );
            },
        ];
    }

    public function view(): View
    {
        return view('excel.profesionales', [
            'profesionales'         => $this->profesionales,
            'total_especialidades'  => $this->total_especialidades,
            'total_pao'             => $this->total_pao,
            'total_devoluciones'    => $this->total_devoluciones,
            'total_destinaciones'   => $this->total_destinaciones
        ]);
    }
}
