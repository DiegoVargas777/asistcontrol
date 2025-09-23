<x-layouts.app :title="__('Edicion de usuario')">
    <div class="container mx-auto p-6 max-w-lg">
        <h1 class="text-2xl font-bold mb-6">{{ __('Editar Usuario') }}</h1>

        <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <flux:input name="name" type="text" label="{{ __('Nombre') }}" :value="$user->name" required />
            <flux:input name="email" type="email" label="{{ __('Email') }}" :value="$user->email" required />
            <flux:input name="password" type="password" label="{{ __('Nueva Contraseña') }}"
                placeholder="{{ __('Dejar en blanco para no cambiar') }}" />

            <flux:select name="role" label="{{ __('Rol') }}" required>
                @foreach ($roles as $role)
                    <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                        {{ $role->name }}</option>
                @endforeach
            </flux:select>

            <flux:button type="submit" variant="primary">{{ __('Actualizar Usuario') }}</flux:button>
        </form>
    </div>
</x-layouts.app>
