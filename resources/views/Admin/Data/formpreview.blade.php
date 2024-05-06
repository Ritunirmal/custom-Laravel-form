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


<div class="container">
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





        </tbody>
    </table>
    <section class="section">
        <div class="row">
            <div class="col-lg-6">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"></h5>
                        @php
                        $counter = 1;
                        @endphp

                        <table class="table">
                            <tbody>
                                @foreach($reg->toArray() as $key => $value)
                                @php

                                $customFormField = App\Models\CustomFormField::where('name', $key)->first();

                                @endphp
                                <tr>
                                    <th scope="row">{{ $counter }}.</th>

                                    @if($customFormField)
                                    <td>{{ $customFormField->label }}</td>
                                    <td><strong>{{$value ? $value : 'NA'}}</strong></td>
                                    @else
                                    <td>{{ $key }}</td>
                                    <td><strong>{{$value ? $value : 'NA'}}</strong></td>
                                    @endif
                                </tr>
                                @php
                                $counter++; // Increment counter
                                @endphp
                                @endforeach

                            </tbody>
                        </table>
                        <!-- End Default Table Example -->
                    </div>
                </div>


            </div>
            <div class="col-lg-6">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"></h5>
                        @php
                        $counter2 = $counter;
                        @endphp


                        <table class="table">
                            <tbody>
                                @foreach($basic->toArray() as $key => $value)
                                @php

                                $BasicDetails = App\Models\BasicDetails::where('name', $key)->first();

                                @endphp
                                <tr>
                                    <th scope="row">{{ $counter2 }}.</th>

                                    @if($BasicDetails)
                                    <td>{{ $BasicDetails->label }}</td>
                                    <td><strong>{{$value ? $value : 'NA'}}</strong></td>
                                    @else
                                    <td>{{ $key }}</td>
                                    <td><strong>{{$value ? $value : 'NA'}}</strong></td>
                                    @endif
                                </tr>
                                @php
                                $counter2++; // Increment counter
                                @endphp
                                @endforeach

                            </tbody>
                        </table>
                        <!-- End Default Table Example -->
                    </div>
                </div>


            </div>

        </div>

    </section>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Qualification</h5>

                        <!-- Table with stripped rows -->
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Qualification</th>
                                    <th scope="col">Board / Institute</th>
                                    <th scope="col">Subject</th>
                                    <th scope="col">Year of Passing</th>
                                    <th scope="col">Percentage of marks</th>
                                    <th scope="col">Uploaded Documents</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $counter3 = $counter2;
                                @endphp
                                @foreach($UserQualifiation as $value)
                                <tr>
                                    <th scope="row">{{$counter3}}</th>
                                    <td>{{$value->qualification_name}}</td>
                                    <td>{{$value->board_name}}</td>
                                    <td>{{$value->year_of_passing}}</td>
                                    <td>{{$value->subject}}</td>
                                    <td>{{$value->percentage}}</td>
                                    <td><a href="/uploads/{{$value->user_id}}/education_documents/{{$value->document}}"
                                            class="btn btn-success rounded-pill">Document</a></td>
                                </tr>
                                @php
                                $counter3++; // Increment counter
                                @endphp
                                @endforeach
                                @foreach($UserQualifiationCheckbox as $value)
                                <tr>
                                    <td colspan="8">
                                        <input type="checkbox" @if($value->checked == 1) checked @endif> {{$value->checkbox_name}}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->

                    </div>
                </div>


            </div>


        </div>

    </section>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Experience</h5>

                        <!-- Table with stripped rows -->
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Organization</th>
                                    <th scope="col">Job description</th>
                                    <th scope="col">Joining date</th>
                                    <th scope="col">Leaving date</th>
                                    <th scope="col">certificate</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $counter4 = $counter3;
                                @endphp
                                @foreach($UserExperience as $value)
                                <tr>
                                    <th scope="row">{{$counter4}}</th>
                                    <td>{{$value->organization}}</td>
                                    <td>{{$value->job_description}}</td>
                                    <td>{{$value->joining_date}}</td>
                                    <td>{{$value->leaving_date}}</td>
                                    <td><a href="{{$value->certificate}}"
                                            class="btn btn-success rounded-pill">Certificate</a></td>
                                </tr>
                                @php
                                $counter4++; // Increment counter
                                @endphp
                                @endforeach
                                
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->

                    </div>
                </div>


            </div>


        </div>

    </section>
</div>



<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>




@endsection