<x-app-layout>
    @if(auth()->user()->role == 0)
        @livewire('inventory-index')
    @endif
</x-app-layout>
