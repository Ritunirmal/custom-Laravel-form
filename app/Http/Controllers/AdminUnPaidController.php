<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserRegistrationField;
use App\Models\CustomFormField;
use App\Models\UserBasicDetailsField;   
use App\Models\UserQualification;  
use App\Models\UserQualificationCheckbox;  
use App\Models\Experience;  


use DataTables;

class AdminUnPaidController extends Controller
{
    public function AdminUnPaidData(Request $request, $post)
    {
       
        if ($request->ajax()) {
       
            $paidData = UserRegistrationField::
                where('post_applied_for', $post)
                ->where('user_registration_fields.status','Unpaid')
                ->get();
                // dd($paidData);
            return DataTables::of($paidData)
          
           
            ->addColumn('action', function ($paidData) {
             
                $paid = '<a href="/admin/candidate/' . $paidData->user_id .'" class="edit btn btn-primary btn-sm"><i class="bi bi-eye-fill"></i></a>';
                return $paid;
            })
          
           
            ->rawColumns(['action'])
            ->make(true);
        }

     
        return view('Admin.Data.unpaid');
    }
    public function CandidateData(Request $request,$id)
    {
    
       
        $reg = UserRegistrationField::select('recruitment_type', 'post_applied_for','name','mobile','alternate_mobile','are_you_domicile_of_uttar_pradesh','aadhar_number','gender','nationality','are_you_an_exservicemen','discharge_certificate_no','date_of_issue_exserviceman','period_of_service_in_defence','dependent_of_freedom_fighter','category','are_you_a_person_with_benchmark_disabilities','dob','status')
        ->where('user_id', $id)->first();
        $basic = UserBasicDetailsField::select('father_name', 'mother_name','marital_status','spouse_name','pincode','city','state','permanent_address_one','permanent_address_two','correspondence_pincode','correspondence_city','correspondence_state','correspondence_address_one','correspondence_address_two')
        ->where('user_id', $id)->first();
        $UserQualifiation = UserQualification::where('user_id', $id)->get();
        $UserQualifiationCheckbox = UserQualificationCheckbox::where('user_id', $id)->get();
        $UserExperience = Experience::where('user_id', $id)->get();
    // print_r($reg->toArray());
   
        return view('Admin.Data.formpreview',compact('reg','basic','UserQualifiation','UserQualifiationCheckbox','UserExperience'));
        
    }
}
