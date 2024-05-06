<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BirthYear extends Model
{
    use HasFactory;
    protected $fillable = ['min_year', 'max_year'];
}
