@extends('layouts.master')

@section('title')
    Tambah Departemen
@endsection

@section('content')
    <div class="">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Form Tambah Departemen</h4>
                <div>
                    <a href="{{ route('departemen.index') }}">Kembali</a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('departemen.store') }}" method="post">
                    @csrf
                    <div class="form-group my-2">
                        <label for="nama_departemen">Nama Departemen</label>
                        <input type="text" id="nama_departemen" name="nama_departemen" class="form-control"
                            @error('nama_departemen')
                                is-invalid
                            @enderror>
                    </div>
                    <div class="my-2 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
