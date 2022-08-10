<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    protected $table = 'master_karyawans';

    protected $connection = 'mysql2';

    public function jabatan() {
        return $this->belongsTo(Jabatan::class, 'master_jabatan_id', 'id');
    }

    public function cabang() {
        return $this->belongsTo(Cabang::class, 'master_cabang_id', 'id');
    }
}
