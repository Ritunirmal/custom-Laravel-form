@extends('Admin.Layout.header')

@section('content')
<!-- Create Form Field Form -->
<section class="section">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Add Note Field Options</h5>
                    <form action="{{ route('admin.form.field.note.edit.save') }}" method="post">

                        @csrf
                        @if (Session::has('success'))
                        <div class="alert alert-success">
                            {{ Session::get('success') }}
                        </div>
                        @endif
                        <input name="id"class="form-check-input" type="hidden" value="{{$data->id}}">
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Field</label>
                            <div class="col-sm-10">
                                <select class="form-select" name="FieldId" aria-label="Default select example">
                                    <option value="">Select Field Id</option>
                                    @foreach($field as $item)
                                    <option value="{{$item->id}}" @if($data->field_id  == $item->id) selected @endif>{{$item->label}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="note" class="col-sm-2 col-form-label">Note</label>
                            <div class="col-sm-10">
                                <input type="text" name="note" class="form-control" id="note" value="{{$data->note}}">
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <!-- <button type="reset" class="btn btn-secondary">Reset</button> -->
                        </div>
                    </form><!-- End Horizontal Form -->
                </div>
            </div>
        </div>
    </div>
</section>


<a href="{{ route('admin.form.field') }}">Back to Form Fields</a>

@endsection