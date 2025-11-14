<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('APP_TITLE') }}</title>
</head>
<body>

    <div class="">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Laporan Absensi</h4>
                <div class="mb-3">
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
    
</body>
</html>