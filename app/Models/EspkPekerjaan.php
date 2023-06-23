<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EspkPekerjaan extends Model
{
  use HasFactory;

  protected $table = 'espk_pekerjaans';

  protected $connection = 'mysql2';
}
