<?php

namespace App;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    // use HasFactory;
    protected $table = 'nilai';
    
    protected $guarded = [];

    
    public function kriteria()
    {
      return $this->belongsTo(Kriteria::class, 'id_kriteria');
        // return $this->hasOne('App\Kriteria');
      }
      public function siswa()
      {
        return $this->belongsTo(Siswa::class, 'nis');
          // return $this->hasOne('App\Kriteria');
        }
        public function beasiswa()
        {
          return $this->belongsTo(Beasiswa::class, 'id_beasiswa');
            // return $this->hasOne('App\Kriteria');
          }
          public function nilaipelajaran()
    {
        return $this->hasMany(NilaiPelajaran::class, 'nis', 'nis');
        
        // return $this->hasOne(NilaiPelajaran::class, 'nis', 'nis');
    }

}
