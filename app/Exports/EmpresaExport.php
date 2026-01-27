<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class EmpresaExport implements WithMultipleSheets
{
    protected $empresa;
    protected $userIds;

    public function __construct($empresa, $userIds = null)
    {
        $this->empresa = $empresa;
        $this->userIds = $userIds;
    }

    public function sheets(): array
    {
        return [
            new \App\Exports\Sheets\UsuariosSheet($this->empresa, $this->userIds),
        ];
    }
}
