@extends('Admin.Layout.header')

@section('content')
<!-- Create Form Field Form -->
<section class="section">
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Add Home Data</h5>
                    <form action="{{ route('admin.home.data.save') }}" method="post"  enctype="multipart/form-data">

                        @csrf
                        @if (Session::has('success'))
                        <div class="alert alert-success">
                            {{ Session::get('success') }}
                        </div>
                        @endif
                        <!-- <input type="text" name="label" class="form-control" id="label"> -->
                        <div class="row mb-3">
                            <label for="content" class="col-sm-2 col-form-label">logo</label>
                            <div class="col-sm-10">
                            <input type="file" name="logo" class="form-control" id="logo">
                            </div>
                        </div>
                     
                        <div class="row mb-3">
                            <label for="content" class="col-sm-2 col-form-label">Heading</label>
                            <div class="col-sm-10">
                            <input type="text" name="heading" class="form-control" id="heading">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="content" class="col-sm-2 col-form-label">Post</label>
                            <div class="col-sm-10">
                            <input type="text" name="post" class="form-control" id="post">
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


<a href="{{ route('admin.home.content') }}">Back to Home Content</a>

@endsection
@section('scripts')


 
    @endsection