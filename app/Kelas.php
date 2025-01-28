<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = 'kelas';
    
    protected $fillable = ['nama_kelas'];


    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'kelas');
    }
    public function nilaipelajara()
    {
        return $this->hasMany(NilaiPelajaran::class, 'kelas');
    }

}
