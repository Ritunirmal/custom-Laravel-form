<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BasicDetailsControl extends Model
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
        return $this->belongsTo(BasicDetails::class, 'field_id');
    }

    public function dependentField()
    {
        return $this->belongsTo(BasicDetails::class, 'dependent_field_id');
    }

    public function fieldOption()
    {
        return $this->belongsTo(BasicDetailsOption::class, 'option_id');
    }

    public function dependentOption()
    {
        return $this->belongsTo(BasicDetailsOption::class, 'dependent_option_id');
    }
}
