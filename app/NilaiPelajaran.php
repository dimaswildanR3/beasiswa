<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiPelajaran extends Model
{
    // use HasFactory; // Jika menggunakan factory

    protected $table = 'nilaipelajaran'; // Nama tabel

    protected $fillable = [
        'nis',
        'id_beasiswa', // Data orangtua
        'id_kriteria',
        'tahun_angkatan',
        'tahun_pelajaran',
        'nilai',
        'kelas',
        'semester'
    ];
    

    /**
     * Relasi ke tabel siswa (banyak ke satu)
     * Siswa memiliki banyak nilai pelajaran
     */
   // Model NilaiPelajaran.php

   public function siswa()
{
    return $this->belongsTo(Siswa::class, 'nis', 'id');
}


    /**
     * Relasi ke tabel Nilai (banyak ke satu)
     * Nilai Pelajaran memiliki satu nilai terkait
     */
    public function kelass()
    {
        return $this->belongsTo(Kelas::class, 'kelas', 'id');
    }

    /**
     * Relasi ke tabel Kriteria (banyak ke satu)
     * Setiap nilai pelajaran memiliki satu kriteria
     */
    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, 'id_kriteria', 'id');
    }
}
