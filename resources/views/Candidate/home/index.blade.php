@extends('Candidate.Layout.header')

@section('title', 'Home')

@section('content')
<style>
.personal {
    background-color: #336086;
    color: #fff;
    /* White text color */
    font-weight: bold;
    padding: 10px;
    margin-bottom: 20px;
    /* Add margin to separate from the card body */
    border-radius: 5px;
    /* Optional: Add border-radius for rounded corners */
    text-align: center;
}
.btn-success {
    background-color: #28a745; /* Green background color */
    color: #fff; /* White text color */
    padding: 10px 20px; /* Adjust padding as needed */
    border-radius: 10px; /* Rounded corners */
}
.bg1{
    background-color: #ecf8ee; 
}
.bg2{
    background-color: #f8fdff; 
}
.valid {
        border: 2px solid green;
    }

    .invalid {
        border: 2px solid red;
    }
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">

                <div class="card-header customHeader mb-2 p-2" style="background-color:#1f7950">Signup: <span
                        class="fs14">In online form all the fields
                        marked with red asterisk (*) are compulsory fields. </span> </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('application.form.submit') }}" id="formone">
                        @csrf
                        <input type="hidden" id="min-birth-year" value="{{ $dob->min_year }}">
                        <input type="hidden" id="max-birth-year" value="{{ $dob->max_year }}">
                        <div class="row bg">
                            @foreach($customFormFields->sortBy('sort_order') as $field)
                            @if ($field->sort_order == 1 || $field->sort_order == 2)
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="{{ $field->name }}">{{ $field->label }} @if($field->required ==
                                            1)<span class="red">*</span>@endif</label>
                                    @if ($field->type == 'select')
                                    <select name="{{ $field->name }}" id="{{ $field->name }}" class="form-control">

                                        <option value="">Select {{ $field->label }}</option>
                                        @foreach ($field->options as $option)
                                        <option value="{{ $option->value }}">{{ $option->value }}</option>
                                        @endforeach
                                    </select>
                                    @elseif ($field->type == 'checkbox')
                                    <div class="form-check">
                                        <input type="checkbox" name="{{ $field->name }}" id="{{ $field->name }}"
                                            class="form-check-input">
                                        <label for="{{ $field->name }}"
                                            class="form-check-label">{{ $field->label }}</label>
                                    </div>
                                    @elseif ($field->type == 'radio')
                                    @foreach ($field->options as $option)
                                    <div class="form-check">
                                        <input type="radio" name="{{ $field->name }}" id="{{ $option->value }}"
                                            value="{{ $option->value }}" class="form-check-input">
                                        <label for="{{ $option->value }}"
                                            class="form-check-label">{{ $option->label }}</label>
                                    </div>
                                    @endforeach
                                    @else
                                    <input type="{{$field->type}}" name="{{ $field->name }}" id="{{ $field->name }}"
                                        class="form-control">
                                    @endif
                                </div>
                            </div>
                            @endif

                            @endforeach

                            <div class="personal">Personal Details: </div>
                            <div class="row">
                                @foreach($customFormFields->sortBy('sort_order') as $field)
                                @if ($field->sort_order == 3 || $field->sort_order == 4 || $field->sort_order == 5
                                || $field->sort_order == 6 || $field->sort_order == 7 || $field->sort_order == 8 ||
                                $field->sort_order == 9
                                || $field->sort_order == 10 || $field->sort_order == 11 || $field->sort_order == 12 ||
                                $field->sort_order == 13
                                || $field->sort_order == 14 || $field->sort_order == 15 || $field->sort_order == 16 ||
                                $field->sort_order == 17)
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="{{ $field->name }}">{{ $field->label }} @if($field->required ==
                                            1)<span class="red">*</span>@endif</label>
                                        @if ($field->type == 'select')
                                        <select name="{{ $field->name }}" id="{{ $field->name }}" class="form-control"
                                            data-dependent-id="{{ $field->id}}">
                                            <option value="">Select {{ $field->label }}</option>
                                            @foreach ($field->options as $option)
                                            <option value="{{ $option->value }}"
                                                data-extra-years="{{ $option->data_extra_years }}"
                                                data-field-id="{{ $option->id}}">
                                                {{ $option->value }}</option>
                                            @endforeach
                                        </select>
.
                                        @elseif ($field->type == 'checkbox')
                                        <div class="form-check">
                                            <input type="checkbox" name="{{ $field->name }}" id="{{ $field->name }}"
                                                class="form-check-input" data-field-id="{{ $field->id}}">
                                            <label for="{{ $field->name }}"
                                                class="form-check-label">{{ $field->value }}</label>
                                        </div>
                                        @elseif ($field->type == 'radio')
                                        @foreach ($field->options as $option)
                                        <div class="form-check">
                                            <input type="radio" name="{{ $field->name }}"
                                                id="{{ $field->name }}_{{ $option->value }}"
                                                value="{{ $option->value }}" class="form-check-input"
                                                data-field-id="{{ $option->id}}"
                                                data-extra-years="{{ $option->data_extra_years }}"
                                                data-dependent-id="{{ $field->id}}">
                                            <label for="{{ $option->value }}"
                                                class="form-check-label">{{ $option->value }}</label>
                                        </div>
                                        @endforeach
                                        @elseif ($field->type == 'date')



                                        <input type="date" name="{{ $field->name }}" id="{{ $field->name }}"
                                            class="form-control" data-field-id="{{ $field->id}}"
                                            data-dependent-id="{{ $field->id}}">

                                        <!-- <ul class="error-list"><li class="text-danger" id="dob-error">The dob field is required.</li></ul> -->
                                        @elseif ($field->type == 'email')
                                        @php
                                        $userEmail = Auth::user()->email;
                                        @endphp
                                        <input type="{{$field->type}}" name="{{ $field->name }}" id="{{ $field->name }}"
                                            class="form-control" data-field-id="{{ $field->id}}"
                                            data-dependent-id="{{ $field->id}}" @if($field->pattern)
                                        pattern="{{$field->pattern}}" title="{{$field->title}}" @endif
                                        @if($field->placeholder != null) placeholder="{{ $field->placeholder }}" @endif value="{{ $userEmail }}" readonly>
                                        @else
                                        
                                        <input type="{{$field->type}}" name="{{ $field->name }}" id="{{ $field->name }}" class="form-control" data-field-id="{{ $field->id }}" data-dependent-id="{{ $field->id }}" 
                                        @if($field->pattern) pattern="{{$field->pattern}}" title="{{$field->title}}" @endif
                                        @if($field->placeholder != null) placeholder="{{ $field->placeholder }}" @endif @if($field->name == 'mobile')
                                        @php
                                        $userMobile = Auth::user()->mobile_number; // Retrieve authenticated user's mobile number  
                                        @endphp
                                        value="{{ $userMobile }}" readonly
                                        @else
                                        value=""
                                        @endif>

                                        @endif
                                        <span class="helpLine">
                                            @foreach ($field->notes as $note)
                                            [{{$note->note}}] <br>
                                            @endforeach </span>
                                    </div>
                                </div>
                                @endif
                                @if ($field->sort_order == 18 ||$field->sort_order == 19 ||$field->sort_order == 20 || $field->sort_order == 21 )
                                @if ($field->type == 'date')
                                @if($field->name == 'dob')
                                <div class="col-md-6">

                                </div>
                                <div class="col-md-6">
                                     <label for="{{ $field->name }}">{{ $field->label }}</label>
                                    <input type="text" name="{{ $field->name }}" id="{{ $field->name }}"
                                        class="form-control" data-field-id="{{ $field->id}}"
                                        data-dependent-id="{{ $field->id}}">
                                </div>

                                @endif
                                @elseif($field->type == 'number')
                                <div class="col-md-2">
                                    <label for="{{ $field->name }}">{{ $field->label }}</label>
                                    <input type="{{$field->type}}" name="{{ $field->name }}" id="{{ $field->name }}"
                                        class="form-control" readonly>
                                </div>
                                @endif

                                

                                @endif
                                @if ($field->sort_order == 22)
                                <div class="col-md-12">
                                    @if($field->type == 'checkbox')
                                    <div class="form-check">
                                        <input type="checkbox" name="{{ $field->name }}" id="{{ $field->name }}"
                                            class="form-check-input">
                                        <label for="{{ $field->name }}"
                                            class="form-check-label">{{ $field->label }}</label>
                                    </div>
                                    @endif
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

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
$(document).ready(function() {
    $(document).on('change', 'select, input[type="radio"], input[type="checkbox"]', function() {
        var fieldId = $(this).data('field-id');
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        // alert(fieldId);
        $.ajax({
            type: 'POST',
            url: '{{ route('candidate.data') }}',
            data: {
                field_id: fieldId // Example field_id value
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                console.log(response);
                $.each(response.data, function(optionId, settings) {
                    if (settings.dependent_options === null) {
                        let dependentField = $('[ data-dependent-id="' + settings
                            .dependent_field + '"]');
                        dependentField.prop('disabled', settings.disable_field);
                        // console.log(dependentField);
                        dependentField.val('');
                        // dependentField.closest('.form-check').hide();
                    } else {
                        let inputElement = $('[data-field-id="' + settings
                            .dependent_options + '"]');
                        let formCheckElement = inputElement.closest('.form-check');
                        inputElement.prop('disabled', settings.disable_field);
                        let selectOption = $('select option[data-field-id="' +
                            settings.dependent_options + '"]');
                        let selectOptionDependent = $('select[data-dependent-id="' +
                            settings.dependent_field + '"]');
                        selectOptionDependent.val('');
                        inputElement.prop('checked', false);
                        // console.log('gg');
                        // console.log(selectOptionDependent);
                        if (settings.show_options) {

                            selectOption.hide();

                        } else {

                            selectOption.show();
                        }
                    }


                    // selectOption.prop('disabled', settings.disable_field);
                });
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                // Handle errors here
            }
        });


    });
});
$(document).ready(function() {
    $('#formone').submit(function(event) {
        event.preventDefault();
        $('.text-danger').remove();
        var formData = $(this).serialize();
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: formData,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                console.log(response);
                window.location.replace('/candidate/registration');
            },
            error: function(xhr, status, error) {
                console.log(error);
                if (xhr.status === 422) {
                    // Parse the response text as JSON to access error messages
                    var response = JSON.parse(xhr.responseText);
                    if (response && response.errors) {
                        var errors = response.errors;
                        var errorMessage = response.message;

                        // Display the main error message
                        $('#error-message').html('<div class="alert alert-danger">' +
                            errorMessage + '</div>');

                        // Loop through each field and display its error messages
                        $.each(errors, function(field, messages) {
                            var errorHtml = '<ul class="error-list">';
                            $.each(messages, function(index, message) {
                                errorHtml += '<li class="text-danger">' +
                                    message + '</li>';
                            });
                            errorHtml += '</ul>';

                            // Append error messages after the input field
                            $('[name="' + field + '"]').closest('.form-group')
                                .append(errorHtml);
                        });

                        // Scroll to the first field with an error message and focus on it
                        var firstErrorField = Object.keys(errors)[0];
                        if (firstErrorField) {
                            var $firstErrorField = $('[name="' + firstErrorField + '"]');
                            $('html, body').animate({
                                scrollTop: $firstErrorField.offset().top - 100
                            }, 500);
                            $firstErrorField.focus();
                        }
                    } else {
                        console.error('Unexpected error response:', xhr.responseText);
                        // Handle unexpected error response
                    }
                } else {
                    console.error('Unexpected error:', xhr.statusText);
                    // Handle other types of errors
                }
            }
        });
    });

    // Remove error messages when the form fields are interacted with
    $('#formone input, #formone select').change(function() {
        $(this).next('.text-danger').remove();
    });
});
</script>


<script src="{{asset('assets/js/reg.js')}}"></script>
@endsection