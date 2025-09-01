<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Asistencia</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            color: #333;
        }
        h1 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 5px;
        }
        .header-info {
            margin-bottom: 20px;
            font-size: 12px;
        }
        .header-info p {
            margin: 2px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th {
            background-color: #2c3e50;
            color: white;
            padding: 6px;
            border: 1px solid #555;
            text-align: center;
        }
        td {
            padding: 6px;
            border: 1px solid #ccc;
            text-align: center;
        }
        .footer {
            margin-top: 30px;
            font-size: 10px;
            text-align: center;
            color: #777;
        }
    </style>
</head>
<body>

    {{-- Encabezado --}}
    <h1>Reporte de Asistencia</h1>

    {{-- Información del reporte --}}
    <div class="header-info">
        <p><strong>Generado por:</strong> {{ auth()->user()->name }}</p>
        <p><strong>Fecha de emisión:</strong> {{ \Carbon\Carbon::now()->format('d-m-Y H:i') }}</p>
        @if(request('fechaInicio') && request('fechaFin'))
            <p><strong>Rango de fechas:</strong> 
                {{ \Carbon\Carbon::parse(request('fechaInicio'))->format('d-m-Y') }} 
                a 
                {{ \Carbon\Carbon::parse(request('fechaFin'))->format('d-m-Y') }}
            </p>
        @endif
    </div>

    {{-- Tabla de datos --}}
    <table>
        <thead>
            <tr>
                <th>ID Usuario</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Fecha</th>
                <th>Hora Entrada</th>
                <th>Hora Salida</th>
            </tr>
        </thead>
        <tbody>
            @foreach($attendances as $asistencia)
                <tr>
                    <td>{{ $asistencia->user->id }}</td>
                    <td>{{ $asistencia->user->name }}</td>
                    <td>{{ $asistencia->user->email }}</td>
                    <td>{{ \Carbon\Carbon::parse($asistencia->date)->format('d-m-Y') }}</td>
                    <td>{{ $asistencia->check_in }}</td>
                    <td>{{ $asistencia->check_out ?? 'Pendiente' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Pie de página --}}
    <div class="footer">
        <p>Documento generado automáticamente por el sistema de control de asistencia.</p>
        <p>© {{ date('Y') }} Tu Empresa - Todos los derechos reservados</p>
    </div>

</body>
</html>
