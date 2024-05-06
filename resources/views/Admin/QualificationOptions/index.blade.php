@extends('Admin.Layout.header')


@section('content')
<div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="mb-3">
                    <a href="{{ route('admin.qualification.options.create') }}" class="btn btn-primary">Add Qualification Options</a>
                </div>
                <table id="qualification-option-table" class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Qualification</th>
                            <th>Option</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    
@endsection

