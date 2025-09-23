<x-layouts.app :title="__('Reporte de Asistencia')">

    <div class="container mx-auto p-6 max-w-lg">
        <h1 class="text-2xl font-bold mb-6">{{ __('Crear Usuario') }}</h1>

        <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-4">
            @csrf
            <flux:input name="name" type="text" label="{{ __('Nombre') }}" placeholder="{{ __('Nombre completo') }}"
                required />
            <flux:input name="email" type="email" label="{{ __('Email') }}" placeholder="email@example.com"
                required />
            <flux:input name="password" type="password" label="{{ __('Contraseña') }}"
                placeholder="{{ __('Contraseña') }}" required />

            <flux:select name="role" label="{{ __('Rol') }}" required>
                <option value="">{{ __('Seleccionar rol') }}</option>
                @foreach ($roles as $role)
                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                @endforeach
            </flux:select>

            <flux:button type="submit" variant="primary">{{ __('Crear Usuario') }}</flux:button>
        </form>
    </div>


</x-layouts.app>
