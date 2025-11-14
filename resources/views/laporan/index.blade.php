@extends('layouts.master')

@section('title')
    Laporan
@endsection

@section('content')
    <div class="">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Laporan Absensi</h4>
                <div class="mb-3">
                    <form id="filterForm" class="d-flex align-items-center">
                        <input type="date" id="tanggal" name="tanggal" class="form-control me-2">
                        <button type="submit" class="btn btn-primary">Filter</button>
                        <div class="w-100">
                            <a href="{{ route('laporan.pdf', $absensi->first()->jadwal_pegawai_id) }}"
                                target="_blank" class="btn btn-success ms-2">Export Pdf</a>
                        </div>
                    </form>

                </div>

            </div>
            <div class="card-body">
                <table class="table table-bordered" id="datatable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pegawai</th>
                            <th>Jam Masuk</th>
                            <th>Jam Keluar</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($jadwalPegawai as $index => $jp)
                            @php
                                $absen = $absensi[$jp->id] ?? null;
                                $pegawai = $jp->pegawai;
                            @endphp

                            <tr>
                                <td>{{ $index + 1 }}</td>

                                {{-- Nama Pegawai --}}
                                <td>{{ $pegawai->nama }}</td>

                                {{-- Jam Masuk --}}
                                <td>{{ $absen->jam_masuk ?? '-' }}</td>

                                {{-- Jam Keluar --}}
                                <td>{{ $absen->jam_keluar ?? '-' }}</td>

                                {{-- Status --}}
                                <td>
                                    @if (!$absen)
                                        <span class="badge bg-secondary">Belum Absen</span>
                                    @else
                                        <span
                                            class="badge bg-{{ $absen->status == 'Terlambat' ? 'danger' : ($absen->status == 'Masuk' ? 'primary' : 'success') }}">
                                            {{ $absen->status }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            var table = $('#datatable').DataTable();

            $('#filterForm').on('submit', function(e) {
                e.preventDefault();
                var tanggal = $('#tanggal').val();
                table.column(2).search(tanggal).draw(); // kolom 2 = Jam Masuk (sesuaikan kolom tanggal)
            });

            $('#resetFilter').click(function() {
                $('#tanggal').val('');
                table.search('').columns().search('').draw();
            });
        });
    </script>
@endsection
