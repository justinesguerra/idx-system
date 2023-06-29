<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('Manage Users') }}
            </h2>
        </div>
    </x-slot>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <div class="p-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-left">No</th>
                        <th class="px-4 py-2 text-left">Name</th>
                        <th class="px-4 py-2 text-left">Email</th>
                        <th class="px-4 py-2 text-left">Roles</th>
                        <th class="px-4 py-2 text-left">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $key => $user)
                        <tr>
                            <td class="px-4 py-2">{{ ++$i }}</td>
                            <td class="px-4 py-2">{{ $user->name }}</td>
                            <td class="px-4 py-2">{{ $user->email }}</td>
                            <td class="px-4 py-2">
                                @if (!empty($user->getRoleNames()))
                                    @foreach ($user->getRoleNames() as $v)
                                        <span class="inline-block px-2 py-1 text-sm font-semibold text-green-800 bg-green-100 rounded-full">{{ $v }}</span>
                                    @endforeach
                                @endif
                            </td>
                            <td class="px-4 py-2">
                                <div class="flex gap-2">
                                    <x-button href="{{ route('users.show', $user->id) }}" variant="primary" class="max-w-xs">
                                        <span>Show</span>
                                    </x-button>
                                    <x-button href="{{ route('users.edit', $user->id) }}" variant="primary" class="max-w-xs">
                                        <span>Edit</span>
                                    </x-button>
                                    {{ html()->form('DELETE', route('users.destroy', $user->id))->open() }}
                                        <x-button variant="danger" pill>
                                            <span>Delete</span>
                                        </x-button>
                                    {{ html()->form()->close() }}
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {!! $data->render() !!}
    </div>
</x-app-layout>
