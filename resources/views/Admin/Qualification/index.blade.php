@extends('Admin.Layout.header')


@section('content')
<div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="mb-3">
                    <a href="{{ route('admin.qualification.add') }}" class="btn btn-primary">Add Qualification</a>
                </div>
                <table id="qualificationt-table" class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Post</th>
                            <th>Name</th>
                            <th>Type</th>
                            <!-- <th>Status</th> -->
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    
@endsection

