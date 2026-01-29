<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;

class EmpresaSheet implements FromArray, WithTitle
{
    protected $empresa;

    public function __construct($empresa)
    {
        $this->empresa = $empresa;
    }

    public function array(): array
    {
        return [
            ['Campo', 'Valor'],
            ['ID', $this->empresa->id],
            ['Nombre', $this->empresa->nombre],
        ];
    }

    public function title(): string
    {
        return 'Empresa';
    }
}
