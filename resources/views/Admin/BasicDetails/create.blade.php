@extends('Admin.Layout.header')

@section('content')
<!-- Create Form Field Form -->
<section class="section">
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Add Basic Details  Field</h5>
                    <form action="{{ route('admin.basic.details.form.field.submit') }}" method="post">

                        @csrf
                        @if (Session::has('success'))
                        <div class="alert alert-success">
                            {{ Session::get('success') }}
                        </div>
                        @endif
                        <!-- <input type="text" name="label" class="form-control" id="label"> -->
                        <div class="row mb-3">
                            <label for="name" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10">
                                <input type="text" name="name" class="form-control" id="name">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Field Type</label>
                            <div class="col-sm-10">
                                <select class="form-select" name="type" aria-label="Default select example">
                                    <option>Select Type</option>
                                    <option value="select">Select</option>
                                    <option value="text">Text</option>
                                    <option value="Textarea">textarea</option>
                                    <option value="email">Email</option>
                                    <option value="number">Number</option>
                                    <option value="checkbox">Checkbox</option>
                                    <option value="radio">Radio</option>
                                    <option value="date">Date</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="label" class="col-sm-2 col-form-label">Label</label>
                            <div class="col-sm-10">
                                <input type="text" name="label" class="form-control" id="label">
                            </div>
                        </div>
                        <!-- <div class="row mb-3">
                            <label for="placeholder" class="col-sm-2 col-form-label">Placeholder</label>
                            <div class="col-sm-10">
                                <input type="text" name="placeholder" class="form-control" id="placeholder">
                            </div>
                        </div> -->
                        <div class="row mb-3">
                            <label for="sortorder" class="col-sm-2 col-form-label">Sort Order</label>
                            <div class="col-sm-10">
                                <input type="number" name="sortorder" class="form-control" id="sortorder">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="pattern" class="col-sm-2 col-form-label">Pattern</label>
                            <div class="col-sm-10">
                                <input type="text" name="pattern" class="form-control" id="pattern">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="title" class="col-sm-2 col-form-label">Title</label>
                            <div class="col-sm-10">
                                <input type="text" name="title" class="form-control" id="title">
                            </div>
                        </div>
                      
                        <div class="row mb-3">
                            <label for="required" class="col-sm-2 col-form-label">Required</label>
                            <div class="col-sm-10">
                                <select class="form-select" name="required" aria-label="Default select example">
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="readonly" class="col-sm-2 col-form-label">Readonly</label>
                            <div class="col-sm-10">
                                <select class="form-select" name="readonly" aria-label="Default select example">
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
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