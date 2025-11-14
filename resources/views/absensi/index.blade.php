@extends('layouts.master')

@section('content')
    <div class="card shadow-lg mx-auto" style="max-width: 900px;">
        <div class="card-header bg-info text-white">
            <h4 class="mb-0"><i class="fas fa-fingerprint"></i> Halaman Absensi Pegawai</h4>
        </div>
        <div class="card-body">

            {{-- Waktu akan diisi dan diperbarui sepenuhnya oleh JavaScript untuk memastikan sinkronisasi waktu klien (WIB) --}}
            <div class="text-center mb-4 p-3 bg-light rounded shadow-sm">
                <h5 class="text-primary" id="live-date">Memuat Tanggal...</h5>
                <h1 class="display-4 text-dark" id="live-clock">--:--:--</h1>
            </div>

            {{-- *** TAMPILAN JADWAL HARI INI YANG DIPERBARUI *** --}}
            <div class="mb-4 p-3 bg-white border border-info rounded shadow-sm">
                <h5 class="text-primary border-bottom pb-2 mb-3"><i class="fas fa-calendar-check"></i> Jadwal Kerja Anda
                    Hari Ini</h5>

                @if (isset($jadwalHariIni))
                    <div class="card bg-light p-3">
                        <h6 class="mb-3 text-dark fw-bold">{{ $jadwalHariIni->nama_jadwal }}</h6>
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <div class="jam_mulai text-success fw-bold">
                                    <i class="fas fa-clock"></i> Masuk Ideal: <span
                                        class="badge bg-success">{{ $jadwalHariIni->jam_masuk }}</span>
                                </div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <div class="jam_selesai text-danger fw-bold">
                                    <i class="fas fa-sign-out-alt"></i> Keluar Ideal: <span
                                        class="badge bg-danger">{{ $jadwalHariIni->jam_keluar }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <small class="text-muted mt-2 d-block text-end">Pastikan absen Anda sesuai dengan jam di atas.</small>
                @else
                    <div class="alert alert-secondary mb-0 text-center">
                        Anda tidak memiliki jadwal kerja yang ditugaskan hari ini. Silakan hubungi admin Anda.
                    </div>
                @endif
            </div>
            {{-- *** AKHIR TAMPILAN JADWAL HARI INI *** --}}

            <div class="row mb-5">
                <div class="col-12 text-center">
                    <h6 class="mb-3">Aksi Absensi Hari Ini</h6>

                    {{-- Tombol Absen Masuk --}}
                    <form action="{{ route('absensi.masuk') }}" method="POST" class="d-inline mx-2">
                        @csrf
                        <button type="submit" class="btn btn-success btn-lg shadow-sm" style="width: 180px;"
                            {{ isset($absenHariIni) && $absenHariIni->jam_masuk ? 'disabled' : '' }}>
                            <i class="fas fa-sign-in-alt"></i> Absen Masuk
                        </button>
                    </form>

                    {{-- Tombol Absen Keluar --}}
                    <form action="{{ route('absensi.keluar') }}" method="POST" class="d-inline mx-2">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-lg shadow-sm" style="width: 180px;"
                            {{ empty($absenHariIni) || $absenHariIni->jam_keluar ? 'disabled' : '' }}>
                            <i class="fas fa-sign-out-alt"></i> Absen Keluar
                        </button>
                    </form>
                </div>
            </div>

            <hr>

            <h6><i class="fas fa-history"></i> Riwayat Absensi Saya</h6>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-primary">
                        <tr>
                            <th>Tanggal</th>
                            <th>Jam Masuk</th>
                            <th>Jam Keluar</th>
                            <th>Durasi Kerja</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($absensis as $a)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($a->tanggal)->translatedFormat('d M Y') }}</td>
                                <td class="{{ $a->jam_masuk ? 'text-success fw-bold' : 'text-secondary' }}">
                                    {{ $a->jam_masuk ?? '-' }}
                                </td>
                                <td class="{{ $a->jam_keluar ? 'text-danger fw-bold' : 'text-secondary' }}">
                                    {{ $a->jam_keluar ?? '-' }}
                                </td>
                                <td>
                                    @if ($a->jam_masuk && $a->jam_keluar)
                                        @php
                                            $masuk = \Carbon\Carbon::parse($a->jam_masuk);
                                            $keluar = \Carbon\Carbon::parse($a->jam_keluar);
                                            echo $masuk->diff($keluar)->format('%H jam %I menit');
                                        @endphp
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $status = $a->status;
                                        $badgeClass = 'secondary';

                                        switch ($status) {
                                            case 'Masuk':
                                                $badgeClass = 'primary';
                                                break;
                                            case 'Terlambat':
                                                $badgeClass = 'danger';
                                                break;
                                            case 'Selesai':
                                                $badgeClass = 'success';
                                                break;
                                            case 'Selesai + Terlambat':
                                                $badgeClass = 'warning';
                                                break;
                                        }
                                    @endphp

                                    <span class="badge bg-{{ $badgeClass }}">
                                        {{ $status ?? 'Belum Absen' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Belum ada riwayat absensi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Jam Live - Disinkronkan dengan Waktu Klien --}}
    <script>
        function updateClock() {
            const now = new Date();

            // 1. Pembaruan Waktu (Jam:Menit:Detik)
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            document.getElementById('live-clock').textContent = `${hours}:${minutes}:${seconds}`;

            // 2. Pembaruan Tanggal (Hari, Tanggal Bulan Tahun)
            const options = {
                weekday: 'long',
                day: '2-digit',
                month: 'long',
                year: 'numeric'
            };
            const formattedDate = now.toLocaleDateString('id-ID', options);
            document.getElementById('live-date').textContent = `Tanggal Hari Ini: ${formattedDate}`;
        }

        updateClock();
        setInterval(updateClock, 1000);
    </script>
@endsection
