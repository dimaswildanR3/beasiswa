<?php

namespace App;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beasiswa extends Model
{
    // use HasFactory;
    
    protected $table = 'beasiswa';
    
    protected $fillable = ['nama_beasiswa'];


    public function kriteria()
    {
      return $this->hasOne(kriteria::class, 'id_beasiswa');
        // return $this->hasOne('App\Kriteria');
      }
    //   public function CurhatanAudio(){
    //     return $this->hasOne(CurhatanAudio::class, 'id_curhatan');
    //     // return $this->belongsTo(CurhatanAudio::class, 'id_curhatan');
    // }
    // public function kriteria()
    // {
    //   return $this->hasMany('App\Kriteria');
    // }
}

