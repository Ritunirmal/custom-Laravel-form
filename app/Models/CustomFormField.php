<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomFormField extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'type',
        'label',
        'sort_order',
        'required',
        'pattern',
        'title',
        'placeholder'
    ];

    public function options()
    {
        return $this->hasMany(CustomFormFieldOption::class, 'field_id');
    }
    public function fieldDependentOptions()
    {
        return $this->hasMany(FieldOptionControl::class, 'field_id');
    }
    public function notes()
    {
        return $this->hasMany(FieldNote::class, 'field_id');
    }
}
