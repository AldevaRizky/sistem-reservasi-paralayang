@extends('layouts.landing')
@section('title', $package->package_name)
@section('content')
<div class="container py-5">
    <div class="grid md:grid-cols-2 gap-6">
        <div>
            <img src="{{ asset('storage/' . $package->image) }}" class="w-full rounded-lg shadow" alt="{{ $package->package_name }}">
        </div>
        <div>
            <h2 class="text-2xl font-bold mb-2">{{ $package->package_name }}</h2>
            <p class="mb-4 text-gray-700">{{ $package->description }}</p>
            <ul class="mb-4 text-sm text-gray-600">
                <li><strong>Durasi:</strong> {{ $package->duration }}</li>
                <li><strong>Kapasitas per slot:</strong> {{ $package->capacity_per_slot }} orang</li>
                <li><strong>Persyaratan:</strong> {{ $package->requirements }}</li>
            </ul>
            <p class="text-xl font-bold">Rp {{ number_format($package->price, 0, ',', '.') }}</p>
            <a href="{{ route('user.booking.schedule', $package->id) }}" class="mt-4 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Pilih Jadwal</a>
        </div>
    </div>
</div>
@endsection
