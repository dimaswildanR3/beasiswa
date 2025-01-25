<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orangtua extends Model
{
    // use HasFactory;
    
    protected $table = 'orangtua';
    protected $fillable = ['nis', 'nama', 'angkatan', 'kelas_id', 'jenis_kelamin', 'penghasilan', 'tanggungan'];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'nis');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }
}
