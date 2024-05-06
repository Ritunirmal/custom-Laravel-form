@extends('Admin.Layout.header')

@section('content')
<!-- Create Form Field Form -->
<section class="section">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Edit Home Content</h5>
                    <form action="{{ route('admin.home.data.edit.save') }}" method="post" enctype="multipart/form-data">

                        @csrf
                        @if (Session::has('success'))
                        <div class="alert alert-success">
                            {{ Session::get('success') }}
                        </div>
                        @endif
                        <div class="row mb-3">
                            <label for="content" class="col-sm-2 col-form-label">logo</label>
                            <div class="col-sm-10">
                            <input type="file" name="logo" class="form-control" id="logo" value="{{$data->logo}}">
                            @if($data->logo)
            <img src="{{$data->logo}}" alt="Logo Preview" style="max-width: 200px; max-height: 200px;">
            @endif
                            </div>
                        </div>
                     
                        <div class="row mb-3">
                            <label for="content" class="col-sm-2 col-form-label">Heading</label>
                            <div class="col-sm-10">
                            <input type="text" name="heading" class="form-control" id="heading" value="{{$data->heading}}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="content" class="col-sm-2 col-form-label">Post</label>
                            <div class="col-sm-10">
                            <input type="text" name="post" class="form-control" id="post" value="{{$data->post}}">
                            </div>
                        </div>
                        <input name="id"class="form-check-input" type="hidden" value="{{$data->id}}">
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


<a href="{{ route('admin.home.content') }}">Back to Form Fields</a>

@endsection
@section('scripts')

<script src="https://cdn.ckeditor.com/ckeditor5/35.1.0/classic/ckeditor.js"></script>
        <script>
            ClassicEditor
                .create(document.querySelector('#content'))
                .catch(error => {
                    console.error(error);
                });
        </script>

 
    @endsection