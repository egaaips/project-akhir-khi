@extends('layouts.master')

@section('content')
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-calendar-alt"></i> Daftar Semua Jadwal Kerja</h5>
            <a href="{{ route('jadwal.create') }}" class="btn btn-warning btn-sm">
                <i class="fas fa-plus"></i> Buat Jadwal Baru
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped" id="jadwal-table">
                    <thead class="bg-light">
                        <tr>
                            <th>ID</th>
                            <th>Nama Jadwal</th>
                            <th>Tanggal</th>
                            <th>Jam Masuk</th>
                            <th>Jam Keluar</th>
                            <th>Pegawai Ditugaskan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jadwals as $jadwal)
                            <tr>
                                <td>{{ $jadwal->id }}</td>
                                <td>{{ $jadwal->nama_jadwal }}</td>
                                <td>{{ \Carbon\Carbon::parse($jadwal->tanggal)->translatedFormat('d F Y') }}</td>
                                <td>{{ $jadwal->jam_masuk }}</td>
                                <td>{{ $jadwal->jam_keluar }}</td>
                                <td>
                                    @foreach ($jadwal->pegawais as $pegawai)
                                        <span class="badge bg-info text-dark me-1 my-1">{{ $pegawai->nama }}</span>
                                    @endforeach
                                    @if ($jadwal->pegawais->isEmpty())
                                        <span class="badge bg-secondary">Belum ada pegawai</span>
                                    @endif
                                </td>
                                <td>
                                    {{-- Dropdown Aksi --}}
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-info dropdown-toggle" type="button" id="aksiDropdown{{ $jadwal->id }}"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-eye"></i> Aksi
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="aksiDropdown{{ $jadwal->id }}">
                                            <li>
                                                <a class="dropdown-item text-primary" href="{{ route('jadwal.edit', $jadwal->id) }}">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                            </li>
                                            <li>
                                                <form action="{{ route('jadwal.destroy', $jadwal->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?')" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger">
                                                        <i class="fas fa-trash-alt"></i> Hapus
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">Belum ada data jadwal yang dibuat. Silakan
                                    buat jadwal baru.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
