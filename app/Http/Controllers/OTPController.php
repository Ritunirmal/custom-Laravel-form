<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\OTPMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class OTPController extends Controller
{
    public function sendOTP(Request $request)
    {
        // Validate the mobile number
        $request->validate([
            'mobile' => ['required', 'numeric', 'digits:10']
        ]);

        // Check if the mobile number already exists in the otps table
        $existingOTP = DB::table('otps')
            ->where('mobile_number', $request->mobile)
            ->first();

        if ($existingOTP) {
            // If the OTP is already verified, don't generate a new one
            if ($existingOTP->verified) {
                return response()->json(['success' => false, 'message' => 'OTP already verified']);
            } else {
                // Update the existing OTP with a new one
                $otp = rand(100000, 999999);
                DB::table('otps')
                    ->where('mobile_number', $request->mobile)
                    ->update([
                        'otp' => $otp,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
            }
        } else {
            // Generate a new OTP
            $otp = rand(100000, 999999);
            // Store the new OTP in the database
            DB::table('otps')->insert([
                'mobile_number' => $request->mobile,
                'otp' => $otp,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return response()->json(['success' => true, 'otp' => $otp]);
    }
    public function verifyOTP(Request $request)
    {
        // Validate the OTP
        $request->validate([
            'mobile' => ['required', 'numeric', 'digits:10'],
            'otp' => ['required', 'numeric', 'digits:6'],
        ]);

        // Check if the OTP exists in the database
        $otpData = DB::table('otps')
                    ->where('mobile_number', $request->mobile)
                    ->where('otp', $request->otp)
                    ->first();

        if ($otpData) {
            // OTP verification successful
            // You can also update the verification status in the database if needed
            DB::table('otps')
            ->where('mobile_number', $request->mobile)
            ->update([
                'verified' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
          Session::put('verified_mobile', $request->mobile);
        //   $mobileNumber= Session::get('verified_mobile');
        //     dd($mobileNumber);
            return response()->json(['success' => true]);
        } else {
            // OTP verification failed
            return response()->json(['success' => false]);
        }
    }
    public function sendEmailOTP(Request $request)
    {
        // Validate the email
        $request->validate([
            'email' => ['required']
        ]);

        // Check if the email  already exists in the otps table
        $existingOTP = DB::table('otps')
            ->where('email', $request->email)
            ->first();

        if ($existingOTP) {
            // If the OTP is already verified, don't generate a new one
            if ($existingOTP->verified) {
                return response()->json(['success' => false, 'message' => 'OTP already verified']);
            } else {
                // Update the existing OTP with a new one
                $otp = rand(100000, 999999);
                DB::table('otps')
                    ->where('email', $request->email)
                    ->update([
                        'otp' => $otp,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
            }
        } else {
            // Generate a new OTP
            $otp = rand(100000, 999999);
            // Store the new OTP in the database
            DB::table('otps')->insert([
                'email' => $request->email,
                'otp' => $otp,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return response()->json(['success' => true, 'otp' => $otp]);
    }
    public function EmailverifyOTP(Request $request)
    {
        // Validate the OTP
        $request->validate([
            'email' => ['required'],
            'otp' => ['required', 'numeric', 'digits:6'],
        ]);

        // Check if the OTP exists in the database
        $otpData = DB::table('otps')
                    ->where('email', $request->email)
                    ->where('otp', $request->otp)
                    ->first();

        if ($otpData) {
            // OTP verification successful
            // You can also update the verification status in the database if needed
            DB::table('otps')
            ->where('email', $request->email)
            ->update([
                'verified' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                
            ]);
            Session::put('verified_email', $request->email);
            
            return response()->json(['success' => true]);
        } else {
            // OTP verification failed
            return response()->json(['success' => false]);
        }
    }
}
