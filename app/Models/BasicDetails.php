<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BasicDetails extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'type',
        'label',
        'sort_order',
        'is_active',
        'pattern',
        'title',
        'required',
        'readonly'
    ];
    public function options()
    {
        return $this->hasMany(BasicDetailsOption::class, 'field_id');
    }
    public function fieldDependentOptions()
    {
        return $this->hasMany(BasicDetailsControl::class, 'field_id');
    }
}
