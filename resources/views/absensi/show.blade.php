@extends('layouts.master')

@section('content')
    <div class="card shadow-lg mx-auto mt-4" style="max-width: 700px;">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="fas fa-user-clock"></i> Detail Absensi Pegawai</h4>
            <a href="{{ route('absensi.index') }}" class="btn btn-light btn-sm">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-borderless">
                    <tr>
                        <th width="35%">Nama Pegawai</th>
                        <td>: {{ $absensi->pegawai->nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>NIK</th>
                        <td>: {{ $absensi->pegawai->nik ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal</th>
                        <td>: {{ \Carbon\Carbon::parse($absensi->tanggal)->translatedFormat('l, d F Y') }}</td>
                    </tr>
                    <tr>
                        <th>Jam Masuk</th>
                        <td class="text-success fw-bold">: {{ $absensi->jam_masuk ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Jam Keluar</th>
                        <td class="text-danger fw-bold">: {{ $absensi->jam_keluar ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Durasi Kerja</th>
                        <td>:
                            @if ($absensi->jam_masuk && $absensi->jam_keluar)
                                @php
                                    $masuk = \Carbon\Carbon::parse($absensi->jam_masuk);
                                    $keluar = \Carbon\Carbon::parse($absensi->jam_keluar);
                                    echo $masuk->diff($keluar)->format('%H jam %I menit');
                                @endphp
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Keterangan</th>
                        <td>: {{ $absensi->keterangan ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>:
                            @if ($absensi->jam_masuk && $absensi->jam_keluar)
                                <span class="badge bg-success">Selesai</span>
                            @elseif($absensi->jam_masuk)
                                <span class="badge bg-warning text-dark">Masuk</span>
                            @else
                                <span class="badge bg-secondary">Belum Absen</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    {{-- SweetAlert Toast --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if (session('success'))
            Swal.fire({
                toast: true,
                icon: 'success',
                title: "{{ session('success') }}",
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        @endif

        @if (session('error'))
            Swal.fire({
                toast: true,
                icon: 'error',
                title: "{{ session('error') }}",
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        @endif
    </script>
@endsection
