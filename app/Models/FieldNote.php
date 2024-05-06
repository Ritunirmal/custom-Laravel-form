<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FieldNote extends Model
{
    use HasFactory;
    protected $fillable = ['field_id', 'note'];
    public function field()
    {
        return $this->belongsTo(CustomFormField::class, 'field_id');
    }
}
