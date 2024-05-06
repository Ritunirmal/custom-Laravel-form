@extends('Candidate.Layout.header')

@section('title', 'Home')

@section('content')
<style>
.personal {
    background-color: #007bff;
    /* Blue background color */
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
.basic{
    background: #1f7950;
    color: #fff;
    font-size: 20px;
    display: flex;
    justify-content: space-between;
    font-weight: 700;
    align-items: center;
}
.btn-success {
    background-color: #28a745; /* Green background color */
    color: #fff; /* White text color */
    padding: 10px 20px; /* Adjust padding as needed */
    border-radius: 10px; /* Rounded corners */
}

</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
            <div class="card-header basic mb-2 p-2">Basic Details <span class="fs14">In online form all the
                            fields marked with red asterisk (*) are compulsory fields. </span> </div>
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

                <div class="card-header customHeader2 mb-2 p-2">Personal Details:</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('candidate.basic.detail.save') }}" id="formone">
                        @csrf
                        <div class="row">
                            @foreach($customFormFields->sortBy('sort_order') as $field)
                            @php
                            $userValue = isset($UserData->{$field->name}) ? $UserData->{$field->name} : null;
                            @endphp
                            @if ($field->sort_order == 1 || $field->sort_order == 2 || $field->sort_order == 3 ||
                            $field->sort_order == 4)
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="{{ $field->name }}">{{ $field->label }} @if($field->required ==
                                            1)<span class="red">*</span>@endif</label>
                                    @if ($field->type == 'select')
                                    <select name="{{ $field->name }}" id="{{ $field->name }}" class="form-control">

                                        <option value="">Select {{ $field->label }}</option>
                                        @foreach ($field->options as $option)
                                        <option @if ($userValue == $option->value) selected @endif value="{{ $option->value }}">{{ $option->value }}</option>
                                        @endforeach
                                    </select>
                                    @elseif ($field->type == 'text')
                                    <input type="text" name="{{ $field->name }}" id="{{ $field->name }}"
                                        class="form-control" data-field-id="{{ $field->id}}"  value="{{ $userValue }}"  @if ($field->readonly  == 1) readonly @endif @if($field->pattern)
                                        pattern="{{$field->pattern}}" title="{{$field->title}}" @endif >
                                    @elseif ($field->type == 'textarea')
                                    <input type="textarea" name="{{ $field->name }}" id="{{ $field->name }}"
                                        class="form-control" data-field-id="{{ $field->id}}"  value="{{ $userValue }}"  @if ($field->readonly  == 1) readonly @endif @if($field->pattern)
                                        pattern="{{$field->pattern}}" title="{{$field->title}}" @endif>
                                     @elseif ($field->type == 'email')
                                    <input type="email" name="{{ $field->name }}" id="{{ $field->name }}"
                                        class="form-control" data-field-id="{{ $field->id}}"  value="{{ $userValue }}"  @if ($field->readonly  == 1) readonly @endif @if($field->pattern)
                                        pattern="{{$field->pattern}}" title="{{$field->title}}" @endif>
                                    @elseif ($field->type == 'number')
                                    <input type="number" name="{{ $field->name }}" id="{{ $field->name }}"
                                        class="form-control" data-field-id="{{ $field->id}}"  value="{{ $userValue }}"  @if ($field->readonly  == 1) readonly @endif @if($field->pattern)
                                        pattern="{{$field->pattern}}" title="{{$field->title}}" @endif>
                                   
                                    @elseif ($field->type == 'checkbox')
                                    <div class="form-check">
                                        <input type="checkbox" name="{{ $field->name }}" id="{{ $field->name }}"
                                            class="form-check-input" @if ($userValue) checked @endif>
                                        <label for="{{ $field->name }}"
                                            class="form-check-label">{{ $field->label }}</label>
                                    </div>

                                    @elseif ($field->type == 'radio')
                                    @foreach ($field->options as $option)
                                    <div class="form-check">
                                        <input type="radio" name="{{ $field->name }}" id="{{ $option->value }}"
                                            value="{{ $option->value }}" class="form-check-input"
                                            data-field-id="{{ $option->id}}" @if ($userValue) checked @endif>
                                        <label for="{{ $option->value }}"
                                            class="form-check-label">{{ $option->value }}</label>
                                    </div>
                                    @endforeach
                                    @elseif ($field->type == 'date')
                                    <input type="date" name="{{ $field->name }}" id="{{ $field->name }}"
                                        class="form-control">
                                    @endif
                                </div>
                            </div>
                            @endif

                            @endforeach

                            <div class="card-header customHeader2 mb-2 p-2">Permanent Address / स्थायी पता: </div>
                            <div class="row">
                                @foreach($customFormFields->sortBy('sort_order') as $field)
                                @if ($field->sort_order == 5 || $field->sort_order == 6 || $field->sort_order == 7 ||
                            $field->sort_order == 8 || $field->sort_order == 9)
                            @php
                            $userValue = isset($UserData->{$field->name}) ? $UserData->{$field->name} : null;
                            @endphp
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="{{ $field->name }}">{{ $field->label }} @if($field->required ==
                                            1)<span class="red">*</span>@endif</label>
                                        @if ($field->type == 'select')
                                        <select name="{{ $field->name }}" id="{{ $field->name }}" class="form-control"
                                            data-dependent-id="{{ $field->id}}">
                                            <option value="">Select {{ $field->label }}</option>
                                            @foreach ($field->options as $option)
                                            <option value="{{ $option->value }}" data-field-id="{{ $option->id}}" @if ($userValue == $option->value) selected @endif>
                                                {{ $option->value }}</option>
                                            @endforeach
                                        </select>
                                        @elseif ($field->type == 'text')
                                    <input type="text" name="{{ $field->name }}" id="{{ $field->name }}"
                                        class="form-control" data-field-id="{{ $field->id}}"  value="{{ $userValue }}"  @if ($field->readonly  == 1) readonly @endif>
                                    @elseif ($field->type == 'textarea')
                                    <input type="textarea" name="{{ $field->name }}" id="{{ $field->name }}"
                                        class="form-control" data-field-id="{{ $field->id}}"  value="{{ $userValue }}"  @if ($field->readonly  == 1) readonly @endif>
                                     @elseif ($field->type == 'email')
                                    <input type="email" name="{{ $field->name }}" id="{{ $field->name }}"
                                        class="form-control" data-field-id="{{ $field->id}}"  value="{{ $userValue }}"  @if ($field->readonly  == 1) readonly @endif>
                                    @elseif ($field->type == 'number')
                                    <input type="number" name="{{ $field->name }}" id="{{ $field->name }}"
                                        class="form-control" data-field-id="{{ $field->id}}"  value="{{ $userValue }}"  @if ($field->readonly  == 1) readonly @endif>
                                        
                                       
                                        @elseif ($field->type == 'checkbox')
                                        <div class="form-check">
                                            <input type="checkbox" name="{{ $field->name }}" id="{{ $field->name }}"
                                                class="form-check-input" @if ($userValue) checked @endif>
                                            <label for="{{ $field->name }}"
                                                class="form-check-label">{{ $field->value }}</label>
                                        </div>
                                        @elseif ($field->type == 'radio')
                                        @foreach ($field->options as $option)
                                        <div class="form-check">
                                            <input type="radio" name="{{ $field->name }}" id="{{ $option->value }}"
                                                value="{{ $option->value }}" class="form-check-input"
                                                data-field-id="{{ $option->id}}" @if ($userValue) checked @endif>
                                            <label for="{{ $option->value }}"
                                                class="form-check-label">{{ $option->value }}</label>
                                        </div>
                                        @endforeach
                                        @elseif ($field->type == 'date')
                                        <input type="date" name="{{ $field->name }}" id="{{ $field->name }}"
                                            class="form-control">
                                        @endif

                                    </div>
                                </div>
                                @endif
                               @endforeach

                            </div>

                            <div class="card-header customHeader2 mb-2 p-2">Correspondence Address / पत्राचार हेतु पता: </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-check">
                                        <input type="checkbox" name="copy_address" id="copy_address" class="form-check-input">
                                        <label for="copy_address" class="form-check-label">Same as Permanent Address</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                @foreach($customFormFields->sortBy('sort_order') as $field)
                                @if ($field->sort_order == 10 || $field->sort_order == 11 || $field->sort_order == 12 ||
                            $field->sort_order == 13 || $field->sort_order == 14)
                            @php
                            $userValue = isset($UserData->{$field->name}) ? $UserData->{$field->name} : null;
                            
                            @endphp
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="{{ $field->name }}">{{ $field->label }} @if($field->required ==
                                            1)<span class="red">*</span>@endif</label>
                                        @if ($field->type == 'select')
                                        <select name="{{ $field->name }}" id="{{ $field->name }}" class="form-control"
                                            data-dependent-id="{{ $field->id}}" >
                                            <option value="">Select {{ $field->label }}</option>
                                            @foreach ($field->options as $option)
                                            <option value="{{ $option->value }}" data-field-id="{{ $option->id}}" @if ($userValue == $option->value) selected @endif>
                                                {{ $option->value }}</option>
                                            @endforeach
                                        </select>
                                        @elseif ($field->type == 'text')
                                    <input type="text" name="{{ $field->name }}" id="{{ $field->name }}"
                                        class="form-control" data-field-id="{{ $field->id}}"  value="{{ $userValue }}"  @if ($field->readonly  == 1) readonly @endif @if($field->pattern)
                                        pattern="{{$field->pattern}}" title="{{$field->title}}" @endif>
                                    @elseif ($field->type == 'textarea')
                                    <input type="textarea" name="{{ $field->name }}" id="{{ $field->name }}"
                                        class="form-control" data-field-id="{{ $field->id}}"  value="{{ $userValue }}"  @if ($field->readonly  == 1) readonly @endif @if($field->pattern)
                                        pattern="{{$field->pattern}}" title="{{$field->title}}" @endif>
                                     @elseif ($field->type == 'email')
                                    <input type="email" name="{{ $field->name }}" id="{{ $field->name }}"
                                        class="form-control" data-field-id="{{ $field->id}}"  value="{{ $userValue }}"  @if ($field->readonly  == 1) readonly @endif @if($field->pattern)
                                        pattern="{{$field->pattern}}" title="{{$field->title}}" @endif>
                                    @elseif ($field->type == 'number')
                                    <input type="number" name="{{ $field->name }}" id="{{ $field->name }}"
                                        class="form-control" data-field-id="{{ $field->id}}"  value="{{ $userValue }}"  @if ($field->readonly  == 1) readonly @endif @if($field->pattern)
                                        pattern="{{$field->pattern}}" title="{{$field->title}}" @endif>
                                        
                                        @elseif ($field->type == 'checkbox') 
                                        <div class="form-check">
                                            <input type="checkbox" name="{{ $field->name }}" id="{{ $field->name }}"
                                                class="form-check-input" @if ($userValue) checked @endif>
                                            <label for="{{ $field->name }}"
                                                class="form-check-label">{{ $field->value }}</label>
                                        </div>
                                        @elseif ($field->type == 'radio')
                                        @foreach ($field->options as $option)
                                        <div class="form-check">
                                            <input type="radio" name="{{ $field->name }}" id="{{ $option->value }}"
                                                value="{{ $option->value }}" class="form-check-input"
                                                data-field-id="{{ $option->id}}" @if ($userValue) checked @endif>
                                            <label for="{{ $option->value }}"
                                                class="form-check-label">{{ $option->value }}</label>
                                        </div>
                                        @endforeach
                                        @elseif ($field->type == 'date')
                                        <input type="date" name="{{ $field->name }}" id="{{ $field->name }}"
                                            class="form-control">
                                        @endif

                                    </div>
                                </div>
                                @endif
                                @if ($field->sort_order == 15)
                                @php
                            $userValue = isset($UserData->{$field->name}) ? $UserData->{$field->name} : null;
                            
                            @endphp
                                <div class="col-md-12">
                                    @if($field->type == 'checkbox')
                                    <div class="form-check">
                                        <input type="checkbox" name="{{ $field->name }}" id="{{ $field->name }}"
                                            class="form-check-input" @if ($userValue) checked @endif>
                                        <label for="{{ $field->name }}"
                                            class="form-check-label">{{ $field->label }}</label>
                                    </div>
                                
                                @endif
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


<!-- Add this script section to the bottom of your HTML file -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    


// Add event listener to all elements with name 'pin_code'




$(document).ready(function() {
    $(document).on('change', 'select, input[type="radio"], input[type="checkbox"]', function() {
        var fieldId = $(this).data('field-id');
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: 'POST',
            url: '{{ route('candidate.basic.details.data') }}',
            data: {
                field_id: fieldId // Example field_id value
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                console.log(response);
                $.each(response.dependent_options, function(optionId, settings) {
                    // Find the input element
                    let inputElement = $('[data-field-id="' + optionId + '"]');
                    let formCheckElement = inputElement.closest('.form-check');

                    // Apply settings to input element if found
                    if (inputElement.length > 0) {
                        if (inputElement.is('select')) {
                            let selectOption = inputElement.find(
                                'option[data-field-id="' + optionId + '"]');
                            if (selectOption.length > 0) {
                                if (settings.show_options) {
                                    selectOption.hide();
                                } else {
                                    selectOption.show();
                                }
                            }
                        } else {
                            inputElement.prop('disabled', settings.disable_field);
                        }
                    } else if (settings
                        .dependent_field) { // If dependent_field_id is provided
                        // Find the dependent input element
                        let dependentInputElement = $('[data-field-id="' + settings
                            .dependent_field + '"]');
                        // Apply settings to dependent input element if found
                        if (dependentInputElement.length > 0) {
                            if (dependentInputElement.is('select')) {
                                let dependentSelectOptions = dependentInputElement
                                    .find('option');
                                if (settings.show_options) {
                                    dependentSelectOptions.hide();
                                } else {
                                    dependentSelectOptions.show();
                                }
                            }
                            dependentInputElement.prop('disabled', settings
                                .disable_field);
                        }
                    }
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
                window.location.replace('/candidate/educational-qualifications');
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

<script>
    $(document).ready(function() {
        $('#copy_address').change(function() {
            if ($(this).is(':checked')) {
                // Copy permanent address to correspondence address
                $('#correspondence_pincode').val($('#pincode').val());
                $('#correspondence_city').val($('#city').val());
                $('#correspondence_state').val($('#state').val());
                $('#correspondence_address_one').val($('#permanent_address_one').val());
                $('#correspondence_address_two').val($('#permanent_address_two').val());
                // You can copy other fields here if needed
            } else {
                // Clear correspondence address when unchecked
                $('#correspondence_pincode').val('');
                $('#correspondence_city').val('');
                $('#correspondence_state').val('');
                $('#correspondence_address_one').val('');
                $('#correspondence_address_two').val('');
                // You can clear other fields here if needed
            }
        });
    });
</script>
<script src="{{asset('assets/js/basicdetails.js')}}"></script>

@endsection