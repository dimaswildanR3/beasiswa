<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    protected $table = 'nilai';
    protected $guarded = [];

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, 'id_kriteria');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'nis');
    }

    public function beasiswa()
    {
        return $this->belongsTo(Beasiswa::class, 'id_beasiswa');
    }

    public function nilaipelajaran()
    {
        return $this->hasMany(NilaiPelajaran::class, 'nis', 'nis');
    }
}
