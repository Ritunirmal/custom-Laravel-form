@extends('Admin.Layout.header')


@section('content')
<div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="mb-3">
                    <a href="{{ route('admin.form.field.options.create') }}" class="btn btn-primary">Add Form Field Options</a>
                </div>
                <table id="form-fields-option-table" class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Field</th>
                            <th>Option</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    
@endsection

