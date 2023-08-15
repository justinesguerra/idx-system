<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{-- {{ __('Favorite Properties') }} of {{ ucwords(strtolower($matched_users->firstOrFail()['first_name'])) }} {{ ucwords(strtolower($matched_users->firstOrFail()['last_name'])) }} --}}
            </h2>
            <x-button href="{{ route('leads.index') }}" variant="secondary" class="justify-center max-w-xs gap-2">
                <x-icons.arrow-left class="w-6 h-6" aria-hidden="true" />
                <span>Back</span>
            </x-button>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
        @if ($matched_properties->isEmpty())
            <p>No favorite properties have been added.</p>
        @else

            @foreach ($matched_properties as $index => $property)
                <div class="max-w-sm overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
                    <div class="p-4 flex items-center justify-between">
                        <div>
                            @php
                                $addDate = \Carbon\Carbon::parse($property['last_modified_time_stamp']);
                                $timeAgo = $addDate->diffForHumans();
                            @endphp
    
                            <p class="text-xs">
                                Added {{ $timeAgo }}
                            </p>
                        </div>
    
                        <div class="flex items-center">
                            <x-icons.heart class="w-4 h-4 text-[#1D70B7]" aria-hidden="true" />
                        </div>
                    </div>
                    <img class="w-full" src="https://placehold.co/600x400" alt="Sunset in the mountains">
                    <div class="px-4 py-4">
                        <p class="text-base">{{ $property['location_text']}}</p>
                    </div>
                    <div class="px-4 pb-2">
                        <span class="inline-block bg-[#1D70B7] rounded-full px-3 py-1 text-sm font-semibold text-white mr-2 mb-2">${{ number_format($property['price'], 2) }}</span>
                    </div>
                </div>
            @endforeach

        @endif
    </div>
</x-app-layout>
