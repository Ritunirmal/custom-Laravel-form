<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserRegistrationField;
use DataTables;
class AdminPaidController extends Controller
{
    public function AdminPaidData(Request $request, $post)
    {
       
        if ($request->ajax()) {
            // $postName = str_replace('_', '', $post);
    
            $paidData = UserRegistrationField::
                where('post_applied_for', $post)
                ->where('user_registration_fields.status','Paid')
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

     
        return view('Admin.Data.paid');
    }
   
}
