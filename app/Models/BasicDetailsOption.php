<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BasicDetailsOption extends Model
{
    use HasFactory;
     protected $fillable = [
        'field_id',
        'value',
    ];

    public function basicDetail()
    {
        return $this->belongsTo(BasicDetails::class, 'field_id');
    }
    
}
