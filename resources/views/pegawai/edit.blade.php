@extends('layouts.master')

@section('title')
    Tambah Pegawai
@endsection

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Form Tambah Pegawai</h4>
                <div>
                    <a href="{{ route('pegawai.index') }}">Kembali</a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('pegawai.update', $pegawai->id) }}') }}" method="POST" class="">
                    @csrf
                    @method('PUT')
                    <div class="form-group my-2">
                        <label for="nama">Nama Pegawai</label>
                        <input type="text" name="nama" id="nama" class="form-control @error('nama') 
                            is-invalid 
                        @enderror" 
                            value="{{ $pegawai->nama }}" autofocus>
                        @error('nama')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group my-2">
                        <label for="departemen_id">Departemen</label>
                        <select name="departemen_id" id="departemen_id" class="form-control @error('departemen_id') is-invalid @enderror">
                            <option value="">Pilih Departemen</option>
                            @foreach ($departemens as $departemen)
                                <option value="{{ $departemen->id }}" {{ $pegawai->departemen_id == $departemen->id ? 'selected' : '' }}>{{ $departemen->nama_departemen }}</option>
                            @endforeach
                        </select>
                        @error('departemen_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group my-2">
                        <label for="nik">NIK</label>
                        <input type="text" name="nik" id="nik" class="form-control @error('nik') is-invalid @enderror" value="{{ $pegawai->nik }}" readonly>
                        @error('nik')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group my-2">
                        <label for="jenis_kelamin">Jenis Kelamin</label>
                        <select name="jenis_kelamin" id="jenis_kelamin" class="form-control @error('jenis_kelamin') is-invalid @enderror">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="laki-laki" {{ $pegawai->jenis_kelamin == 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="perempuan" {{ $pegawai->jenis_kelamin == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('jenis_kelamin')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group my-2">
                        <label for="tanggal_lahir">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control @error('tanggal_lahir') is-invalid @enderror" value="{{ $pegawai->tanggal_lahir }}">
                        @error('tanggal_lahir')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group my-2">
                        <label for="no_hp">Nomor Hp</label>
                        <input type="text" name="no_hp" id="no_hp" class="form-control @error('no_hp') is-invalid @enderror" value="{{ $pegawai->no_hp }}">
                        @error('no_hp')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group my-2">
                        <label for="alamat">Alamat</label>
                        <textarea name="alamat" id="alamat" cols="30" rows="10" class="form-control @error('alamat') is-invalid @enderror">{{ $pegawai->alamat }}</textarea>
                        @error('alamat')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="my-2 d-flex justify-content-end">
                        <button class="btn btn-primary"> Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection