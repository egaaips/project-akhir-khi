<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Pegawai;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index()
    {
        $jadwals = Jadwal::with('pegawais')->get();
        return view('jadwal.index', compact('jadwals'));
    }

    public function create()
    {
        $pegawais = Pegawai::all();
        return view('jadwal.create', compact('pegawais'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_jadwal' => 'required',
            'tanggal' => 'required|date',
            'jam_masuk' => 'required',
            'jam_keluar' => 'required',
            'pegawai_id' => 'array|required',
        ]);

        $jadwal = Jadwal::create($request->only('nama_jadwal', 'tanggal', 'jam_masuk', 'jam_keluar'));
        $jadwal->pegawais()->attach($request->pegawai_id);

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $pegawais = Pegawai::all();
        return view('jadwal.edit', compact('jadwal', 'pegawais'));
    }

    public function destroy($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $jadwal->pegawais()->detach();
        $jadwal->delete();

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil dihapus!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_jadwal' => 'required',
            'tanggal' => 'required|date',
            'jam_masuk' => 'required',
            'jam_keluar' => 'required',
            'pegawai_id' => 'array|required',
        ]);

        $jadwal = Jadwal::findOrFail($id);
        $jadwal->update([
            'nama_jadwal' => $request->nama_jadwal,
            'tanggal' => $request->tanggal,
            'jam_masuk' => $request->jam_masuk,
            'jam_keluar' => $request->jam_keluar,
        ]);

        // Update pivot table jadwal_pegawai
        $jadwal->pegawais()->sync($request->pegawai_id);

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil diperbarui!');
    }

    public function show($id)
    {
        return redirect()->route('jadwal.index');
    }
}
