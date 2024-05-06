@extends('Admin.Layout.header')


@section('content')
<div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="mb-3">
                    <a href="{{ route('admin.form.field') }}" class="btn btn-primary">Add Form Field</a>
                </div>
                <table id="form-fields-table" class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Label</th>
                            <th>Type</th>
                            <th>Sort Order</th>
                            <!-- <th>Status</th> -->
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    
@endsection

