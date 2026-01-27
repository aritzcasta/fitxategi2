<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use App\Models\Usuario;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UsuariosSheet implements FromArray, WithTitle, WithColumnWidths, WithStyles, ShouldAutoSize
{
    protected $empresa;
    protected $userIds;

    public function __construct($empresa, $userIds = null)
    {
        $this->empresa = $empresa;
        $this->userIds = $userIds;
    }

    public function array(): array
    {
        $rows = [['Nombre', 'Correo', 'Asistencias', 'Faltas sin justificar', 'Faltas justificadas', 'Fecha fin', 'Último fichaje', 'Hora entrada', 'Hora salida']];

        if ($this->userIds) {
            $ids = array_filter(array_map('intval', explode(',', (string)$this->userIds)));
            $usuarios = Usuario::whereIn('id', $ids)->where('empresa_id', $this->empresa->id)
                ->whereHas('rol', function($r) { $r->where('nombre', 'usuario'); })
                ->withCount('fichajes')
                ->with(['fichajes' => function ($q2) {
                    $q2->latest('fecha')->limit(1);
                }])
                ->get();
        } else {
            $usuarios = $this->empresa->usuarios()
                ->whereHas('rol', function($r) { $r->where('nombre', 'usuario'); })
                ->withCount('fichajes')
                ->with(['fichajes' => function ($q2) {
                    $q2->latest('fecha')->limit(1);
                }])
                ->get();
        }

        foreach ($usuarios as $u) {
            $fechaFin = null;
            if (!empty($u->fecha_fin)) {
                try {
                    $fechaFin = $u->fecha_fin->format('Y-m-d');
                } catch (\Exception $e) {
                    $fechaFin = $u->fecha_fin;
                }
            }

            $ultimoFecha = '';
            $horaEntrada = '';
            $horaSalida = '';
            try {
                $last = $u->fichajes->first() ?? null;
                if ($last) {
                    $ultimoFecha = optional($last->fecha)->format ? $last->fecha->format('Y-m-d') : $last->fecha;
                    $horaEntrada = $last->hora_entrada ?? '';
                    $horaSalida = $last->hora_salida ?? '';
                }
            } catch (\Exception $e) {
                // ignore
            }

            $rows[] = [
                $u->nombre,
                $u->email,
                $u->veces_registradas ?? '',
                $u->faltas_sin_justificar ?? '',
                $u->faltas_justificadas ?? '',
                $fechaFin,
                $ultimoFecha,
                $horaEntrada,
                $horaSalida,
            ];
        }

        return $rows;
    }

    public function columnWidths(): array
    {
        return [
            'A' => 24,
            'B' => 34,
            'C' => 14,
            'D' => 22,
            'E' => 20,
            'F' => 12,
            'G' => 14,
            'H' => 12,
            'I' => 12,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A:I')->getAlignment()->setWrapText(true);
        $sheet->getStyle('A1:I1')->getFont()->setBold(true);
        $sheet->freezePane('A2');

        return [];
    }

    public function title(): string
    {
        return 'Usuarios';
    }
}
