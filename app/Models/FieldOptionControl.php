<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FieldOptionControl extends Model
{
    use HasFactory;
    protected $fillable = [
        'field_id',
        'dependent_field_id',
        'option_id',
        'dependent_option_id',
        'show_options',
        'disable_field',
    ];
    public function field()
    {
        return $this->belongsTo(CustomFormField::class, 'field_id');
    }

    public function dependentField()
    {
        return $this->belongsTo(CustomFormField::class, 'dependent_field_id');
    }

    public function fieldOption()
    {
        return $this->belongsTo(CustomFormFieldOption::class, 'option_id');
    }

    public function dependentOption()
    {
        return $this->belongsTo(CustomFormFieldOption::class, 'dependent_option_id')->withDefault();
    }
}
