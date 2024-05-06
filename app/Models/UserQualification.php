<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserQualification extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'qualification_name', 'board_name', 'year_of_passing', 'subject', 'percentage', 'document'
    ];
  
    
}
