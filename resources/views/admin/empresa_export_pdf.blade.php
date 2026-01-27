<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Empresa {{ $empresa->nombre }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        .header { margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background: #f5f5f5; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Empresa: {{ $empresa->nombre }}</h1>
        <p>ID: {{ $empresa->id }}</p>
    </div>

    <h2>Usuarios</h2>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Asistencias</th>
                <th>Faltas sin justificar</th>
                <th>Faltas justificadas</th>
                <th>Fecha fin</th>
                <th>Último fichaje</th>
                <th>Hora entrada</th>
                <th>Hora salida</th>
            </tr>
        </thead>
        <tbody>
            @foreach($empresa->usuarios as $u)
                @php $last = $u->fichajes->first() ?? null; @endphp
                <tr>
                    <td>{{ $u->nombre }}</td>
                    <td>{{ $u->email }}</td>
                    <td>{{ $u->veces_registradas ?? '' }}</td>
                    <td>{{ $u->faltas_sin_justificar ?? '' }}</td>
                    <td>{{ $u->faltas_justificadas ?? '' }}</td>
                    <td>{{ optional($u->fecha_fin)->format('Y-m-d') }}</td>
                    <td>{{ $last ? (optional($last->fecha)->format('Y-m-d') ?? $last->fecha) : '' }}</td>
                    <td>{{ $last->hora_entrada ?? '' }}</td>
                    <td>{{ $last->hora_salida ?? '' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
