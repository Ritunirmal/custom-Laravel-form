@extends('Admin.Layout.header')
@section('content')
<!-- Create Form Field Form -->
<section class="section">
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Edit Form Field</h5>
                    <form action="{{ route('admin.qualification.edit.save') }}" method="post">
                        @csrf
                        
                        @if (Session::has('success'))
                        <div class="alert alert-success">
                            {{ Session::get('success') }}
                        </div>
                        @endif
                        <input name="id"class="form-check-input" type="hidden" value="{{$qualification->id}}">
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Post</label>
                            <div class="col-sm-10">
                                <select class="form-select" name="post_id" aria-label="Default select example">
                                    <option value="">Select Field options</option>
                                    @foreach($fieldoptions as $item)
                                    <option value="{{$item->id}}" {{ $qualification->post_id === $item->id ? 'selected' : '' }}>{{$item->value}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="qualifications_name" class="col-sm-2 col-form-label">Qualification Name</label>
                            <div class="col-sm-10">
                                <input type="text" name="qualifications_name" class="form-control" id="qualifications_name" value="{{$qualification->qualifications_name}}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="name" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10">
                                <input type="text" name="name" class="form-control" id="name" value="{{$qualification->name}}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Field Type</label>
                            <div class="col-sm-10">
                                <select class="form-select" name="input_type" aria-label="Default select example">
                                <option value="input" {{ $qualification->input_type === 'input' ? 'selected' : '' }}>Input
                                    </option>
                                    <option value="select" {{ $qualification->input_type === 'select' ? 'selected' : '' }}>Select
                                    </option>
                                    <option value="radio" {{ $qualification->input_type === 'radio' ? 'selected' : '' }}>Checkbox
                                    </option>
                                    <option value="date" {{ $qualification->input_type === 'date' ? 'selected' : '' }}>Date
                                    </option>
                                    <option value="checkbox" {{ $qualification->input_type === 'checkbox' ? 'selected' : '' }}>Checkbox
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="sortorder" class="col-sm-2 col-form-label">Sort Order</label>
                            <div class="col-sm-10">
                                <input type="number" name="sortorder" class="form-control" id="sortorder" value="{{ $qualification->sort_order }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <legend class="col-form-label col-sm-2 pt-0">Mandatory</legend>
                            <div class="col-sm-10">

                                <div class="form-check">
                                    <input name="mandatory"class="form-check-input" type="checkbox" id="gridCheck1"  @if($qualification->mandatory == 1) checked @endif >
                                </div>
                            </div>
                        </div>
                        
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('admin.form.field.show') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                </div>


                </form>
            </div>
        </div>
    </div>
    </div>
</section>


<a href="{{ route('admin.form.field.show') }}">Back to Form Fields</a>

@endsection