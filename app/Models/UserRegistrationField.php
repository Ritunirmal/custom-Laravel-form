<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRegistrationField extends Model
{
    use HasFactory;
    protected $table = 'user_registration_fields';

    protected $fillable = [
        'user_id',
        'recruitment_type',
        'post_applied_for',
        'name',
        'email',
        'mobile',
        'alternate_mobile',
        'are_you_domicile_of_uttar_pradesh',
        'aadhar_number',
        'gender',
        'nationality',
        'are_you_an_exservicemen',
        'discharge_certificate_no',
        'date_of_issue_exserviceman',
        'period_of_service_in_defence',
        'dependent_of_freedom_fighter',
        'are_you_a_person_with_benchmark_disabilities',
        'category',
        'year',
        'month',
        'day',
        'dob',
        'undertaking',
        'fee',
        'status'
    ];
    
}
