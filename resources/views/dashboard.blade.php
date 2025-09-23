<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-6">

        <!-- Lista de Marcas con scroll -->
        <div class="grid gap-6 md:grid-cols-3">
            <div x-data x-init="$el.scrollTop = $el.scrollHeight"
                class="relative rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-zinc-900 shadow p-4 flex flex-col max-h-[350px] overflow-y-auto">
                @forelse($marcas as $marca)
                    <div
                        class="mb-3 last:mb-0 rounded-lg p-3 bg-zinc-50 dark:bg-zinc-800 shadow-sm flex flex-col gap-1 hover:shadow-md transition">
                        <div class="flex items-center justify-between">
                            <flux:heading class="text-base font-semibold">{{ $marca->date }}</flux:heading>
                            @if ($marca->check_out)
                                <span class="text-red-500 font-medium text-sm">Salida registrada</span>
                            @else
                                <span class="text-green-500 font-medium text-sm">Entrada registrada</span>
                            @endif
                        </div>

                        <div class="flex justify-between mt-2 text-sm text-zinc-700 dark:text-zinc-300">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                                </svg>
                                Entrada: {{ $marca->check_in }}
                            </div>

                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                                </svg>
                                Salida: {{ $marca->check_out ?? '-' }}
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center p-4 text-zinc-500 dark:text-zinc-400 col-span-full">
                        No tienes marcas registradas aún.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Botones de Entrada/Salida -->
        <div class="flex flex-col md:flex-row gap-4">
            <form action="{{ route('attendance.checkIn') }}" method="POST" class="flex-1">
                @csrf
                <button type="submit"
                    class="w-full flex items-center justify-center gap-3 px-6 py-4 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-xl shadow-lg transition-transform transform hover:-translate-y-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path
                            d="M12.025 4.475q2.65 0 5 1.138T20.95 8.9q.175.225.113.4t-.213.3t-.35.113t-.35-.213q-1.375-1.95-3.537-2.987t-4.588-1.038t-4.55 1.038T3.95 9.5q-.15.225-.35.25t-.35-.1q-.175-.125-.213-.312t.113-.388q1.55-2.125 3.888-3.3t4.987-1.175m0 2.35q3.375 0 5.8 2.25t2.425 5.575q0 1.25-.887 2.088t-2.163.837t-2.187-.837t-.913-2.088q0-.825-.612-1.388t-1.463-.562t-1.463.563t-.612 1.387q0 2.425 1.438 4.05t3.712 2.275q.225.075.3.25t.025.375q-.05.175-.2.3t-.375.075q-2.6-.65-4.25-2.588T8.95 14.65q0-1.25.9-2.1t2.175-.85t2.175.85t.9 2.1q0 .825.625 1.388t1.475.562t1.45-.562t.6-1.388q0-2.9-2.125-4.875T12.05 7.8T6.975 9.775t-2.125 4.85q0 .6.113 1.5t.537 2.1q.075.225-.012.4t-.288.25t-.387-.012t-.263-.288q-.375-.975-.537-1.937T3.85 14.65q0-3.325 2.413-5.575t5.762-2.25m0-4.8q1.6 0 3.125.387t2.95 1.113q.225.125.263.3t-.038.35t-.25.275t-.425-.025q-1.325-.675-2.738-1.037t-2.887-.363q-1.45 0-2.85.338T6.5 4.425q-.2.125-.4.063t-.3-.263t-.05-.362t.25-.288q1.4-.75 2.925-1.15t3.1-.4m0 7.225q2.325 0 4 1.563T17.7 14.65q0 .225-.137.363t-.363.137q-.2 0-.35-.137t-.15-.363q0-1.875-1.388-3.137t-3.287-1.263t-3.262 1.263T7.4 14.65q0 2.025.7 3.438t2.05 2.837q.15.15.15.35t-.15.35t-.35.15t-.35-.15q-1.475-1.55-2.262-3.162T6.4 14.65q0-2.275 1.65-3.838t3.975-1.562M12 14.15q.225 0 .363.15t.137.35q0 1.875 1.35 3.075t3.15 1.2q.15 0 .425-.025t.575-.075q.225-.05.388.063t.212.337q.05.2-.075.35t-.325.2q-.45.125-.787.138t-.413.012q-2.225 0-3.863-1.5T11.5 14.65q0-.2.138-.35t.362-.15">
                        </path>
                    </svg>
                    Marcar Entrada
                </button>
            </form>

            <form action="{{ route('attendance.checkOut') }}" method="POST" class="flex-1">
                @csrf
                <button type="submit"
                    class="w-full flex items-center justify-center gap-3 px-6 py-4 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-xl shadow-lg transition-transform transform hover:-translate-y-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2a10 10 0 1 0 10 10A10.011 10.011 0 0 0 12 2Zm1 15h-2v-6H7l5-5 5 5h-4Z" />
                    </svg>
                    Marcar Salida
                </button>
            </form>
        </div>

    </div>
</x-layouts.app>
