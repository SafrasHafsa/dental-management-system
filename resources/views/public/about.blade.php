@extends('layouts.public')

@section('title', 'About Us — SmileCare Dental Clinic')

@section('content')

<section class="bg-gradient-to-r from-primary-600 to-primary-700 text-white py-14">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl font-bold mb-3">About SmileCare</h1>
        <p class="text-primary-100 max-w-xl mx-auto">Dedicated to delivering exceptional dental care with compassion since 2010.</p>
    </div>
</section>

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center mb-16">
        <div>
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Our Mission</h2>
            <p class="text-gray-600 mb-4">
                At SmileCare Dental Clinic, we believe everyone deserves a healthy, beautiful smile. Founded in 2010,
                our clinic has grown to become one of Manila's most trusted dental practices, combining the latest
                dental technology with a warm, patient-centered approach.
            </p>
            <p class="text-gray-600 mb-6">
                Our team of experienced dentists and dental professionals are committed to providing comprehensive,
                compassionate care for patients of all ages — from children's first visits to complex restorative procedures.
            </p>
            <div class="grid grid-cols-2 gap-4">
                @foreach([
                    ['2,500+', 'Patients Served'],
                    ['15+', 'Years of Excellence'],
                    ['8', 'Expert Dentists'],
                    ['20+', 'Procedures Offered'],
                ] as [$num, $label])
                <div class="bg-primary-50 rounded-xl p-4 text-center">
                    <p class="text-2xl font-bold text-primary-600">{{ $num }}</p>
                    <p class="text-xs text-gray-500 mt-0.5">{{ $label }}</p>
                </div>
                @endforeach
            </div>
        </div>
        <div class="bg-gray-100 rounded-2xl overflow-hidden h-80 flex items-center justify-center">
            <div class="text-center text-gray-400">
                <svg class="w-20 h-20 mx-auto mb-3 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                <p class="text-sm">SmileCare Clinic</p>
            </div>
        </div>
    </div>

    {{-- Values --}}
    <div class="mb-16">
        <h2 class="text-2xl font-bold text-gray-900 mb-8 text-center">Why Choose SmileCare?</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach([
                ['Expert Team', 'Our dentists hold advanced degrees and regularly attend continuing education to bring you the best care.', 'bg-blue-50 text-blue-600'],
                ['Modern Technology', 'We use state-of-the-art equipment including digital X-rays, intraoral cameras, and laser dentistry.', 'bg-green-50 text-green-600'],
                ['Patient Comfort', 'We create a warm, stress-free environment — because we know visiting the dentist can be intimidating.', 'bg-purple-50 text-purple-600'],
            ] as [$title, $desc, $colors])
            <div class="card p-6 text-center">
                <div class="w-12 h-12 {{ $colors }} rounded-2xl mx-auto mb-4 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">{{ $title }}</h3>
                <p class="text-sm text-gray-500">{{ $desc }}</p>
            </div>
            @endforeach
        </div>
    </div>

    {{-- CTA --}}
    <div class="bg-primary-600 rounded-2xl p-10 text-center text-white">
        <h3 class="text-2xl font-bold mb-3">Experience SmileCare</h3>
        <p class="text-primary-100 mb-6">Book your first appointment today and join our growing family of healthy smiles.</p>
        <a href="{{ route('book.index') }}" class="inline-block bg-white text-primary-700 px-8 py-3 rounded-xl font-semibold hover:bg-primary-50 transition-colors">
            Book Appointment
        </a>
    </div>
</section>

@endsection
