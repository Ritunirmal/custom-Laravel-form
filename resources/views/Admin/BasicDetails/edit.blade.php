@extends('Admin.Layout.header')
@section('content')
<!-- Create Form Field Form -->
<section class="section">
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Edit Form Field</h5>
                    <form action="{{ route('admin.basic.details.form.field.update', $formField->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        @if (Session::has('success'))
                        <div class="alert alert-success">
                            {{ Session::get('success') }}
                        </div>
                        @endif
                        <!-- <input type="hidden" name="disabled" class="form-control" value="{{ $formField->disabled }}"> -->
                        <input type="hidden" name="form_field_id" value="{{ $formField->id }}">

                        <div class="row mb-3">
                            <label for="name" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10">

                                <input type="text" name="name" class="form-control" id="name"
                                    value="{{ $formField->name }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Field Type</label>
                            <div class="col-sm-10">
                                <select class="form-select" name="type" aria-label="Default select example">
                                    <!-- Select the correct option based on the current type -->
                                    <option value="select" {{ $formField->type === 'select' ? 'selected' : '' }}>Select</option>
                                    <option value="text" {{ $formField->type === 'text' ? 'selected' : '' }}>Text</option>
                                    <option value="textarea" {{ $formField->type === 'textarea' ? 'selected' : '' }}>Textarea</option>
                                    <option value="email" {{ $formField->type === 'email' ? 'selected' : '' }}>Email</option>
                                    <option value="number" {{ $formField->type === 'number' ? 'selected' : '' }}>Number</option>
                                    <option value="checkbox" {{ $formField->type === 'checkbox' ? 'selected' : '' }}>Checkbox</option>
                                    <option value="radio" {{ $formField->type === 'radio' ? 'selected' : '' }}>Radio</option>
                                    <option value="date" {{ $formField->type === 'date' ? 'selected' : '' }}>Date</option>
                                
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="label" class="col-sm-2 col-form-label">Label</label>
                            <div class="col-sm-10">
                                <input type="text" name="label" class="form-control" id="label" value="{{ $formField->label }}">
                            </div>
                        </div>
                        <!-- <div class="row mb-3">
                            <label for="placeholder" class="col-sm-2 col-form-label">Placeholder</label>
                            <div class="col-sm-10">
                                <input type="text" name="placeholder" class="form-control" id="placeholder" value="{{ $formField->placeholder }}">
                            </div>
                        </div> -->
                        <div class="row mb-3">
                            <label for="sortorder" class="col-sm-2 col-form-label">Sort Order</label>
                            <div class="col-sm-10">
                                <input type="number" name="sort_order" class="form-control" id="sortorder" value="{{ $formField->sort_order }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="pattern" class="col-sm-2 col-form-label">Pattern</label>
                            <div class="col-sm-10">
                                <input type="text" name="pattern" class="form-control" id="pattern" value="{{ $formField->pattern }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="title" class="col-sm-2 col-form-label">Title</label>
                            <div class="col-sm-10">
                                <input type="text" name="title" class="form-control" id="title" value="{{ $formField->title }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="required" class="col-sm-2 col-form-label">Required</label>
                            <div class="col-sm-10">
                                <select class="form-select" name="required" aria-label="Default select example">
                                    <option @if($formField->required== 1 ) selected @endif value="1">Yes</option>
                                    <option  @if($formField->required== 0 ) selected @endif  value="0">No</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="readonly" class="col-sm-2 col-form-label">Readonly</label>
                            <div class="col-sm-10">
                                <select class="form-select" name="readonly" aria-label="Default select example">
                                    <option @if($formField->readonly== 1 ) selected @endif value="1">Yes</option>
                                    <option  @if($formField->readonly== 0 ) selected @endif  value="0">No</option>
                                </select>
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