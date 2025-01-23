<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiPelajaran extends Model
{
    // use HasFactory;

    protected $table = 'nilaipelajaran';  // Nama tabel

    protected $fillable = [
        'nis', 
        'nilai', 
        'tahun_pelajaran'
    ];

    // Relasi ke tabel siswa (banyak ke satu)
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'nis');
    }

     public function nilai()
    {
        return $this->belongsTo(Nilai::class, 'nis');
    }
}
