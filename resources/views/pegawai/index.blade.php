@extends('layouts.master')

@section('title')
    Halaman Pegawai
@endsection

@section('content')
    <div class="">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Data Pegawai</h4>
                <div>
                    <a href="{{ route('pegawai.create') }}" class="btn btn-primary">Tambah Pegawai</a>
                </div>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered" id="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pegawai</th>
                            <th>Departemen</th>
                            <th>Email</th>
                            <th>NIK</th>
                            <th>Jenis Kelamin</th>
                            <th>No Hp</th>
                            <th>Tanggal Lahir</th>
                            <th>Alamat</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pegawai as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->departemen?->nama_departemen }}</td>
                                <td>{{ $item->user?->email }}</td>
                                <td>{{ $item->nik }}</td>
                                <td>{{ $item->jenis_kelamin }}</td>
                                <td>{{ $item->no_hp }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal_lahir)->locale('id')->translatedFormat('d F Y') }}</td>
                                <td>{{ $item->alamat }}</td>
                                <td>
                                    <div class="dropdown">
                                        <a href="#" class="btn dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">Aksi</a>

                                        <ul class="dropdown-menu">
                                            <li><a href="{{ route('pegawai.edit', $item->id) }}" class="dropdown-item">Edit</a></li>
                                            <li>
                                                <button type="button" class="btn text-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{ $item->id }}">
                                                    Hapus
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @foreach ($pegawai as $item)
        <div class="modal fade" id="confirmDeleteModal{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Apakah anda yakin ingin menghapus data ini?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Data yang telah dihapus tidak dapat dikembalikan, pilih lanjutkan untuk menghapus data.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <form action="{{ route('pegawai.destroy', $item->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Lanjutkan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    
@endsection
