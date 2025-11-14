<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $fillable = [
        'jadwal_pegawai_id',
        'jam_masuk',
        'jam_keluar',
        'status',
        'keterangan'
    ];


    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }

    public function jadwalPegawai()
    {
        return $this->belongsTo(JadwalPegawai::class, 'jadwal_pegawai_id');
    }
}
