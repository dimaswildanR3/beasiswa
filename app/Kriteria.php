<?php

namespace App;

// use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    // use HasFactory;
    protected $table = 'kriteria';
    
    protected $fillable = ['id_beasiswa','nama','sifat'];
    
    // public function beasiswa()
    // {
    //     return $this->belongsTo('App\Beasiswa');
    // }
    public function beasiswa()
    {
      return $this->belongsTo(Beasiswa::class, 'id_beasiswa');
        // return $this->hasOne('App\Kriteria');
      }

//     public function beasiswa(){
//     return $this->belongsTo('App\Beasiswa');
// }
}