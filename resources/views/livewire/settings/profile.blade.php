<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component {
    public string $name = '';
    public string $email = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
    }

    /**
     * No hay lógica de actualización, ya que todo es solo lectura.
     */
};
?>

<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Profile')" :subheading="__('View your profile information')">
        <form class="my-6 w-full space-y-6">

            <!-- Nombre solo lectura -->
            <flux:input 
                :value="$name" 
                :label="__('Name')" 
                type="text" 
                readonly
            />

            <!-- Email solo lectura -->
            <flux:input 
                :value="$email" 
                :label="__('Email')" 
                type="email" 
                readonly
            />

        </form>
    </x-settings.layout>
</section>
