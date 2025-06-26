@extends('layouts.landing')
@section('title', 'Pilih Jadwal')
@section('content')
<div class="container mx-auto py-8">
    <h2 class="text-2xl font-bold mb-4">Pilih Jadwal untuk Paket: {{ $package->name }}</h2>
    @if ($schedules->isEmpty())
        <p class="text-gray-600">Tidak ada jadwal tersedia saat ini.</p>
    @else
        <ul class="space-y-4">
            @foreach ($schedules as $schedule)
                <li class="border p-4 rounded shadow">
                    <div>
                        <strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($schedule->date)->format('d M Y') }}
                    </div>
                    <div><strong>Slot Tersedia:</strong> {{ $schedule->available_slots }}</div>
                    <form action="{{ route('user.booking.reserve', $schedule->id) }}" method="POST" class="mt-2">
                        @csrf
                        <input type="number" name="participant_count" min="1" max="{{ $schedule->available_slots }}" class="border rounded px-2 py-1" required placeholder="Jumlah Peserta">
                        <textarea name="notes" placeholder="Catatan opsional" class="border rounded px-2 py-1 mt-2 w-full"></textarea>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded mt-2">Pesan Sekarang</button>
                    </form>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
