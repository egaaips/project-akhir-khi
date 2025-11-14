<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $fillable = ['nama_jadwal', 'tanggal', 'jam_masuk', 'jam_keluar'];

    public function pegawais()
    {
        return $this->belongsToMany(Pegawai::class, 'jadwal_pegawai')
                    ->withPivot('id');
    }
}
