<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBasicDetailsField extends Model
{
    use HasFactory;
    protected $table = 'user_basic_details_fields';

    protected $fillable = [
        'user_id',
        'father_name',
        'mother_name',
        'marital_status',
        'spouse_name',
        'pincode',
        'state',
        'city',
        'permanent_address_one',
        'permanent_address_two',
        'correspondence_pincode',
        'correspondence_state',
        'correspondence_city',
        'correspondence_address_one',
        'correspondence_address_two',
        'undertaking'
    ];
}
