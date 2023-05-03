<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comuna extends Model
{
    protected $table = "comunas";
    protected $primaryKey = 'id';

    public $timestamps = false;
}
