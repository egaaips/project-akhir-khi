@extends('layouts.master')

@section('content')
<div class="card shadow-lg mx-auto" style="max-width: 800px;">
    <div class="card-header bg-warning text-dark">
        <h5 class="mb-0"><i class="fas fa-calendar-plus"></i> Buat Jadwal Kerja Baru</h5>
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
        
        <form action="{{ route('jadwal.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label for="nama_jadwal" class="form-label font-weight-bold">Nama Jadwal / Shift</label>
                    <input type="text" name="nama_jadwal" id="nama_jadwal" class="form-control" 
                           value="{{ old('nama_jadwal') }}" placeholder="Contoh: Shift Pagi, Office Hour" required>
                </div>
                
                <div class="col-md-4 mb-3">
                    <label for="tanggal" class="form-label font-weight-bold">Tanggal</label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control" 
                           value="{{ old('tanggal', date('Y-m-d')) }}" required>
                </div>
                
                <div class="col-md-4 mb-3">
                    <label for="jam_masuk" class="form-label font-weight-bold">Jam Masuk</label>
                    <input type="time" name="jam_masuk" id="jam_masuk" class="form-control" 
                           value="{{ old('jam_masuk', '08:00') }}" required>
                </div>
                
                <div class="col-md-4 mb-3">
                    <label for="jam_keluar" class="form-label font-weight-bold">Jam Keluar</label>
                    <input type="time" name="jam_keluar" id="jam_keluar" class="form-control" 
                           value="{{ old('jam_keluar', '16:00') }}" required>
                </div>

                <div class="col-md-12 mb-4">
                    <label for="pegawai_select" class="form-label font-weight-bold">Tugaskan ke Pegawai</label>
                    <select name="pegawai_id[]" id="pegawai_select" class="form-select" multiple required style="min-height: 150px;">
                        @forelse($pegawais as $p)
                            <option value="{{ $p->id }}" {{ in_array($p->id, old('pegawai_id', [])) ? 'selected' : '' }}>
                                {{ $p->nama }} (ID: {{ $p->id }})
                            </option>
                        @empty
                            <option disabled>Tidak ada data pegawai. Silakan tambahkan pegawai terlebih dahulu.</option>
                        @endforelse
                    </select>
                    <small class="form-text text-muted">Tekan CTRL (atau Command di Mac) untuk memilih lebih dari satu pegawai.</small>
                </div>
            </div>
            
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-save"></i> Simpan Jadwal & Tugaskan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection