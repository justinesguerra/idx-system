<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('Lead Management') }}
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
            <table id="your-table-id"
                class="min-w-full divide-y divide-gray-200 shadow-sm overflow-hidden border-b border-gray-200 sm:rounded-lg">

                <thead class="bg-gray-50 dark:bg-dark-eval-1">
                    <tr>
                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                            No
                        </th>
                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                            <a href="{{ route('leads.index', ['sort' => 'first_name', 'direction' => (request('sort') === 'first_name' && request('direction') === 'asc') ? 'desc' : 'asc']) }}">
                                Name
                                @if(request('sort') === 'first_name')
                                    @if(request('direction') === 'asc')
                                        <i class="fas fa-sort-up text-blue-500"></i>
                                    @else
                                        <i class="fas fa-sort-down text-blue-500"></i>
                                    @endif
                                @else
                                    <i class="fas fa-sort"></i>
                                @endif
                            </a>
                        </th>
                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                            <a href="{{ route('leads.index', ['sort' => 'email', 'direction' => (request('sort') === 'email' && request('direction') === 'asc') ? 'desc' : 'asc']) }}">
                                Email
                                @if(request('sort') === 'email')
                                    @if(request('direction') === 'asc')
                                        <i class="fas fa-sort-up text-blue-500"></i>
                                    @else
                                        <i class="fas fa-sort-down text-blue-500"></i>
                                    @endif
                                @else
                                    <i class="fas fa-sort"></i>
                                @endif
                            </a>
                        </th>
                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                            Action
                        </th>
                    </tr>
                </thead>
                


                <tbody class="bg-white divide-y divide-gray-200 dark:bg-dark-eval-1">
                    @foreach ($paginatedLeadData as $key => $user)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ ++$i }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $user['first_name'] }} {{ $user['last_name'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $user['email'] }}</td>
                            <td class="px-6 py-4 text-sm text-right whitespace-nowrap">
                                <div class="flex gap-2">
                                    <x-button href="{{ route('leads.show', $user['id']) }}" variant="primary"
                                        class="max-w-xs">
                                        <span>View Activity</span>
                                    </x-button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <hr>
        <div class="mt-6">
            {!! $paginatedLeadData->links() !!}
        </div>
    </div>
</x-app-layout>
