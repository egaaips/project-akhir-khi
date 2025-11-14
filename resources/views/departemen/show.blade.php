@extends('layouts.master')

@section('title')
    Daftar Anggota Departemen
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Daftar Anggota Departemen {{ $departemen->nama_departemen }}</h4>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pegawai</th>
                        <th>Email</th>
                        <th>Jenis Kelamin</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($departemen->pegawai as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->user->email }}</td>
                            <td>{{ $item->jenis_kelamin }}</td>
                        </tr>
                        
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection