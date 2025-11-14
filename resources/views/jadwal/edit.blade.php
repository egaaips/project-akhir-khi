@extends('layouts.master')

@section('content')
<div class="card shadow-lg mx-auto" style="max-width: 800px;">
    <div class="card-header bg-success text-white">
        <h5 class="mb-0"><i class="fas fa-edit"></i> Edit Jadwal Kerja: {{ $jadwal->nama_jadwal }}</h5>
    </div>
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        {{-- Form Action diubah ke route UPDATE dengan method PUT --}}
        <form action="{{ route('jadwal.update', $jadwal->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label for="nama_jadwal" class="form-label font-weight-bold">Nama Jadwal / Shift</label>
                    {{-- Nilai diisi dari data $jadwal --}}
                    <input type="text" name="nama_jadwal" id="nama_jadwal" class="form-control" 
                           value="{{ old('nama_jadwal', $jadwal->nama_jadwal) }}" placeholder="Contoh: Shift Pagi, Office Hour" required>
                </div>
                
                <div class="col-md-4 mb-3">
                    <label for="tanggal" class="form-label font-weight-bold">Tanggal</label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control" 
                           value="{{ old('tanggal', $jadwal->tanggal) }}" required>
                </div>
                
                <div class="col-md-4 mb-3">
                    <label for="jam_masuk" class="form-label font-weight-bold">Jam Masuk</label>
                    <input type="time" name="jam_masuk" id="jam_masuk" class="form-control" 
                           value="{{ old('jam_masuk', $jadwal->jam_masuk) }}" required>
                </div>
                
                <div class="col-md-4 mb-3">
                    <label for="jam_keluar" class="form-label font-weight-bold">Jam Keluar</label>
                    <input type="time" name="jam_keluar" id="jam_keluar" class="form-control" 
                           value="{{ old('jam_keluar', $jadwal->jam_keluar) }}" required>
                </div>

                <div class="col-md-12 mb-4">
                    <label for="pegawai_select" class="form-label font-weight-bold">Tugaskan ke Pegawai</label>
                    <select name="pegawai_id[]" id="pegawai_select" class="form-select" multiple required style="min-height: 150px;">
                        @php
                            // Ambil ID pegawai yang sudah ditugaskan ke jadwal ini
                            $assignedPegawaiIds = $jadwal->pegawais->pluck('id')->toArray();
                        @endphp
                        
                        @forelse($pegawais as $p)
                            <option value="{{ $p->id }}" 
                                {{-- Cek apakah pegawai ini sudah terpilih atau ada di old() input --}}
                                {{ in_array($p->id, old('pegawai_id', $assignedPegawaiIds)) ? 'selected' : '' }}>
                                {{ $p->nama }} (ID: {{ $p->id }})
                            </option>
                        @empty
                            <option disabled>Tidak ada data pegawai. Silakan tambahkan pegawai terlebih dahulu.</option>
                        @endforelse
                    </select>
                    <small class="form-text text-muted">Tekan CTRL (atau Command di Mac) untuk memilih lebih dari satu pegawai.</small>
                </div>
            </div>
            
            <div class="d-flex justify-content-between">
                <a href="{{ route('jadwal.index') }}" class="btn btn-secondary btn-lg">
                    <i class="fas fa-arrow-left"></i> Batal
                </a>
                <button type="submit" class="btn btn-success btn-lg">
                    <i class="fas fa-check"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection