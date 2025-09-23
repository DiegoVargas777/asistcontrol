<x-layouts.app :title="__('Gestion de usuarios')">



    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6">{{ __('Gestión de Usuarios') }}</h1>

        @can('crear usuario')
            <flux:button as="a" href="{{ route('admin.users.create') }}" variant="primary" class="mb-4">
                {{ __('Crear Usuario') }}
            </flux:button>
        @endcan

        @if (session('success'))
            <div class="mb-4 p-3 bg-green-600 text-white rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto border rounded-lg bg-zinc-900 text-white">
            <table class="min-w-full divide-y divide-zinc-700">
                <thead class="bg-zinc-800">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium">{{ __('Nombre') }}</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">{{ __('Email') }}</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">{{ __('Roles') }}</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">{{ __('Acciones') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-700">
                    @foreach ($users as $user)
                        <tr>
                            <td class="px-6 py-4">{{ $user->name }}</td>
                            <td class="px-6 py-4">{{ $user->email }}</td>
                            <td class="px-6 py-4">{{ $user->roles->pluck('name')->join(', ') }}</td>
                            <td class="px-6 py-4 flex gap-2">
                                @can('editar usuario')
                                    <flux:button as="a" href="{{ route('admin.users.edit', $user) }}"
                                        variant="outline" size="sm">{{ __('Editar') }}</flux:button>
                                @endcan
                                @can('borrar usuario')
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                        onsubmit="return confirm('{{ __('¿Eliminar usuario?') }}');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-sm">
                                            {{ __('Eliminar') }}
                                        </button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>



</x-layouts.app>
