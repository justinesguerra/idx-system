<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                Listings Page
            </h2>
            <x-button href="{{ route('leads.index') }}" variant="secondary" class="justify-center max-w-xs gap-2">
                <x-icons.arrow-left class="w-6 h-6" aria-hidden="true" />
                <span>Back</span>
            </x-button>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-4 items-stretch">
        @if ($properties->isEmpty())
            <p>No favorite properties have been added.</p>
        @else

        @foreach ($properties as $index => $property)
        <div class="max-w-sm overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
            <div class="relative h-48 overflow-hidden">
                <img 
                    loading="lazy" 
                    class="absolute top-0 left-0 w-full h-full object-cover" 
                    src="{{ empty($property['image']) ? asset('images/placeholder.png') : $property['image'] }}" 
                    onerror="this.onerror=null; this.src='{{ asset('images/placeholder.png') }}';"
                    alt="{{ $property['location_text'] or 'Property Image' }}"
                >
                <div class="absolute top-2 left-2 bg-blue-600 text-white px-3 py-1 rounded">
                    {{ $property['property_title'] }}
                </div>
            </div>
            

            <div class="px-4 py-4">
                <p class="text-lg font-semibold mb-2">${{ number_format($property['price_numeric'], 2) }}</p>
                <p class="text-base">{{ $property['location_text'] }}</p>
                <div class="flex justify-start mt-2 gap-3">
                    <div class="flex items-center">
                        {{ $property['bedrooms'] }} 
                        <x-icons.bed class="w-5 h-5 mx-3" aria-hidden="true" /> |
                    </div>
                    <div class="flex items-center">
                        {{ $property['bathrooms'] }} 
                        <x-icons.bath class="w-5 h-5 mx-3" aria-hidden="true" /> |
                    </div>
                    <div>
                        {{ $property['area'] }}
                    </div>
                </div>
            </div>
        </div>
    @endforeach

        @endif
    </div>

    {{-- Pagination --}}
    <div class="mt-4 d-flex justify-content-between">
        <div>
            {{ $properties->links() }}
        </div>
    </div>

</x-app-layout>
