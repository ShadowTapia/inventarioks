<x-fondo-card>
    <x-slot name="title">
        {{ $title }}
    </x-slot>
    <x-slot name="content">
        <x-notification />
        <livewire:users.users-table />
    </x-slot>
</x-fondo-card>
