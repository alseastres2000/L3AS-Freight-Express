<x-app-layout>
    @if(auth()->user()->role == 0)
        @livewire('user-index')
    @else
        @livewire('inventory-index')
    @endif
</x-app-layout>
