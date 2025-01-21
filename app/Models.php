<?php

namespace App;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Models extends Model
{
    // use HasFactory;
    protected $table = 'model';
    
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
}
