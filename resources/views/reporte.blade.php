<x-layouts.app :title="__('Reporte de Asistencia')">

  
        
        {{-- Contenedor del formulario y tabla --}}
        <div class="bg-gray-900 text-white p-6 rounded-lg shadow-lg">
            
            {{-- Formulario de búsqueda --}}
            <form action="{{ route('dashboard.report') }}" method="GET" class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium">Seleccionar Usuario</label>
                    <select name="query" class="mt-1 block w-full border rounded px-3 py-2 text-black">
                        <option value="">-- Todos --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ request('query') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium">Fecha Inicio</label>
                    <input type="date" name="fechaInicio" value="{{ request('fechaInicio') }}"
                           class="mt-1 block w-full border rounded px-3 py-2 text-black">
                </div>

                <div>
                    <label class="block text-sm font-medium">Fecha Fin</label>
                    <input type="date" name="fechaFin" value="{{ request('fechaFin') }}"
                           class="mt-1 block w-full border rounded px-3 py-2 text-black">
                </div>

                <div class="flex items-end">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded w-full">
                        Generar Reporte
                    </button>
                </div>
            </form>

            {{-- Resultados --}}
            @if(isset($attendances) && $attendances->isNotEmpty())
                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-700 rounded-lg shadow">
                        <thead class="bg-gray-800 text-gray-200">
                            <tr>
                                <th class="px-4 py-2 border border-gray-700">ID Usuario</th>
                                <th class="px-4 py-2 border border-gray-700">Nombre</th>
                                <th class="px-4 py-2 border border-gray-700">Email</th>
                                <th class="px-4 py-2 border border-gray-700">Fecha</th>
                                <th class="px-4 py-2 border border-gray-700">Hora Entrada</th>
                                <th class="px-4 py-2 border border-gray-700">Hora Salida</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($attendances as $asistencia)
                                <tr class="hover:bg-gray-800">
                                    <td class="px-4 py-2 border border-gray-700">{{ $asistencia->user->id }}</td>
                                    <td class="px-4 py-2 border border-gray-700">{{ $asistencia->user->name }}</td>
                                    <td class="px-4 py-2 border border-gray-700">{{ $asistencia->user->email }}</td>
                                    <td class="px-4 py-2 border border-gray-700">{{ \Carbon\Carbon::parse($asistencia->date)->format('d-m-Y') }}</td>
                                    <td class="px-4 py-2 border border-gray-700">{{ $asistencia->check_in }}</td>
                                    <td class="px-4 py-2 border border-gray-700">
                                        {{ $asistencia->check_out ?? 'Pendiente' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @elseif(isset($attendances))
                <div class="mt-6 p-4 bg-yellow-200 border-l-4 border-yellow-500 text-yellow-900 rounded">
                    No se encontraron registros con los filtros aplicados.
                </div>
            @endif
        </div>
    </div>

</x-layouts.app>