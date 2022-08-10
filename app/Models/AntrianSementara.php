<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AntrianSementara extends Model
{
    use HasFactory;

    protected $connection = 'mysql';

    public function karyawan() {
        return $this->belongsTo(Karyawan::class, 'karyawan_id', 'id');
    }
}
