<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cabang extends Model
{
    use HasFactory;

    protected $table = 'master_cabangs';

    protected $connection = 'mysql2';

    public function antrianPengunjung() {
        return $this->hasMany(AntrianPengunjung::class, 'master_cabang_id', 'id');
    }

    public function antrianSementara() {
        return $this->hasMany(AntrianSementara::class, 'cabang_id', 'id');
    }
}
