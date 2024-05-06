<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Qualification extends Model
{
    use HasFactory;
    protected $fillable = [
        'post_id',
        'name',
        'input_type',
        'sort_order',
        'is_active',
        'qualifications_name'
    ];
    public function CustomFormFieldOption()
    {
        return $this->belongsTo(CustomFormFieldOption::class,'post_id');
    }
    public function DropdownOption()
    {
        return $this->hasMany(DropdownOption::class,'qualification_id');
    }
}
