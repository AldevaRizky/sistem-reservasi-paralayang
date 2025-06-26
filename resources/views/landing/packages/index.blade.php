@extends('layouts.landing')
@section('title', 'Paket Paralayang')
@section('content')
<div class="container py-5">
    <h2 class="text-2xl font-bold mb-6">Paket Paralayang</h2>
    <div class="grid md:grid-cols-3 gap-6">
        @foreach($packages as $package)
            <div class="bg-white shadow-md rounded-xl overflow-hidden">
                <img src="{{ asset('storage/' . $package->image) }}" class="w-full h-48 object-cover" alt="{{ $package->package_name }}">
                <div class="p-4">
                    <h3 class="text-lg font-semibold">{{ $package->package_name }}</h3>
                    <p class="text-gray-600">{{ Str::limit($package->description, 80) }}</p>
                    <p class="mt-2 font-bold text-primary">Rp {{ number_format($package->price, 0, ',', '.') }}</p>
                    <a href="{{ route('packages.show', $package->id) }}" class="inline-block mt-4 text-blue-600 hover:underline">Lihat Detail</a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection