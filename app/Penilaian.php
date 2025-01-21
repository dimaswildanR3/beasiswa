<?php

namespace App;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    // use HasFactory;
    protected $table = 'penilaian';
    
    protected $guarded = [];
    public function beasiswa()
    {
      return $this->belongsTo(Beasiswa::class, 'id_beasiswa');
        // return $this->hasOne('App\Kriteria');
      }
    public function kriteria()
    {
      return $this->belongsTo(Kriteria::class, 'id_kriteria');
        // return $this->hasOne('App\Kriteria');
      }
    public function model()
    {
      return $this->belongsTo(Models::class, 'id_model');
        // return $this->hasOne('App\Kriteria');
      }
    public function siswa()
    {
      return $this->belongsTo(Siswa::class, 'keterangan');
        // return $this->hasOne('App\Kriteria');
      }
}
