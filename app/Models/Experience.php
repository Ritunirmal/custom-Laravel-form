<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;
    protected $fillable = ['organization', 'job_description', 'joining_date', 'leaving_date', 'years','months','days','certificate'];

}
