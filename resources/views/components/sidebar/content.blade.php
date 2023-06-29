<x-perfect-scrollbar
    as="nav"
    aria-label="main"
    class="flex flex-col flex-1 gap-4 px-3"
>


    <x-sidebar.link
        title="Dashboard"
        href="{{ route('dashboard') }}"
        :isActive="request()->routeIs('dashboard')"
    >
        <x-slot name="icon">
            <x-icons.dashboard class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>

    <x-sidebar.dropdown
        title="Agency"
        :active="Str::startsWith(request()->route()->uri(), 'agency.index')"
        >
        <x-slot name="icon">
            <x-icons.agency-icon class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>

        <x-sidebar.sublink
            title="Manage Agents"
            href="{{ route('agency.index') }}"
            :active="request()->routeIs('agency.index')"
        />
    </x-sidebar.dropdown>

    
    <x-sidebar.link 
        title="Agent" 
        href="{{ route('agent') }}"
        :isActive="request()->routeIs('agent')"
>
        <x-slot name="icon">
            <x-icons.user class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>

    </x-sidebar.link>


    <x-sidebar.link 
        title="Triggers" 
        href="#"
        :isActive="request()->routeIs('triggers')"
>
        <x-slot name="icon">
            <x-icons.trigger-icon class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>

    </x-sidebar.link>


    <x-sidebar.link 
    title="Report" 
    href="#"
    :isActive="request()->routeIs('report')"
>
    <x-slot name="icon">
        <x-icons.report-icon class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
    </x-slot>

    </x-sidebar.link>

    <div
        x-transition
        x-show="isSidebarOpen || isSidebarHovered"
        class="text-sm text-gray-500"
    >
        MANAGEMENT
    </div>

    <x-sidebar.dropdown
        title="User Admin"
        :active="Str::startsWith(request()->route()->uri(), 'buttons')"
    >
        <x-slot name="icon">
            <x-heroicon-o-view-grid class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>

        <x-sidebar.sublink
            title="Manage Users"
            href="{{ route('users.index') }}"
            :active="request()->routeIs('users.index')"
        />
        {{-- <x-sidebar.sublink
            title="Manage Role"
            href="{{ route('buttons.icon') }}"
            :active="request()->routeIs('buttons.icon')"
        />
        <x-sidebar.sublink
            title="Manage Product"
            href="{{ route('buttons.text-icon') }}"
            :active="request()->routeIs('buttons.text-icon')"
        /> --}}
    </x-sidebar.dropdown>


    <x-sidebar.link 
    title="Settings" 
    href="#"
    :isActive="request()->routeIs('settings')"
>
    <x-slot name="icon">
        <x-icons.settings-icon class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
    </x-slot>

    </x-sidebar.link>

    <x-sidebar.link 
    title="Backup" 
    href="#"
    :isActive="request()->routeIs('Backup')"
>
    <x-slot name="icon">
        <x-icons.backup-icon class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
    </x-slot>

    </x-sidebar.link>


    <x-sidebar.link 
    title="Integrations" 
    href="{{ route('integrations') }}"
    :isActive="request()->routeIs('integrations')"
>
    <x-slot name="icon">
        <x-icons.integration-icon class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
    </x-slot>

    </x-sidebar.link>

</x-perfect-scrollbar>
