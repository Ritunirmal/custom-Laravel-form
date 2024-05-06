@extends('Admin.Layout.header')

@section('content')

<div class="pagetitle">
    <h1>Dashboard</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item active">UnPaid Data</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section dashboard">
    <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-12">
            <div class="row">
            <div class="col-12">
                <table id="unpaid-data" class="table" style="width: 1540px;">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Caste</th>
                            <th>Status</th>
                            <th>Action</th>
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
    const path = window.location.pathname;
const decodedValue = decodeURIComponent(path.split('/').pop());
var urldata='admin/unpaid-candidate/' + decodedValue;
    var table1 = $('#unpaid-data').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '/' + urldata,
            type: 'GET', // Since it's a GET request
        },
        columns: [{
                data: 'id',
                name: 'id'
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'email',
                name: 'email'
            },
            {
                data: 'mobile',
                name: 'mobile'
            },
            {
                data: 'category',
                name: 'category'
            },
            {
                data: 'status',
                name: 'status'
            },
            {
                data: 'action',
                name: 'action'
            },
        ],

    });


});

</script>
@endsection