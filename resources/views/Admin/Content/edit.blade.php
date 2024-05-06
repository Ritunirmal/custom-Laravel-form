@extends('Admin.Layout.header')

@section('content')
<!-- Create Form Field Form -->
<section class="section">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Edit Home Content</h5>
                    <form action="{{ route('admin.home.content.edit.save') }}" method="post">

                        @csrf
                        @if (Session::has('success'))
                        <div class="alert alert-success">
                            {{ Session::get('success') }}
                        </div>
                        @endif
                        <input name="id"class="form-check-input" type="hidden" value="{{$data->id}}">
                        
                        <textarea name="content" id="content">"{{$data->content}}</textarea>
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