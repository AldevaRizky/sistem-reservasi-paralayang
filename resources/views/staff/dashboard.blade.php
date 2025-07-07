@extends('layouts.dashboard')

@section('title', 'Dashboard Staff')

@section('content')
<div class="row row-cols-1 row-cols-md-3 g-4">
  <div class="col">
    <div class="card widget-card-1 shadow-sm">
      <div class="card-body d-flex align-items-center">
        <div class="me-3">
          <i class="feather icon-briefcase text-primary f-40"></i>
        </div>
        <div>
          <h6 class="text-muted mb-1">Reservasi Ditangani</h6>
          <h4 class="mb-0 fw-bold">{{ $reservationsHandled }}</h4>
        </div>
      </div>
    </div>
  </div>
  <div class="col">
    <div class="card widget-card-1 shadow-sm">
      <div class="card-body d-flex align-items-center">
        <div class="me-3">
          <i class="feather icon-dollar-sign text-success f-40"></i>
        </div>
        <div>
          <h6 class="text-muted mb-1">Total Pendapatan</h6>
          <h4 class="mb-0 fw-bold">Rp {{ number_format($revenueHandled, 0, ',', '.') }}</h4>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Grafik Pendapatan Staff -->
<div class="card mt-4 shadow-sm">
  <div class="card-header bg-light">
    <h5 class="mb-0">Grafik Pendapatan 6 Bulan Terakhir</h5>
  </div>
  <div class="card-body">
    <canvas id="monthlyRevenueChart" height="100"></canvas>
  </div>
</div>

<!-- Tabel Transaksi Terbaru -->
<div class="card mt-4 shadow-sm">
  <div class="card-header bg-light">
    <h5 class="mb-0">Transaksi Terbaru</h5>
  </div>
  <div class="card-body table-responsive">
    <table class="table table-hover table-borderless">
      <thead class="table-light">
        <tr>
          <th>ID</th>
          <th>Pelanggan</th>
          <th>Total</th>
          <th>Status</th>
          <th>Tanggal</th>
        </tr>
      </thead>
      <tbody>
        @forelse($recentTransactions as $trx)
        <tr>
          <td>{{ $trx->id }}</td>
          <td>{{ $trx->reservation->customer_name ?? '-' }}</td>
          <td>Rp {{ number_format($trx->total_payment, 0, ',', '.') }}</td>
          <td><span class="badge bg-{{ $trx->payment_status == 'paid' ? 'success' : 'secondary' }}">{{ ucfirst($trx->payment_status) }}</span></td>
          <td>{{ \Carbon\Carbon::parse($trx->payment_date)->format('d M Y') }}</td>
        </tr>
        @empty
        <tr>
          <td colspan="5" class="text-center">Tidak ada transaksi</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  new Chart(document.getElementById('monthlyRevenueChart'), {
    type: 'bar',
    data: {
      labels: {!! json_encode($monthlyLabels) !!},
      datasets: [{
        label: 'Pendapatan (Rp)',
        data: {!! json_encode($monthlyRevenue) !!},
        backgroundColor: 'rgba(54, 162, 235, 0.6)',
        borderColor: 'rgba(54, 162, 235, 1)',
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { display: false },
        tooltip: { mode: 'index', intersect: false }
      },
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            callback: function(value) {
              return 'Rp ' + value.toLocaleString('id-ID');
            }
          }
        }
      }
    }
  });
</script>
@endpush
