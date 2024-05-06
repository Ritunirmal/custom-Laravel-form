<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExperienceForm extends Model
{
    use HasFactory;
    protected $fillable = ['user_id ', 'total_experience','value_stored'];
}
