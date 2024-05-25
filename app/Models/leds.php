<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class leds extends Model
{
    use HasFactory;
    protected $fillable = ['nama_led', 'status','user_id'];

}
