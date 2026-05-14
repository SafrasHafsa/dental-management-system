@extends('layouts.public')

@section('title', 'City Dental Surgery Dental Clinic — Your Smile, Our Priority')
@section('description', 'Professional dental care for the whole family in Manila. Book your appointment online today.')

@section('content')

{{-- ── Hero ─────────────────────────────────────────────── --}}
<section class="relative bg-gradient-to-br from-primary-600 via-primary-700 to-primary-800 text-white overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
            <defs><pattern id="grid" width="60" height="60" patternUnits="userSpaceOnUse">
                <path d="M 60 0 L 0 0 0 60" fill="none" stroke="white" stroke-width="1"/>
            </pattern></defs>
            <rect width="100%" height="100%" fill="url(#grid)"/>
        </svg>
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32">
        <div class="max-w-2xl">
            <span class="inline-block bg-white/20 text-white text-xs font-semibold px-3 py-1 rounded-full mb-4 uppercase tracking-wide">
                Trusted Dental Care Since 2023

            </span>
            <h1 class="text-4xl lg:text-6xl font-extrabold leading-tight mb-6">
                Your Healthy Smile<br>
                <span class="text-primary-200">Starts Here</span>
            </h1>
            <p class="text-lg text-primary-100 mb-8 max-w-xl">
                City Dental Surgery offers comprehensive dental services with compassion and expertise.
                Book your appointment in minutes — no long waits, no hassle.
            </p>
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('book.index') }}"
                   class="inline-flex items-center gap-2 bg-white text-primary-700 px-6 py-3 rounded-xl font-semibold hover:bg-primary-50 transition-colors shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Book Appointment
                </a>
                <a href="{{ route('services') }}"
                   class="inline-flex items-center gap-2 border border-white/40 text-white px-6 py-3 rounded-xl font-semibold hover:bg-white/10 transition-colors">
                    Our Services
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
    {{-- Decorative circles --}}
    <div class="absolute right-0 top-1/2 -translate-y-1/2 w-96 h-96 bg-white/5 rounded-full -mr-32 hidden lg:block"></div>
    <div class="absolute right-32 top-16 w-40 h-40 bg-white/5 rounded-full hidden lg:block"></div>
</section>

{{-- ── Trust badges ──────────────────────────────────────── --}}
<section class="bg-gray-50 border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
            @foreach([
                ['1,500+', 'Happy Patients', 'text-primary-600'],
                ['3+', 'Years Experience', 'text-green-600'],
                ['4', 'Expert Doctors', 'text-purple-600'],
                ['10+', 'Dental Services', 'text-orange-600'],
            ] as [$num, $label, $color])
            <div class="p-4">
                <p class="text-3xl font-extrabold {{ $color }}">{{ $num }}</p>
                <p class="text-sm text-gray-500 mt-1">{{ $label }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── Services preview ──────────────────────────────────── --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
    <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-gray-900 mb-3">Our Dental Services</h2>
        <p class="text-gray-500 max-w-xl mx-auto">From routine checkups to advanced procedures, we cover all your dental needs with the latest technology.</p>
    </div>

    @if($services->isEmpty())
        <p class="text-center text-gray-400">Services coming soon.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($services->take(6) as $category => $group)
            <div class="card hover:shadow-card-hover transition-shadow">
                <div class="p-6">
                    <div class="w-10 h-10 bg-primary-50 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">{{ $category }}</h3>
                    <ul class="space-y-1">
                        @foreach($group->take(3) as $service)
                        <li class="text-sm text-gray-500 flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-primary-400 flex-shrink-0"></span>
                            {{ $service->name }}
                            @if($service->base_price)
                                <span class="ml-auto font-medium text-gray-700">Rs.{{ number_format($service->base_price, 0) }}</span>
                            @endif
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-8">
            <a href="{{ route('services') }}" class="btn-secondary">View All Services</a>
        </div>
    @endif
</section>

{{-- ── How it works ──────────────────────────────────────── --}}
<section class="bg-gray-50 py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-3">How It Works</h2>
            <p class="text-gray-500">Book your appointment in 3 simple steps</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach([
                ['1', 'Choose a Service & Doctor', 'Browse our services, select your preferred doctor and pick an available time slot.', 'bg-primary-50 text-primary-600'],
                ['2', 'Get Confirmed', 'Our staff will review and confirm your booking. You\'ll receive a confirmation notification.', 'bg-green-50 text-green-600'],
                ['3', 'Visit & Smile', 'Come in for your appointment. Our team will take great care of you from start to finish.', 'bg-purple-50 text-purple-600'],
            ] as [$step, $title, $desc, $colors])
            <div class="text-center">
                <div class="w-14 h-14 {{ $colors }} rounded-2xl flex items-center justify-center text-2xl font-bold mx-auto mb-4">
                    {{ $step }}
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">{{ $title }}</h3>
                <p class="text-sm text-gray-500">{{ $desc }}</p>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-10">
            <a href="{{ route('book.index') }}" class="btn-primary">Book Now — It's Free</a>
        </div>
    </div>
</section>

{{-- ── CTA Banner ────────────────────────────────────────── --}}
<section class="bg-primary-600 py-16">
    <div class="max-w-3xl mx-auto text-center px-4">
        <h2 class="text-3xl font-bold text-white mb-4">Ready for a Brighter Smile?</h2>
        <p class="text-primary-100 mb-8">Join thousands of satisfied patients who trust City Dental Surgery for their dental health.</p>
        <a href="{{ route('book.index') }}"
           class="inline-block bg-white text-primary-700 px-8 py-3 rounded-xl font-semibold hover:bg-primary-50 transition-colors shadow">
            Schedule Your Visit
        </a>
    </div>
</section>

@endsection
