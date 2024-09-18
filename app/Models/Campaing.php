<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaing extends Model
{
    use HasFactory;
    protected $fillable = ['campaing_title','start_date','end_date','image','status','discount','month','year'];
}
