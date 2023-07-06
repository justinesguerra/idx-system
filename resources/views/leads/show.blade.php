<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('Listing Inquiry') }}
            </h2>
            <x-button href="{{ route('leads.index') }}" variant="secondary" class="justify-center max-w-xs gap-2">
                <x-icons.arrow-left class="w-6 h-6" aria-hidden="true" />
                <span>Back</span>
            </x-button>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
        @php
            $links = array_fill(0, 10, '');
        @endphp

        @foreach ($links as $index => $link)
            <div class="max-w-sm overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
                <div class="px-4 pt-2 flex items-center justify-between">
                    <h3 class="text-md font-semibold">Lead Name Here</h3>
                    <div class="flex items-center">
                        <x-icons.eye class="w-4 h-4" aria-hidden="true" />
                        <span class="text-xs ml-1">1</span>
                    </div>
                </div>
                <div class="px-4 pb-2">
                    <p class="text-xs">Last activity 21 days ago</p>
                </div>
                <img class="w-full" src="https://placehold.co/600x400" alt="Sunset in the mountains">
                <div class="px-4 py-4">
                    <p class="text-base">327 N 4450 W Point UY 84015</p>
                </div>
                <div class="px-4 pb-2">
                    <span class="inline-block bg-[#1D70B7] rounded-full px-3 py-1 text-sm font-semibold text-white mr-2 mb-2">Contact</span>
                </div>
            </div>
        @endforeach
    </div>
</x-app-layout>
