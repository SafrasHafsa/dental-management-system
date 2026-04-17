@extends('layouts.public')

@section('title', 'Our Services — SmileCare Dental Clinic')
@section('description', 'Explore our comprehensive range of dental services including preventive care, cosmetic dentistry, orthodontics, and more.')

@section('content')

<section class="bg-gradient-to-r from-primary-600 to-primary-700 text-white py-14">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl font-bold mb-3">Our Dental Services</h1>
        <p class="text-primary-100 max-w-xl mx-auto">Comprehensive care from prevention to advanced treatment — all under one roof.</p>
    </div>
</section>

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    @if($services->isEmpty())
        <div class="text-center py-16 text-gray-400">
            <svg class="w-16 h-16 mx-auto mb-4 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
            </svg>
            <p>No services listed yet. Check back soon!</p>
        </div>
    @else
        @foreach($services as $category => $group)
        <div class="mb-12">
            <h2 class="text-xl font-bold text-gray-900 mb-5 pb-3 border-b border-gray-200">{{ $category }}</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($group as $service)
                <div class="card hover:shadow-card-hover transition-shadow">
                    <div class="p-5">
                        <div class="flex items-start justify-between mb-2">
                            <h3 class="font-semibold text-gray-900">{{ $service->name }}</h3>
                            @if($service->base_price)
                                <span class="text-sm font-semibold text-primary-600 ml-3 whitespace-nowrap">Rs.{{ number_format($service->base_price, 0) }}</span>
                            @endif
                        </div>
                        @if($service->description)
                            <p class="text-sm text-gray-500 mb-3">{{ $service->description }}</p>
                        @endif
                        @if($service->duration_minutes)
                            <p class="text-xs text-gray-400 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $service->duration_minutes }} minutes
                            </p>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
    @endif

    <div class="mt-8 bg-primary-50 rounded-2xl p-8 text-center">
        <h3 class="text-xl font-bold text-gray-900 mb-2">Ready to book?</h3>
        <p class="text-gray-500 mb-5">Select your service when booking and our team will take care of the rest.</p>
        <a href="{{ route('book.index') }}" class="btn-primary">Book an Appointment</a>
    </div>
</section>

@endsection
