<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDocument extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'document_name','document','name','span']; // Add other fillable fields as needed

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
