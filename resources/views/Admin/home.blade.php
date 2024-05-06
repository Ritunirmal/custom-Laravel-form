@extends('Admin.Layout.header')

@section('content')

<div class="pagetitle">
    <h1>Dashboard</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section dashboard">
    <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-12">
            <div class="row">

                <!-- Sales Card -->
                <div class="col-xxl-3 col-md-4">
                    <div class="card info-card sales-card">


                        <div class="card-body">
                            <h5 class="card-title">Register<span>| Today</span></h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-people"></i>
                                </div>
                                <div class="ps-3">
                                    <h6 id="userCount">{{$userCount}}</h6>

                                </div>
                            </div>
                        </div>

                    </div>
                </div><!-- End Sales Card -->

                <!-- Revenue Card -->
                <div class="col-xxl-3 col-md-4">
                    <div class="card info-card revenue-card">

                        <div class="card-body">
                            <h5 class="card-title">Paid <span>| Today</span></h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-currency-dollar"></i>
                                </div>
                                <div class="ps-3">
                                    <h6 id="paidTodayCount">{{$paidTodayCount}}</h6>

                                </div>
                            </div>
                        </div>

                    </div>
                </div><!-- End Revenue Card -->
                <!-- Revenue Card -->
                <div class="col-xxl-3 col-md-4">
                    <div class="card info-card revenue-card">

                        <div class="card-body">
                            <h5 class="card-title">Paid <span>| Candidate</span></h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-currency-dollar"></i>
                                </div>
                                <div class="ps-3">
                                    <h6 id="paidUsersCount">{{$paidUsersCount}}</h6>

                                </div>
                            </div>
                        </div>

                    </div>
                </div><!-- End Revenue Card -->
                <!-- Revenue Card -->
                <div class="col-xxl-3 col-md-4">
                    <div class="card info-card revenue-card">

                        <div class="card-body">
                            <h5 class="card-title">Unpaid <span>| Candidate</span></h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-currency-dollar"></i>
                                </div>
                                <div class="ps-3">
                                    <h6 id="unpaidUsersCount">{{$unpaidUsersCount}}</h6>
                                </div>
                            </div>
                        </div>

                    </div>
                </div><!-- End Revenue Card -->

            </div><!-- End Customers Card -->



            <!-- Recent Sales -->
            <div class="col-12">
                <table id="post-data-table" class="table" style="width: 1540px;">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Post Name</th>
                            <th>Paid</th>
                            <th>Unpaid</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div><!-- End Left side columns -->
    </div>
</section>


@endsection
@section('scripts')
<script>
$(document).ready(function() {
    var table1 = $('#post-data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.home') }}",
        columns: [{
                data: 'id',
                name: 'id'
            },
            {
                data: 'Post',
                name: 'Post'
            },
            {
                data: 'Paid',
                name: 'Paid'
            },
            {
                data: 'UnPaid',
                name: 'UnPaid'
            },
        ],

    });


});
// Define a function to fetch updated data using AJAX
function fetchDataAndUpdate() {

    $.ajax({
        url: '{{ route('admin.candidate.status') }}', // Replace with your actual route
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            // Update the HTML elements with the new data
            $('#userCount').text(data.userCount);
            $('#paidTodayCount').text(data.paidTodayCount);
            $('#paidUsersCount').text(data.paidUsersCount);
            $('#unpaidUsersCount').text(data.unpaidUsersCount);
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
}

// Call the fetchDataAndUpdate function initially
fetchDataAndUpdate();

// Call the fetchDataAndUpdate function every 60 seconds (adjust the interval as needed)
setInterval(fetchDataAndUpdate, 10000); // 60000 milliseconds = 60 seconds
</script>
@endsection