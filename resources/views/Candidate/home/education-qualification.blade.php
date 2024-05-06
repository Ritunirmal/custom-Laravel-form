@extends('Candidate.Layout.header')

@section('content')
<style>
/* Reset default browser styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Body styles */
body {
    font-family: Arial, sans-serif;
    background-color: #f2f2f2;
}

.qualification-row {
    margin-bottom: 20px;
    background-color: #f9f9f9;
    border-radius: 8px;
    padding: 15px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.qualification-row label {
    font-weight: bold;
}

/* Optional: Adjust styles for input fields */
.qualification-row input[type="text"],
.qualification-row input[type="file"] {
    width: 100%;
    padding: 8px;
    margin-top: 5px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
}


.btn-upload-document {
    display: inline-block;
    padding: 8px 16px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 4px;
    text-decoration: none;
    cursor: pointer;
}

.btn-upload-document:hover {
    background-color: #0056b3;
    /* Darker shade of blue on hover */
}
.btn-success {
    background-color: #28a745; /* Green background color */
    color: #fff; /* White text color */
    padding: 10px 20px; /* Adjust padding as needed */
    border-radius: 10px; /* Rounded corners */
}
.basic{
    background: #1f7950;
    color: #fff;
    font-size: 20px;
    display: flex;
    justify-content: space-between;
    font-weight: 700;
    align-items: center;
}
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
            <div class="card-header basic mb-2 p-2">Educational Qualifications:
                <span class="fs14">In online form all thefields marked with red asterisk (*) are compulsory fields. </span>
             </div>
                <div id="tabs" class="ui-tabs">
    <ul class="ui-tabs-nav">
    <li class="ui-state-default {{ request()->is('candidate/registration') ? 'ui-state-active' : '' }}">
            <a href="{{ route('candidate.registration') }}" class="ui-tabs-anchor">Sign Up</a>
            <div class="triangle"></div>
            <div class="triangle-2"></div>
        </li>
        <li class="ui-state-default {{ request()->is('candidate/basic-details') ? 'ui-state-active' : '' }}">
            <a href="{{ route('candidate.basic.detail') }}" class="ui-tabs-anchor">Basic Details</a>
            <div class="triangle"></div>
            <div class="triangle-2"></div>
        </li>
        <li class="ui-state-default {{ request()->is('candidate/educational-qualifications') ? 'ui-state-active' : '' }}">
            
            <a href="{{ route('candidate.educational.qualifications') }}" class="ui-tabs-anchor">Educational Qualifications</a>
            <div class="triangle"></div>
            <div class="triangle-2"></div>
        </li>
        <li class="ui-state-default {{ request()->is('candidate/experience-details') ? 'ui-state-active' : '' }}">
            <a href="{{ route('candidate.experience.details') }}" class="ui-tabs-anchor">Experience Details</a>
            <div class="triangle"></div>
            <div class="triangle-2"></div>
        </li>
        <li class="ui-state-default {{ request()->is('candidate/documents-upload') ? 'ui-state-active' : '' }}">
            
            <a href="{{ route('candidate.documents.upload') }}" class="ui-tabs-anchor">Documents Upload</a>
            <div class="triangle"></div>
            <div class="triangle-2"></div>
        </li>
    </ul>
</div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <form method="POST" action="{{ url('/educational-qualifications-submit') }}" id="formthree"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="container">
                            @php $first = true; @endphp
                            @foreach($qualifications as $key=>$qualification)

                            @if ($qualification->input_type != 'checkbox')
                            <input type="hidden" name="reuired[]" id="" class="form-check-input"
                                value="{{$qualification->mandatory}}">
                            <div class="row qualification-row">
                                @if($first)
                                <div class="col-md-2">
                                    <label for="qualification">Qualification</label>
                                </div>
                                <div class="col-md-2">
                                    <label for="board_institute">Board/Institute</label>
                                </div>
                                <div class="col-md-2">
                                    <label for="subject">Subject</label>
                                </div>
                                <div class="col-md-1">
                                    <label for="year">Year</label>
                                </div>
                                <div class="col-md-2">
                                    <label for="percentage">Percentage of Marks</label>
                                </div>
                                <div class="col-3">
                                    <label for="documents">Upload Documents (Max 2 MB)</label>
                                </div>
                                @php $first = false; @endphp
                                @endif
                                @php
                                $userValue = isset($UserQualifiation[$key]->qualification_name) ?
                                $UserQualifiation[$key]->qualification_name: null;
                                $userbord = isset($UserQualifiation[$key]->board_name) ?
                                $UserQualifiation[$key]->board_name: null;
                                $subject = isset($UserQualifiation[$key]->subject) ? $UserQualifiation[$key]->subject:
                                null;
                                $yearofpassing = isset($UserQualifiation[$key]->year_of_passing) ?
                                $UserQualifiation[$key]->year_of_passing: null;
                                $percentage = isset($UserQualifiation[$key]->percentage) ?
                                $UserQualifiation[$key]->percentage: null;
                                $document = isset($UserQualifiation[$key]->document) ?
                                $UserQualifiation[$key]->document: null;
                                @endphp
                                <div class="col-md-2">
                                    @if ($qualification->input_type == 'select')
                                    <select name="qualification_name[]" class="form-control">

                                        <option value="">Select {{ $qualification->name }}</option>
                                        @foreach ($qualification->DropdownOption as $option)
                                        <option value="{{ $option->option }}" @if ($userValue==$option->option) selected
                                            @endif>{{ $option->option }}</option>
                                        @endforeach
                                    </select>
                                    @elseif ($qualification->input_type == 'input')
                                    <input type="text" name="qualification_name[]" class="form-control"
                                        data-field-id="{{ $qualification->id}}" value="{{ $qualification->name }}"
                                        readonly>
                                    @elseif ($qualification->input_type == 'checkbox')
                                    <div class="form-check">
                                        <input type="checkbox" name="qualification_name[]"
                                            id="{{ $qualification->name }}" class="form-check-input">
                                        <label for="{{ $qualification->name }}"
                                            class="form-check-label">{{ $qualification->name }}</label>
                                    </div>
                                    @endif
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control" name="board_name[]" value="{{ $userbord }}">
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control" name="subject[]" value="{{ $subject }}">
                                </div>
                                <div class="col-md-1">
                                    <select class="form-control" name="year_of_passing[]">
                                        <option value="">Year of Passing</option>
                                        @php
                                        $currentYear = date('Y');
                                        @endphp
                                        @for($i = $currentYear; $i >= 1950; $i--)
                                        <option value="{{ $i }}" @if ($yearofpassing==$i) selected @endif>{{ $i }}
                                        </option>
                                        @endfor
                                    </select>


                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control" name="percentage[]" value="{{$percentage}}">
                                </div>
                                <div class="col-3">
                                    <input type="file" class="form-control-file file-input btn-upload-document"
                                        data-qualification-id="{{$qualification->id}}" name="documents[]"
                                        accept=".jpg, .jpeg, .png, .pdf" value="{{$document}}">
                                    <input type="hidden" name="documents[]" class="uploaded-document" value="{{$document}}">
                                    <span style="font-size: smaller;color: red;"
                                        class="uploaded-document">{{$document}}</span>
                                </div>


                            </div>
                            @endif
                            @endforeach
                            @foreach($qualificationscheckbox as $key => $qualification)
                            @if ($qualification->input_type == 'checkbox')
                            @php
                            $UserQualifiationCheckboxdata = isset($UserQualifiationCheckbox[$key]->checkbox_name) ?
                            $UserQualifiationCheckbox[$key]->checkbox_name: null;
                            $UserQualifiationCheckboxdatachecked = isset($UserQualifiationCheckbox[$key]->checked) ?
                            $UserQualifiationCheckbox[$key]->checked: null;
                            @endphp

                            <div class="row qualification-row">
                                <div class="col-md-12">
                                    <div class="form-check">
                                        <!-- Hidden input with value 0 -->
                                        <input type="hidden" name="qualification_name_for_checkbox[]"
                                            value="{{ $qualification->name }}">
                                        <input type="hidden" name="qualification_ids[]"
                                            value="{{ $qualification->id }}">
                                        <input type="hidden"
                                            name="qualification_name_checkbox[{{ $qualification->id }}]" value="0">

                                        <!-- Checkbox input -->
                                        <input type="checkbox"
                                            name="qualification_name_checkbox[{{ $qualification->id }}]"
                                            id="{{ $qualification->id }}" class="form-check-input" @if (($UserQualifiationCheckboxdata==$qualification->name) && ($UserQualifiationCheckboxdatachecked == 1)) checked 
                                        @endif @if ($qualification->mandatory == 1) required 
                                        @endif>
                                        <label for="{{ $qualification->name }}"
                                            class="form-check-label">{{ $qualification->name }}</label>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @endforeach


                        </div>


                        <div class="row">
    <div class="col-md-12 text-center">
        <button type="submit" class="btn btn-lg btn-success">Save & Continue</button>
    </div>
</div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
@push('scripts')

<script>
$(document).ready(function() {
    $('#formthree').submit(function(event) {
        // Prevent the default form submission behavior
        event.preventDefault();

        // Remove any existing error messages
        $('.error-message').remove();
        var isValid = true;
        $('input[type="text"], input[type="number"], input[type="hidden"], input[type="date"], select')
            .each(function() {
                var input = $(this);
                if (input.is('select')) {
                    if (input.val().trim() === '') {
                        isValid = false;
                        input.after('<span class="error-message">This field is required</span>');
                    }
                } else if (input.attr('name') === 'percentage[]') {
                    var percentage = parseInt(input.val().trim());
                    if (isNaN(percentage) || percentage > 100) {
                        isValid = false;
                        input.after(
                            '<span class="error-message">Percentage must be between 0 and 100</span>'
                        );
                    }
                } else {
                    if (input.val().trim() === '') {
                        isValid = false;
                        input.after('<span class="error-message">This field is required</span>');
                    }
                }
            });

        if (isValid) {

            var formData = $(this).serialize();
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                success: function(response) {
                    window.location.replace('/candidate/experience-details');
                },
                error: function(xhr, status, error) {
                    // Handle error response
                }
            })

        }

    });

    // Remove error messages when the form fields are interacted with
    $('#formone input, #formone select').change(function() {
        $(this).next('.text-danger').remove();
    });
});

$(document).ready(function() {
    $('.btn-upload-document').click(function() {
        var qualificationId = $(this).data('qualification-id');
        $(this).siblings('.file-input').click(); // Trigger the corresponding file input
    });

    $('.file-input').change(function() {
        var file = this.files[0];
        var qualificationId = $(this).data('qualification-id');
        var uploadedDocumentSpan = $(this).siblings('.uploaded-document');
        var fileInput = $(this); // Store a reference to the file input

        // Prepare form data to send to the backend
        var formData = new FormData();
        formData.append('file', file);
        formData.append('qualification_id', qualificationId);

        // Send AJAX request to upload the file
        $.ajax({
            url: '/education-document-upload', // Update the URL with your backend endpoint
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                // Handle success response
                console.log('Document uploaded successfully');


                // Clear the file input to allow re-uploading the same file
                fileInput.val('');
                uploadedDocumentSpan.text(response
                    .fileName); // Display the uploaded document name
                fileInput.siblings('input[type="hidden"]').val(response.fileName);
            },
            error: function(xhr, status, error) {
                // Handle error response
                console.error('Error uploading document:', error);
            }
        });
    });
});
</script>

@endpush