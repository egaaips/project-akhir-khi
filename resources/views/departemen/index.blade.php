@extends('layouts.master')

@section('title')
    Data Departemen
@endsection

@section('content')
    <div class="">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Data Departemen</h4>
                <div>
                    <a href="{{ route('departemen.create') }}" class="btn btn-primary">Tambah Departemen</a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Departemen</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($departemens as $index => $departemen)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $departemen->nama_departemen }}</td>
                                <td>
                                    <a href="{{ route('departemen.show', $departemen->id) }}">Detail</a>
                                    <a href="{{ route('departemen.destroy', $departemen->id) }}" class="text-danger"
                                        data-confirm-delete="true">Hapus</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
