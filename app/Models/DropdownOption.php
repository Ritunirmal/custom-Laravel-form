<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DropdownOption extends Model
{
    use HasFactory;
    protected $fillable = [
        'qualification_id',
        'option',
    ];
    public function qualificationOptions()
    {
        return $this->belongsTo(Qualification::class);
    }
}
