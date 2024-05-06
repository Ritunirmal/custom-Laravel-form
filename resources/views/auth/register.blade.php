@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="customHeader mb-2 p-2">Signup: <span class="fs14">In online form all the fields
                    marked with red asterisk (*) are compulsory fields. </span> </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="bg1">
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="row">
                                <div class="col-sm-7 vCenterLine">
                                    <label for="mobileOtp" class="col-form-label">Mobile Number<span
                                            class="red">*</span></label>
                                </div>
                                <div id="otpTimer" class="col-sm-5 vCenterLine">
                                    00:00
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-7 vCenterLine">
                                    <input type="text" autofocus="" id="mobile" name="mobile"
                                        placeholder="Mobile Number" class="form-control w74 bg-red" maxlength="10"
                                        required="" onkeypress="return isNumber(this.key,event);"
                                        pattern="[9876]{1}[0-9]{9}" title="">
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                    <button id="otpSend" type="button" class="btn btn-danger btn-sm mw77"
                                        onclick="sendOTP()">Send
                                        OTP</button>
                                </div>
                                <div class="col-sm-5 vCenterLine">
                                    <input disabled="" type="text" id="otpVerify" name="otpVerify"
                                        placeholder="Enter OTP" class="form-control w56" maxlength="6" title=""
                                        autocomplete="off">

                                    <button id="PhoneVerifyOtpBtn" type="button" disabled="true"
                                        class="btn btn-danger btn-sm" onclick="verifyOTP()">Verify</button>
                                    <i id="PhoneVerifyIcon" class="fa-regular fa-circle-check greenbtn"
                                        style="display:none"></i>
                                </div>
                            </div>
                            <span class="helpLine">[Enter Your Mobile Number without 91 or +91 as
                                9999988888]</span><br>
                            <span class="helpLine2">If mobile number is incorrect, Kindly <a href="#">click
                                    here</a></span>
                        </div>
                        <div class="col-sm-1"></div>
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-sm-7 vCenterLine">
                                    <label for="emailOtp" class="col-form-label">Email
                                        Address<span class="red">*</span></label>
                                </div>
                                <div id="EmailOtp" class="col-sm-5 vCenterLine">
                                    00:00
                                </div>


                            </div>

                            <div class="row">
                                <div class="col-sm-7 vCenterLine">

                                    <input type="email" id="email" name="email" placeholder="Email Address"
                                        class="form-control w74 @error('email') is-invalid @enderror" maxlength="100"
                                        required autocomplete="email" value="{{ old('email') }}">
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror

                                    <button onclick="sendEmailOTP()" id="EmailSendOtpBtn" type="button" class="btn btn-danger btn-sm mw77">Send
                                        OTP</button>
                                </div>
                                <div class="col-sm-5 vCenterLine">

                                    <input disabled="" required="" type="email" id="EmailOtpEnter" name="EmailOtp"
                                        placeholder="Enter OTP" class="form-control w56" maxlength="6" title=""
                                        autocomplete="off">

                                    <button onclick="verifyEmailOTP()" id="EmailVerifyBtn" type="button" disabled="true"
                                        class="btn btn-danger btn-sm">Verify</button> <i id="EmailVerifyIcon"
                                        class="fa-regular fa-circle-check greenbtn" style="display:none"></i>
                                </div>
                            </div>
                            <span class="helpLine">[Enter your correct e-mail address that is current &amp;
                                active. It will
                                also be your unique login Id]<br>
                                [Note that All the communication from Dr. Ram Manohar Lohia Institute of Medical Sciences will be made on this
                                e-mail address
                                only.] </span><br>
                            <span class="helpLine2">If Email ID is incorrect, Kindly <a href="#">click
                                    here</a></span>
                        </div>
                    </div>
                </div>

                <div class="row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Register') }}
                        </button>
                    </div>
                </div>
            </form>


        </div>
    </div>
@endsection
@push('scripts')
    

        
<script>
    var intervalId; // Variable to store the interval ID

    // Function to start the countdown timer
    function startTimer(duration, display) {
        var timer = duration,
            minutes, seconds;
        intervalId = setInterval(function() {
            minutes = parseInt(timer / 60, 10);
            seconds = parseInt(timer % 60, 10);

            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;

            display.textContent = minutes + ":" + seconds;

            if (--timer < 0) {
                // If timer reaches zero, refresh the page
                clearInterval(intervalId);
                window.location.reload(true);
            }
        }, 1000);
    }

    
    function initiateTimer(duration, display) {
        display.style.display = "block"; // Show the timer
        startTimer(duration, display);
    }
    function sendOTP() {
        var mobileNumber = document.getElementById('mobile').value;

        // Make an AJAX request to your backend to send OTP
        $.ajax({
            url: '/send-otp',
            type: 'POST',
            data: {
                mobile: mobileNumber,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    initiateTimer(90, document.getElementById('otpTimer'));
                    alert('OTP sent successfully!');
                    // Enable the Verify button
                    document.getElementById('mobile').disabled = true;
                    document.getElementById('otpSend').disabled = true;
                    document.getElementById('otpVerify').disabled = false;
                    document.getElementById('PhoneVerifyOtpBtn').disabled = false;
                } else {
                    alert('Failed to send OTP. Please try again.');
                }
            },
            error: function() {
                alert('An error occurred while sending OTP.');
            }
        });
    }

    // Function to verify OTP
    function verifyOTP() {
        var enteredOTP = document.getElementById('otpVerify').value;
        var mobileNumber = document.getElementById('mobile').value;
        // Make an AJAX request to your backend to verify OTP
        $.ajax({
            url: '/verify-otp',
            type: 'POST',
            data: {
                otp: enteredOTP,
                mobile: mobileNumber,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    alert('OTP verified successfully!');
                    clearInterval(intervalId); // Stop the timer
                    document.getElementById('otpVerify').disabled = true;
                    document.getElementById('PhoneVerifyOtpBtn').disabled = true;
                    // Display the success icon
                    document.getElementById('PhoneVerifyIcon').style.display = 'inline';
                } else {
                    alert('Invalid OTP. Please try again.');
                }
            },
            error: function() {
                alert('An error occurred while verifying OTP.');
            }
        });
    }
    function sendEmailOTP() {
        var email = document.getElementById('email').value;

        // Make an AJAX request to your backend to send OTP to email
        $.ajax({
            url: '/send-email-otp',
            type: 'POST',
            data: {
                email: email,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if(response.success) {
                    initiateTimer(90, document.getElementById('EmailOtp')); // Start the timer (90 seconds)
                    alert('OTP sent to email successfully!');
                    // Enable the Verify button
                    document.getElementById('email').disabled = true;
                    document.getElementById('EmailSendOtpBtn').disabled = true;
                    document.getElementById('EmailVerifyBtn').disabled = false;
                    document.getElementById('EmailOtpEnter').disabled = false;
                } else {
                    alert('Failed to send OTP to email. Please try again.');
                }
            },
            error: function() {
                alert('An error occurred while sending OTP to email.');
            }
        });
    }

    // Function to verify email OTP
    function verifyEmailOTP() {
        var enteredOTP = document.getElementById('EmailOtpEnter').value;
        var email = document.getElementById('email').value;

        // Make an AJAX request to your backend to verify email OTP
        $.ajax({
            url: '/verify-email-otp',
            type: 'POST',
            data: {
                otp: enteredOTP,
                email:email,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if(response.success) {
                    alert('Email OTP verified successfully!');
                    clearInterval(intervalId); // Stop the timer
                    // Display the success icon
                    document.getElementById('EmailVerifyBtn').disabled = true;
                    document.getElementById('EmailOtpEnter').disabled = true;
                    document.getElementById('EmailVerifyIcon').style.display = 'inline';
                } else {
                    alert('Invalid Email OTP. Please try again.');
                }
            },
            error: function() {
                alert('An error occurred while verifying Email OTP.');
            }
        });
    }
    </script>
        @endpush