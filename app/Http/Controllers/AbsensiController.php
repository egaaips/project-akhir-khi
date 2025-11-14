<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\Jadwal;
use App\Models\JadwalPegawai;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    // =============================
    //  INDEX
    // =============================
    public function index()
    {
        date_default_timezone_set('Asia/Jakarta');

        $pegawaiId = Auth::user()->pegawai_id;
        $today = now()->toDateString();

        // Ambil jadwal hari ini berdasarkan pivot jadwal_pegawai
        $jadwalPegawai = JadwalPegawai::where('pegawai_id', $pegawaiId)
            ->whereHas('jadwal', fn($q) => $q->whereDate('tanggal', $today))
            ->with('jadwal')
            ->first();

        $jadwalHariIni = $jadwalPegawai?->jadwal ?? null;

        // Ambil absensi berdasarkan jadwal_pegawai_id
        $absenHariIni = $jadwalPegawai
            ? Absensi::where('jadwal_pegawai_id', $jadwalPegawai->id)->first()
            : null;

        // Riwayat absensi
        $absensis = Absensi::whereHas('jadwalPegawai', fn($q) =>
                $q->where('pegawai_id', $pegawaiId)
            )
            ->with('jadwalPegawai.jadwal')
            ->latest()
            ->limit(30)
            ->get();

        return view('absensi.index', compact('absensis', 'absenHariIni', 'jadwalHariIni'));
    }


    // =============================
    //  ABSEN MASUK
    // =============================
    public function absenMasuk()
    {
        date_default_timezone_set('Asia/Jakarta');
        $now = Carbon::now();
        $pegawaiId = Auth::user()->pegawai_id;

        // Ambil jadwal hari ini
        $jadwalPegawai = JadwalPegawai::where('pegawai_id', $pegawaiId)
            ->whereHas('jadwal', fn($q) => $q->whereDate('tanggal', now()->toDateString()))
            ->with('jadwal')
            ->first();

        if (!$jadwalPegawai) {
            toast('Anda tidak memiliki jadwal hari ini.', 'error');
            return redirect()->route('absensi.index');
        }

        $jadwal = $jadwalPegawai->jadwal;

        // Cek jika sudah absen masuk
        $absen = Absensi::where('jadwal_pegawai_id', $jadwalPegawai->id)->first();
        if ($absen && $absen->jam_masuk) {
            toast('Anda sudah absen masuk!', 'error');
            return redirect()->route('absensi.index');
        }

        // Hitung keterlambatan
        $jamMasukIdeal = Carbon::parse($jadwal->jam_masuk);
        $minutesLate = $now->greaterThan($jamMasukIdeal)
            ? $now->diffInMinutes($jamMasukIdeal)
            : 0;

        // Default
        $status = "Masuk";
        $keterangan = "Hadir";

        // Logika terlambat
        if ($minutesLate > 0) {

            if ($minutesLate <= 30) {
                // masih dianggap hadir
                $status = "Masuk";
                $keterangan = "Hadir";
            }
            elseif ($minutesLate > 60) {
                toast('Terlambat lebih dari 1 jam. Absen ditolak.', 'error');
                return redirect()->route('absensi.index');
            }
            else {
                // Terlambat 31-60 menit
                $status = "Terlambat";
                $keterangan = $this->formatTerlambat($minutesLate);
            }
        }

        Absensi::create([
            'jadwal_pegawai_id' => $jadwalPegawai->id,
            'jam_masuk' => $now->format('H:i:s'),
            'status' => $status,
            'keterangan' => $keterangan,
        ]);

        toast('Berhasil absen masuk!', 'success');
        return redirect()->route('absensi.index');
    }


    // =============================
    //  ABSEN KELUAR
    // =============================
    public function absenKeluar()
    {
        date_default_timezone_set('Asia/Jakarta');
        $now = Carbon::now();
        $pegawaiId = Auth::user()->pegawai_id;

        $jadwalPegawai = JadwalPegawai::where('pegawai_id', $pegawaiId)
            ->whereHas('jadwal', fn($q) => $q->whereDate('tanggal', now()->toDateString()))
            ->with('jadwal')
            ->first();

        if (!$jadwalPegawai) {
            toast('Tidak ada jadwal hari ini.', 'error');
            return redirect()->route('absensi.index');
        }

        $absen = Absensi::where('jadwal_pegawai_id', $jadwalPegawai->id)->first();

        if (!$absen || !$absen->jam_masuk) {
            toast('Anda belum absen masuk!', 'error');
            return redirect()->route('absensi.index');
        }

        if ($absen->jam_keluar) {
            toast('Anda sudah absen keluar!', 'error');
            return redirect()->route('absensi.index');
        }

        $jadwal = $jadwalPegawai->jadwal;
        $jamKeluarIdeal = Carbon::parse($jadwal->jam_keluar);

        if ($now->lessThan($jamKeluarIdeal)) {
            toast('Waktu kerja belum selesai.', 'error');
            return redirect()->route('absensi.index');
        }

        $absen->update([
            'jam_keluar' => $now->format('H:i:s'),
        ]);

        toast('Berhasil absen keluar!', 'success');
        return redirect()->route('absensi.index');
    }


    // =============================
    //  HELPER: Format Terlambat
    // =============================
    private function formatTerlambat($minutesLate)
    {
        $jam = floor($minutesLate / 60);
        $menit = $minutesLate % 60;

        if ($jam > 0 && $menit > 0) {
            return "Terlambat {$jam} jam {$menit} menit";
        } elseif ($jam > 0) {
            return "Terlambat {$jam} jam";
        } else {
            return "Terlambat {$menit} menit";
        }
    }
}
