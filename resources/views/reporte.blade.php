<x-layouts.app :title="__('Dashboard')">
   
    <div>
    <form wire:submit.prevent="generar" class="mb-6 space-y-4">
        <div>
            <label class="block text-sm font-medium">Fecha Inicio</label>
            <input type="date" wire:model="fechaInicio" class="mt-1 block w-full border rounded px-3 py-2">
        </div>

        <div>
            <label class="block text-sm font-medium">Fecha Fin</label>
            <input type="date" wire:model="fechaFin" class="mt-1 block w-full border rounded px-3 py-2">
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Generar Reporte
        </button>
    </form>

  {{---   @if($resultados)
        <h2 class="text-xl font-semibold mb-4">Resultados:</h2>
        <table class="min-w-full bg-white border">
            <thead>
                <tr>
                    <th class="px-4 py-2 border">ID</th>
                    <th class="px-4 py-2 border">Fecha</th>
                    <th class="px-4 py-2 border">Monto</th>
                </tr>
            </thead>
            <tbody>
                @foreach($resultados as $venta)
                    <tr>
                        <td class="px-4 py-2 border">{{ $venta->id }}</td>
                        <td class="px-4 py-2 border">{{ $venta->fecha }}</td>
                        <td class="px-4 py-2 border">${{ number_format($venta->monto, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif 
    --}}

</x-layouts.app>
