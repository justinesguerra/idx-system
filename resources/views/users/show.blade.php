<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('Show User') }}
            </h2>
            <x-button href="{{ route('users.index') }}" variant="secondary"
                class="justify-center max-w-xs gap-2">
                <x-icons.arrow-left class="w-6 h-6" aria-hidden="true" />
                <span>Back</span>
            </x-button>
        </div>
    </x-slot>

    <div class="p-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Name:</strong>
                {{ $user->name }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Email:</strong>
                {{ $user->email }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Roles:</strong>
                @if(!empty($user->getRoleNames()))
                    @foreach($user->getRoleNames() as $v)
                        <span class="inline-block px-2 py-1 text-sm font-semibold text-green-800 bg-green-100 rounded-full">{{ $v }}</span>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
