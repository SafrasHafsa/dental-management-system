<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' style='background:%234f46e5;border-radius:4px' fill='none' stroke='white' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><path d='M4.5 12.5c0-4.142 3.358-7.5 7.5-7.5s7.5 3.358 7.5 7.5c0 1.818-.648 3.484-1.716 4.784M12 17v4'/></svg>">
    <title>@yield('title', 'Dashboard') — City Dental Surgery</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
    <style>
        [x-cloak]{display:none!important}
        /* DataTables Tailwind overrides */
        .dataTables_wrapper .dataTables_filter input{padding:.375rem .75rem;border:1px solid #e5e7eb;border-radius:.75rem;font-size:.875rem;outline:none;}
        .dataTables_wrapper .dataTables_filter input:focus{border-color:#6366f1;box-shadow:0 0 0 2px rgba(99,102,241,.15)}
        .dataTables_wrapper .dataTables_length select{padding:.375rem 2rem .375rem .75rem;border:1px solid #e5e7eb;border-radius:.75rem;font-size:.875rem;outline:none;appearance:none;background:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24'%3E%3Cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E") no-repeat right .5rem center/1rem;}
        .dataTables_wrapper .dataTables_info{font-size:.75rem;color:#6b7280;}
        .dataTables_wrapper .dataTables_paginate .paginate_button{padding:.25rem .625rem;border-radius:.5rem;font-size:.8125rem;cursor:pointer;color:#374151!important;margin:0 1px;}
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover{background:#f3f4f6!important;color:#111827!important;}
        .dataTables_wrapper .dataTables_paginate .paginate_button.current{background:#111827!important;color:#fff!important;border-radius:.5rem;}
        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled{color:#d1d5db!important;cursor:default;}
        table.dataTable thead th{border-bottom:1px solid #f3f4f6!important;}
        table.dataTable tbody tr:hover{background:#f9fafb;}
        table.dataTable.no-footer{border-bottom:none!important;}
        .dt-toolbar{display:flex;align-items:center;justify-content:space-between;padding:.75rem 1.25rem;border-bottom:1px solid #f3f4f6;}
        .dt-footer{display:flex;align-items:center;justify-content:space-between;padding:.75rem 1.25rem;border-top:1px solid #f3f4f6;}
    </style>
    @stack('styles')
</head>
<body class="bg-gray-100 font-sans antialiased" x-data="sidebar()">

<div class="flex h-screen overflow-hidden">

    {{-- ════════════════════════════════════════════
         DARK SIDEBAR
    ════════════════════════════════════════════ --}}
    {{-- Mobile overlay --}}
    <div x-show="open" @click="close()"
         x-transition:enter="transition-opacity ease-linear duration-200"
         x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-200"
         x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-20 bg-black/60 lg:hidden"></div>

    {{-- Sidebar panel --}}
    <aside :class="open ? 'translate-x-0' : '-translate-x-full'"
           class="fixed inset-y-0 left-0 z-30 w-60 bg-gray-950 text-gray-300
                  transform transition-transform duration-200 ease-in-out
                  lg:translate-x-0 lg:static lg:z-auto flex flex-col">

        {{-- Logo --}}
        <div class="flex items-center gap-3 px-5 h-16 border-b border-white/5 flex-shrink-0">
            <div class="w-9 h-9 bg-primary-500 rounded-xl flex items-center justify-center shadow-lg">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4.5 12.5c0-4.142 3.358-7.5 7.5-7.5s7.5 3.358 7.5 7.5c0 1.818-.648 3.484-1.716 4.784M12 17v4"/>
                </svg>
            </div>
            <div>
                <p class="text-sm font-bold text-white leading-none">CityDentalSurgery</p>
                <p class="text-xs text-gray-500 mt-0.5">Dental Clinic</p>
            </div>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 overflow-y-auto px-3 py-5 space-y-0.5">
            @yield('sidebar-nav')
        </nav>

        {{-- User profile at bottom --}}
        <div class="flex-shrink-0 border-t border-white/5 p-3">
            @if(auth()->user()->isPatient())
            <a href="{{ route('patient.profile') }}"
            @elseif(auth()->user()->isDoctor())
            <a href="{{ route('doctor.dashboard') }}"
            @elseif(auth()->user()->isStaff())
            <a href="{{ route('staff.dashboard') }}"
            @else
            <a href="{{ route('admin.dashboard') }}"
            @endif
               class="flex items-center gap-3 px-2 py-2 rounded-xl hover:bg-white/5 transition-colors">
                <img src="{{ auth()->user()->avatarUrl() }}" alt="avatar"
                     class="w-8 h-8 rounded-full object-cover flex-shrink-0 ring-2 ring-white/10">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-500 truncate capitalize">
                        {{ auth()->user()->roles->first()?->display_name ?? 'User' }}
                    </p>
                </div>
            </a>
        </div>
    </aside>

    {{-- ════════════════════════════════════════════
         MAIN CONTENT
    ════════════════════════════════════════════ --}}
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

        {{-- Top bar --}}
        <header class="flex items-center justify-between h-16 px-6 bg-white border-b border-gray-200 flex-shrink-0 shadow-sm">
            <div class="flex items-center gap-4">
                {{-- Mobile menu toggle --}}
                <button @click="toggle()" class="lg:hidden p-2 rounded-xl text-gray-500 hover:bg-gray-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                {{-- Search bar --}}
                {{-- <div class="hidden md:flex items-center gap-2 bg-gray-100 rounded-xl px-3 py-2 w-72">
                    <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    
                <input type="text" id="global-search" placeholder="Search..." class="bg-transparent text-sm text-gray-600 outline-none w-full placeholder-gray-400">
                </div> --}}
            </div>

            <div class="flex items-center gap-2">
                {{-- Date --}}
                <span class="hidden sm:block text-xs text-gray-400 mr-2">{{ now()->format('D, M d Y') }}</span>

                {{-- Notification bell --}}
                @include('partials.notifications-bell')

                {{-- Avatar dropdown --}}
                <div class="relative ml-1" x-data="{ open: false }">
                    <button @click="open = !open" class="focus:outline-none">
                        <img src="{{ auth()->user()->avatarUrl() }}" alt="avatar"
                             class="w-8 h-8 rounded-full object-cover ring-2 ring-gray-200 hover:ring-primary-400 transition-all cursor-pointer">
                    </button>
                    <div x-show="open"
                         @click.outside="open = false"
                         x-cloak
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-100"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 top-10 w-48 bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden z-50">
                        <div class="px-4 py-3 border-b border-gray-100">
                            <p class="text-sm font-semibold text-gray-900 truncate">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-400 truncate">{{ auth()->user()->email }}</p>
                        </div>
                        <div class="py-1">
                            @if(auth()->user()->isPatient())
                            <a href="{{ route('patient.profile') }}"
                               class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                My Profile
                            </a>
                            @endif
                            <div class="border-t border-gray-100 mt-1 pt-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                            class="flex items-center gap-3 w-full px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                        </svg>
                                        Sign Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        {{-- Flash messages --}}
        @foreach(['success' => 'alert-success', 'error' => 'alert-error', 'warning' => 'alert-warning', 'info' => 'alert-info'] as $type => $class)
            @if(session($type))
                <div x-data="flash()" x-show="show" x-transition class="mx-6 mt-4">
                    <div class="{{ $class }}">
                        <span>{{ session($type) }}</span>
                        <button @click="show=false" class="ml-auto opacity-60 hover:opacity-100">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </div>
                </div>
            @endif
        @endforeach

        @if($errors->any())
            <div class="mx-6 mt-4">
                <div class="alert-error">
                    <ul class="list-disc list-inside text-sm space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        {{-- Page content --}}
        <main class="flex-1 overflow-y-auto p-6">
            @yield('content')
        </main>
    </div>

</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script>
// Global DataTable initializer
window.initDT = function(selector, opts) {
    const table = $(selector).DataTable(Object.assign({
        pageLength: 15,
        lengthMenu: [[10,15,25,50,100],['10','15','25','50','100']],
        language: {search:'', searchPlaceholder:'Search…', lengthMenu:'Show _MENU_', info:'_START_–_END_ of _TOTAL_'},
        dom: '<"dt-toolbar"lf>t<"dt-footer"ip>',
    }, opts || {}));

    // Connect global search bar to DataTable
    $('#global-search').off('keyup').on('keyup', function() {
        table.search(this.value).draw();
    });

    return table;
};
</script>
@stack('scripts')
</body>
</html>
