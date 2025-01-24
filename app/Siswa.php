<?php

namespace App;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    // use HasFactory;
    protected $table = 'siswa';
    
    protected $fillable = [
      'nis', 
      'nama', 
      'alamat', 
      'jenis_kelamin', 
      'tahun', 
      'kelas'
  ];

    public function nilai()
    {
        return $this->hasMany(Nilai::class, 'nis');
    }
    public function Kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas');
    }

}
