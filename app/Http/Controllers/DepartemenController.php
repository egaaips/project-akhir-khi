<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class DepartemenController extends Controller
{
    public function index()
    {
        $departemens = Departemen::all();
        $title = 'Hapus Data Departemen';
        $text = "Data akan dihapus secara permanen, apakah anda yakin?";
        confirmDelete($title, $text);
        return view('departemen.index', compact('departemens'));
    }

    public function create()
    {
        return view('departemen.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_departemen' => 'required',
        ], [
            'nama.required' => 'Nama departemen harus diisi',
        ]);

        Departemen::create($request->all());
        toast('Data berhasil ditambahkan', 'success');
        return redirect()->route('departemen.index');
    }

    public function show(string $id)
    {
        $departemen = Departemen::find($id);
        return view('departemen.show', compact('departemen'));
    }

    public function destroy(string $id)
    {
        $departemen = Departemen::find($id);
        $departemen->delete();

        // Alert::success('Berhasil', 'Data berhasil dihapus');
        toast('Data berhasil dihapus', 'success');
        return redirect()->route('departemen.index');
    }
}
