@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
<div class="row">
  @php
    $cards = [
      ['title' => 'Jumlah Staff', 'value' => $totalStaff, 'color' => 'primary', 'icon' => 'users'],
      ['title' => 'Total Transaksi', 'value' => $totalTransactions, 'color' => 'info', 'icon' => 'file-text'],
      ['title' => 'Total Pendapatan', 'value' => 'Rp ' . number_format($totalRevenue, 0, ',', '.'), 'color' => 'success', 'icon' => 'dollar-sign'],
      ['title' => 'Total Reservasi', 'value' => $totalReservations, 'color' => 'warning', 'icon' => 'calendar'],
      ['title' => 'Alat Paralayang', 'value' => $totalParaglidingPackages, 'color' => 'danger', 'icon' => 'activity'],
      ['title' => 'Alat Camping', 'value' => $totalCampingEquipments, 'color' => 'secondary', 'icon' => 'archive']
    ];
  @endphp
  @foreach(array_chunk($cards, 3) as $row)
    <div class="row mb-3">
      @foreach($row as $card)
        <div class="col-md-4">
          <div class="card widget-card-1 shadow-sm">
            <div class="card-body d-flex align-items-center">
              <div class="me-3">
                <i class="feather icon-{{ $card['icon'] }} text-{{ $card['color'] }} f-40"></i>
              </div>
              <div>
                <h6 class="text-muted mb-1">{{ $card['title'] }}</h6>
                <h4 class="mb-0 fw-bold">{{ $card['value'] }}</h4>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  @endforeach
</div>

<!-- Grafik Pendapatan Mingguan -->
<div class="card mt-4 shadow-sm">
  <div class="card-header bg-light">
    <h5 class="mb-0">Grafik Pendapatan Mingguan</h5>
  </div>
  <div class="card-body">
    <canvas id="weeklyRevenueChart" height="100"></canvas>
  </div>
</div>

<!-- Grafik Pendapatan 6 Bulan Terakhir -->
<div class="card mt-4 shadow-sm">
  <div class="card-header bg-light">
    <h5 class="mb-0">Grafik Pendapatan 6 Bulan Terakhir</h5>
  </div>
  <div class="card-body">
    <canvas id="revenueChart" height="100"></canvas>
  </div>
</div>

<!-- Grafik Pendapatan Tahunan Per Bulan -->
<div class="card mt-4 shadow-sm">
  <div class="card-header bg-light">
    <h5 class="mb-0">Grafik Pendapatan Tahunan (Per Bulan)</h5>
  </div>
  <div class="card-body">
    <canvas id="allMonthsRevenueChart" height="100"></canvas>
  </div>
</div>

<!-- Tabel Transaksi Terakhir -->
<div class="card mt-4 shadow-sm">
  <div class="card-header bg-light">
    <h5 class="mb-0">Transaksi Terbaru</h5>
  </div>
  <div class="card-body table-responsive">
    <table class="table table-hover table-borderless">
      <thead class="table-light">
        <tr>
          <th>ID</th>
          <th>Nama Pelanggan</th>
          <th>Total</th>
          <th>Status</th>
          <th>Tanggal</th>
        </tr>
      </thead>
      <tbody>
        @foreach($recentTransactions as $trx)
        <tr>
          <td>{{ $trx->id }}</td>
          <td>{{ $trx->reservation->customer_name ?? '-' }}</td>
          <td>Rp {{ number_format($trx->total_payment, 0, ',', '.') }}</td>
          <td><span class="badge bg-{{ $trx->payment_status == 'paid' ? 'success' : 'secondary' }}">{{ ucfirst($trx->payment_status) }}</span></td>
          <td>{{ \Carbon\Carbon::parse($trx->payment_date)->format('d M Y') }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const options = {
    responsive: true,
    plugins: {
      legend: { display: false },
      tooltip: { mode: 'index', intersect: false },
    },
    interaction: { mode: 'nearest', axis: 'x', intersect: false },
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
  };

  new Chart(document.getElementById('weeklyRevenueChart'), {
    type: 'bar',
    data: {
      labels: {!! json_encode($weeklyLabels) !!},
      datasets: [{
        label: 'Pendapatan Mingguan',
        data: {!! json_encode($weeklyRevenue) !!},
        backgroundColor: '#f44242'
      }]
    },
    options
  });

  new Chart(document.getElementById('revenueChart'), {
    type: 'line',
    data: {
      labels: {!! json_encode($monthlyLabels) !!},
      datasets: [{
        label: 'Pendapatan Bulanan',
        data: {!! json_encode($monthlyRevenue) !!},
        backgroundColor: 'rgba(75, 192, 192, 0.3)',
        borderColor: 'rgba(75, 192, 192, 1)',
        borderWidth: 2,
        tension: 0.4,
        fill: true
      }]
    },
    options
  });

  new Chart(document.getElementById('allMonthsRevenueChart'), {
    type: 'bar',
    data: {
      labels: {!! json_encode($allMonthsLabels) !!},
      datasets: [{
        label: 'Pendapatan Tahunan',
        data: {!! json_encode($allMonthsRevenue) !!},
        backgroundColor: 'rgba(54, 162, 235, 0.6)',
        borderColor: 'rgba(54, 162, 235, 1)',
        borderWidth: 1
      }]
    },
    options
  });
</script>
@endpush
