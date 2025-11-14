<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class LaporanController extends Controller
{

    public function exportPdf(string $id)
    {
        // Filter tanggal (default: hari ini)
        $tanggal = $request->tanggal ?? now()->toDateString();

        $jadwalPegawai = \App\Models\JadwalPegawai::with(['pegawai', 'jadwal'])
            ->whereHas('jadwal', function ($q) use ($tanggal) {
                $q->whereDate('tanggal', $tanggal);
            })
            ->get();

        $absensi = Absensi::whereIn('jadwal_pegawai_id', $jadwalPegawai->pluck('id'))
            ->get()
            ->keyBy('jadwal_pegawai_id');

        $pdf = Pdf::setOptions(['isRemoteEnabled' => true])
            ->loadView('laporan.export-pdf', compact('jadwalPegawai', 'absensi', 'tanggal'))
            ->setPaper('a4', 'landscape');

        return $pdf->stream('{$absensi->jadwal_pegawai_id->jadwal->tanggal}.pdf', ['Attachment' => 0]);

        exit();
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Filter tanggal (default: hari ini)
        $tanggal = $request->tanggal ?? now()->toDateString();

        // Ambil semua jadwal_pegawai yang punya jadwal pada tanggal itu
        $jadwalPegawai = \App\Models\JadwalPegawai::with(['pegawai', 'jadwal'])
            ->whereHas('jadwal', function ($q) use ($tanggal) {
                $q->whereDate('tanggal', $tanggal);
            })
            ->get();

        // Ambil absensi berdasarkan jadwal_pegawai_id
        $absensi = Absensi::whereIn('jadwal_pegawai_id', $jadwalPegawai->pluck('id'))
            ->get()
            ->keyBy('jadwal_pegawai_id'); // supaya mudah dicari

        return view('laporan.index', compact('jadwalPegawai', 'absensi', 'tanggal'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $absensi = Absensi::find($id);
        return view('laporan.show', compact('absensi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
