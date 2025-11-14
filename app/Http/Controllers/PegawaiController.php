<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PegawaiController extends Controller
{
    public function index()
    {
        $pegawai = Pegawai::with('user')->get();
        return view('pegawai.index', compact('pegawai'));
    }

    public function create()
    {
        $departemens = Departemen::all();
        return view('pegawai.create', compact('departemens'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'          => 'required',
            'departemen_id' => 'required|exists:departemens,id',
            'email'         => 'required|email|unique:users,email',
            'nik'           => 'required|numeric|unique:pegawais,nik',
            'alamat'        => 'required',
            'no_hp'         => 'required|numeric',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
        ], [
            'nama.required' => 'Nama pegawai harus diisi',
            'nik.unique' => 'NIK sudah terdaftar',
            'nik.numeric' => 'NIK harus berupa angka',
            'nik.required' => 'NIK pegawai harus diisi',
            'alamat.required' => 'Alamat pegawai harus diisi',
            'no_hp.required' => 'No HP pegawai harus diisi',
            'no_hp.numeric' => 'No HP harus berupa angka',
            'tanggal_lahir.required' => 'Tanggal lahir pegawai harus diisi',
            'jenis_kelamin.required' => 'Jenis kelamin pegawai harus diisi',
            'jenis_kelamin.in' => 'Jenis kelamin pegawai harus laki-laki atau perempuan',
        ]);

        $newRequest = $request->all();

        $newData = Pegawai::create($newRequest);
        $user = User::create([
            'name' => $newData->nama,
            'email' => $request->email,
            'password' => $request->nik,
            'pegawai_id' => $newData->id
        ]);
        $newData->user_id = $user->id;
        $newData->save();

        Alert::success('Berhasil', 'Data berhasil ditambahkan');
        return redirect()->route('pegawai.index');
    }

    public function edit(string $id)
    {
        $pegawai = Pegawai::find($id);
        $departemens = Departemen::all();
        return view('pegawai.edit', compact('pegawai', 'departemens'));
    }

    public function update(Request $request, Pegawai $pegawai)
    {
        $request->validate([
            'nama'          => 'required',
            'nik'           => 'required|numeric|unique:pegawais,nik,' . $pegawai->id,
            'alamat'        => 'required',
            'no_hp'         => 'required|numeric',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
        ], [
            'nama.required' => 'Nama pegawai harus diisi',
            'nik.unique' => 'NIK sudah terdaftar',
            'nik.numeric' => 'NIK harus berupa angka',
            'nik.required' => 'NIK pegawai harus diisi',
            'alamat.required' => 'Alamat pegawai harus diisi',
            'no_hp.required' => 'No HP pegawai harus diisi',
            'no_hp.numeric' => 'No HP harus berupa angka',
            'tanggal_lahir.required' => 'Tanggal lahir pegawai harus diisi',
            'jenis_kelamin.required' => 'Jenis kelamin pegawai harus diisi',
        ]);

        $pegawai->update($request->except('nik'));
        // Alert::success('Berhasil', 'Data berhasil diubah');
        toast('Data berhasil diubah', 'success');
        return redirect()->route('pegawai.index');
    }

    public function destroy(string $id)
    {
        Pegawai::destroy($id);
        // Alert::success('Berhasil', 'Data berhasil dihapus');
        toast('Data berhasil dihapus', 'success');
        return redirect()->route('pegawai.index');
    }
}
