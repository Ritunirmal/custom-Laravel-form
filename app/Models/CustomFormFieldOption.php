<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomFormFieldOption extends Model
{
    use HasFactory;
    protected $fillable = [
        'field_id',
        'value',
    ];

    public function field()
    {
        return $this->belongsTo(CustomFormField::class, 'field_id');
    }
    public function qualification()
    {
        return $this->hasMany(Qualification::class, 'post_id');
    }
}
