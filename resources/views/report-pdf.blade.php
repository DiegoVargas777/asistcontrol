<h2 style="text-align:center;">Reporte de Asistencia</h2>
<table width="100%" border="1" cellspacing="0" cellpadding="5">
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