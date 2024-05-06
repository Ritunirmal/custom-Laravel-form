@extends('Admin.Layout.header')

@section('content')
<!-- Create Form Field Form -->
<section class="section">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Add Dependent Field Options</h5>
                    <form action="{{ route('admin.qualification.save') }}" method="post">

                        @csrf
                        @if (Session::has('success'))
                        <div class="alert alert-success">
                            {{ Session::get('success') }}
                        </div>
                        @endif

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Post</label>
                            <div class="col-sm-10">
                                <select class="form-select" name="post_id" aria-label="Default select example">
                                    <option value="">Select Field options</option>
                                    @foreach($fieldoptions as $item)
                                    <option value="{{$item->id}}">{{$item->value}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="qualifications_name" class="col-sm-2 col-form-label">Qualification Name</label>
                            <div class="col-sm-10">
                                <input type="text" name="qualifications_name" class="form-control" id="qualifications_name">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="name" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10">
                                <input type="text" name="name" class="form-control" id="name">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Field Type</label>
                            <div class="col-sm-10">
                                <select class="form-select" name="input_type" aria-label="Default select example">
                                    <option value="input">Input</option>
                                    <option value="select">Select</option>
                                    <option value="radio">Radio</option>
                                    <option value="checkbox">Checkbox</option>
                                    <option value="date">Date</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="sortorder" class="col-sm-2 col-form-label">Sort Order</label>
                            <div class="col-sm-10">
                                <input type="number" name="sortorder" class="form-control" id="sortorder">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <legend class="col-form-label col-sm-2 pt-0">Mandatory</legend>
                            <div class="col-sm-10">

                                <div class="form-check">
                                    <input name="mandatory"class="form-check-input" type="checkbox" id="gridCheck1">
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="reset" class="btn btn-secondary">Reset</button>
                        </div>
                    </form><!-- End Horizontal Form -->
                </div>
            </div>
        </div>
    </div>
</section>


<a href="{{ route('admin.form.field') }}">Back to Form Fields</a>

@endsection