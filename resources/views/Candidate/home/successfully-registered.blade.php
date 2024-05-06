@extends('Candidate.Layout.header')

@section('title', 'Home')

@section('content')
<style>
body {
    background-color: #f8f9fa;
    font-family: 'Roboto', sans-serif;
}

.pay {
    max-width: 600px;
    margin: 100px auto;
}

.thank-you-container {
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    padding: 30px;
}

.success-icon {
    width: 80px;
    height: 80px;
    margin-bottom: 20px;
}

.thank-you-title {
    color: #333;
    margin-bottom: 10px;
}

.thank-you-message {
    color: #555;
    font-size: 18px;
    line-height: 1.5;
}


</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">


<div class="container pay">
    <div class="thank-you-container text-center">
        <img src="{{asset('logo/register.jpg')}}" alt="Success Icon" class="success-icon">
        <h2 class="thank-you-title">Thank You</h2>
        <a href="/form-preview">Your Application Has Been Successfully Submitted Online</a>
        <p class="thank-you-message">Your Application Has Been Successfully Submitted Online</p>
    </div>
</div>



<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>




@endsection