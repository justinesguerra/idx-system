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

    <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
        @if ($properties->isEmpty())
            <p>No favorite properties have been added.</p>
        @else

            @foreach ($properties as $index => $property)
                <div class="max-w-sm overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
                    <div class="p-4 flex items-center justify-between">
                        <div class="flex items-center">
                            <x-icons.heart class="w-4 h-4 text-[#1D70B7]" aria-hidden="true" />
                        </div>
                    </div>
                    <img 
                        loading="lazy" 
                        class="w-full h-48 object-cover" 
                        src="{{ empty($property['image']) ? asset('images/placeholder.png') : $property['image'] }}" 
                        onerror="this.onerror=null; this.src='{{ asset('images/placeholder.png') }}';"
                        alt="{{ $property['location_text'] or 'Property Image' }}"
                    >


                    <div class="px-4 py-4">
                        <p class="text-base">{{ $property['location_text'] }}</p>
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
