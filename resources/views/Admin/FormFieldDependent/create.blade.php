@extends('Admin.Layout.header')

@section('content')
<!-- Create Form Field Form -->
<section class="section">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Add Dependent Field Options</h5>
                    <form action="{{ route('admin.form.field.dependent.save') }}" method="post">

                        @csrf
                        @if (Session::has('success'))
                        <div class="alert alert-success">
                            {{ Session::get('success') }}
                        </div>
                        @endif

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Field</label>
                            <div class="col-sm-10">
                                <select class="form-select" name="FieldId" aria-label="Default select example">
                                    <option value="">Select Field Id</option>
                                    @foreach($field as $item)
                                    <option value="{{$item->id}}">{{$item->label}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Dependent Field</label>
                            <div class="col-sm-10">
                                <select class="form-select" name="DependentFieldId" aria-label="Default select example">
                                    <option value="">Select Dependent Field Id</option>
                                    @foreach($field as $item)
                                    <option value="{{$item->id}}">{{$item->label}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Field Option</label>
                            <div class="col-sm-10">
                                <select class="form-select" name="FieldOptionId" aria-label="Default select example">
                                    <option value="">Select Field options</option>
                                    @foreach($fieldoptions as $item)
                                    <option value="{{$item->id}}">({{$item->field->label}}) - {{$item->value}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Dependent Field Option</label>
                            <div class="col-sm-10">
                                <select class="form-select" name="DependentFieldOptionId"
                                    aria-label="Default select example">
                                    <option value="">Select Dependent Field options</option>
                                    @foreach($fieldoptions as $item)
                                    <option value="{{$item->id}}">({{$item->field->label}}) - {{$item->value}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <legend class="col-form-label col-sm-2 pt-0">Show And Hide Options</legend>
                            <div class="col-sm-10">

                                <div class="form-check">
                                    <input name="show_hide"class="form-check-input" type="checkbox" id="gridCheck1">
                                    <label class="form-check-label" for="gridCheck1">
                                        Show/Hide
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <legend class="col-form-label col-sm-2 pt-0">Disabled Options</legend>
                            <div class="col-sm-10">

                                <div class="form-check">
                                    <input name="disabled" class="form-check-input" type="checkbox" id="gridCheck2">
                                    <label class="form-check-label" for="gridCheck2">
                                    Disabled/Not Disabled
                                    </label>
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