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


<div class="container mt-5">
    <h2 class="mb-4">User Application Details</h2>
    <table class="table table-bordered table-striped" id="preview">
        <tbody>
            <tr>
                <td colspan="3">
                    <a href="#" onclick="printPage()" class="btn btn-success printMe">Print</a>
                </td>
            </tr>
            <tr>
                <td colspan="2">Application Number: <strong>109270</strong></td>
                <td style="text-align:right">ADVERTISEMENT NO: <strong>39/Estb- 2/Rectt/Dr.RMLIMS/2024/</strong></td>
            </tr>
       
            <tr>
                <td><strong class="w30">1.</strong></td>
                <td>Recruitment Type:</td>
                <td><strong>{{$reg->recruitment_type ? $reg->recruitment_type : 'NA'}}</strong></td>
            </tr>
            <tr>
                <td><strong class="w30">2.</strong></td>
                <td>Post Applied For:</td>
                <td><strong>{{$reg->post_applied_for ? $reg->post_applied_for : 'NA'}}</strong></td>
            </tr>
            <tr>
                <td><strong class="w30">3.</strong></td>
                <td>Name in full: (Mr./Ms.)/ पूरा नाम- (श्री/सुश्री):</td>
                <td><strong>{{$reg->name ? $reg->name : 'NA'}}</strong></td>
            </tr>
            <tr>
                <td><strong class="w30">4.</strong></td>
                <td>Email Address / ई-मेल आई.डी.:</td>
                <td><strong>{{$reg->email ? $reg->email : 'NA'}}</strong></td>
            </tr>
            <tr>
                <td><strong class="w30">5.</strong></td>
                <td>Mobile Number / मोबाइल नं:</td>
                <td><strong>{{$reg->mobile ? $reg->mobile : 'NA'}}</strong></td>
            </tr>
            <tr>
                <td><strong class="w30">6.</strong></td>
                <td>Alternate Phone Number / वैकल्पिक फोन नंबर:</td>
                <td><strong>{{$reg->alternate_mobile ? $reg->alternate_mobile : 'NA'}}</strong></td>
            </tr>
            <tr>
                <td><strong class="w30">7.</strong></td>
                <td>Are you Domicile of Uttar Pradesh?:</td>
                <td><strong>{{$reg->are_you_domicile_of_uttar_pradesh ? $reg->are_you_domicile_of_uttar_pradesh : 'NA'}}</strong></td>
            </tr>
            <tr>
                <td><strong class="w30">8.</strong></td>
                <td>Aadhar Number / आधार नंबर:</td>
                <td><strong>{{$reg->aadhar_number ? $reg->aadhar_number : 'NA'}}</strong></td>
            </tr>
            <tr>
                <td><strong class="w30">9.</strong></td>
                <td>Sex: M/F/Prefer not to say / लिंग: पुरुष/महिला:</td>
                <td><strong>{{$reg->gender ? $reg->gender : 'NA'}}</strong></td>
            </tr>
            <tr>
                <td><strong class="w30">10.</strong></td>
                <td>Nationality:</td>
                <td><strong>{{$reg->nationality? $reg->nationality : 'NA'}}</strong></td>
            </tr>
            <tr>
                <td><strong class="w30">11.</strong></td>
                <td>Are you an Ex-Servicemen?:</td>
                <td><strong>{{$reg->are_you_an_exservicemen ? $reg->are_you_an_exservicemen :'NA'}}</strong></td>
            </tr>
            <tr>
                <td><strong class="w30">12.</strong></td>
                <td>Discharge Certificate No:</td>
                <td><strong>{{$reg->discharge_certificate_no ? $reg->discharge_certificate_no :'NA'}}</strong></td>
            </tr>
            <tr>
                <td><strong class="w30">13.</strong></td>
                <td>Date of Issue (Discharge Certificate):</td>
                <td><strong>{{$reg->date_of_issue_exserviceman ? $reg->date_of_issue_exserviceman : 'NA'}}</strong></td>
            </tr>
            <tr>
                <td><strong class="w30">14.</strong></td>
                <td>Period of Service in Defence (in years):</td>
                <td><strong>{{$reg->period_of_service_in_defence ? $reg->period_of_service_in_defence: 'NA'}}</strong></td>
                
            </tr>
            <tr>
                <td><strong class="w30">15.</strong></td>
                <td>Dependent of Freedom-Fighter (DFF):</td>
                <td><strong>{{$reg->dependent_of_freedom_fighter ? $reg->dependent_of_freedom_fighter : 'NA'}}</strong></td>
                
            </tr>
            <tr>
                <td><strong class="w30">16.</strong></td>
                <td>Category- Unreserved/OBC/SC/ST/EWS / वर्ग- सामान्य/./अ.पि.व/अ.जा./अ.ज.जा./आ.क.व:</td>
                <td><strong>{{$reg->category ? $reg->category : 'NA'}}</strong></td>
                
            </tr>
            <tr>
                <td><strong class="w30">17.</strong></td>
                <td>Are you a Person With Benchmark Disabilities (Divyangjan):</td>
                <td><strong>{{$reg->are_you_a_person_with_benchmark_disabilities ? $reg->are_you_a_person_with_benchmark_disabilities : 'NA'}}</strong></td>
                
            </tr>
            <tr>
                <td><strong class="w30">18.</strong></td>
                <td>Date Of Birth:</td>
                <td><strong>{{$reg->dob ? $reg->dob: 'NA' }}</strong></td>
                
            </tr>
            <!-- Add more rows for other application details -->
        </tbody>
    </table>
</div>



<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>




@endsection