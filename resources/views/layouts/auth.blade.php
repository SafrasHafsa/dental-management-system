<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sign In') — SmileCare</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4">

<div class="w-full max-w-md">

    {{-- Logo --}}
    <div class="text-center mb-8">
        <a href="{{ route('home') }}" class="inline-flex flex-col items-center gap-2">
            <div class="w-14 h-14 bg-primary-600 rounded-2xl flex items-center justify-center shadow-lg">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4.5 12.5c0-4.142 3.358-7.5 7.5-7.5s7.5 3.358 7.5 7.5c0 1.818-.648 3.484-1.716 4.784M12 17v4"/>
                </svg>
            </div>
            <span class="text-xl font-bold text-gray-900">SmileCare</span>
        </a>
        <p class="mt-2 text-sm text-gray-500">@yield('subtitle', 'Dental Clinic Management')</p>
    </div>

    {{-- Card --}}
    <div class="card shadow-card-hover">
        @yield('content')
    </div>

    {{-- Footer links --}}
    <p class="mt-6 text-center text-xs text-gray-400">
        &copy; {{ date('Y') }} SmileCare Dental Clinic
        &nbsp;·&nbsp;
        <a href="{{ route('home') }}" class="hover:text-primary-600 transition-colors">Back to website</a>
    </p>
</div>

</body>
</html>
