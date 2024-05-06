@extends('Admin.Layout.header')

@section('content')
<!-- Create Form Field Form -->
<section class="section">
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Add Qualification Options</h5>
                    <form action="{{ route('admin.qualification.options.save') }}" method="post" id="addQualificationOptionsForm">

                        @csrf
                        @if (Session::has('success'))
                        <div class="alert alert-success">
                            {{ Session::get('success') }}
                        </div>
                        @endif

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Qualification</label>
                            <div class="col-sm-10">
                                <select class="form-select" name="qualification" aria-label="Default select example">
                                    <option value="">Select Qualification</option>
                                    @foreach($data as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Qualification Options</label>
                            <div class="col-sm-10">
                                <div id="optionsContainer">
                                    <div class="input-group mb-3 option">
                                        
                                        <input type="text" class="form-control" name="option_value[]"
                                            placeholder="Enter option">
                                        <button type="button" class="btn btn-success addOption">+</button>
                                        <button type="button" class="btn btn-danger deleteOption">-</button>
                                    </div>
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
@section('scripts')
<script>
// Function to add a new option input field
function addOptionField() {
    const optionField = `
                <div class="input-group mb-3 option">
                    <input type="text" class="form-control"  name="option_value[]" placeholder="Enter option">
                    <button type="button" class="btn btn-success addOption">+</button>
                    <button type="button" class="btn btn-danger deleteOption">-</button>
                </div>
            `;
    $('#optionsContainer').append(optionField);
}

// Function to delete an option input field
function deleteOptionField() {
    $(this).parent('.option').remove();
}

$(document).ready(function() {
    // Add option button click event
    $('#addQualificationOptionsForm').on('click', '.addOption', addOptionField);
    

    // Delete option button click event
    $('#addQualificationOptionsForm').on('click', '.deleteOption', deleteOptionField);

    // Form submission handling (You can use AJAX to submit the form data)
    // $('#addFieldOptionsForm').on('submit', function(e) {
    //     e.preventDefault();
    //     const formData = $(this).serialize();
    //     console.log(formData); // Replace with your AJAX request
    // });
});
</script>
@endsection