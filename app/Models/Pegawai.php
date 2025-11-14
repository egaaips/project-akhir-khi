<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function departemen()
    {
        return $this->belongsTo(Departemen::class);
    }


    public function absensis()
    {
        return $this->hasMany(Absensi::class);
    }
    public function jadwalPegawai()
    {
        return $this->belongsToMany(
            Jadwal::class,       // Model yang dituju
            'jadwal_pegawai',    // Nama pivot table
            'pegawai_id',        // Foreign key di pivot table untuk Pegawai
            'jadwal_id'          // Foreign key di pivot table untuk Jadwal
        );
    }
}
