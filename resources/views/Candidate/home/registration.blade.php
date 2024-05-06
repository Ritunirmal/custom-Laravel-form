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

                <div class="card-header customHeader mb-2 p-2" style="background-color:#1f7950">Signup: <span class="fs14">In online form all the fields
                        marked with red asterisk (*) are compulsory fields. </span> </div>
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
                    <form method="Get" action="{{ route('candidate.basic.detail') }}" id="formone">
                        <div class="row">
                            @foreach($customFormFields->sortBy('sort_order') as $field)
                            @php
                            $userValue = isset($UserData->{$field->name}) ? $UserData->{$field->name} : null;
                         
                            @endphp
                            @if ($field->sort_order == 1 || $field->sort_order == 2)
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="{{ $field->name }}">{{ $field->label }}</label>
                                    @if ($field->type == 'select')
                                    <select name="{{ $field->name }}" id="{{ $field->name }}" class="form-control" disabled>

                                        <option value="">Select {{ $field->label }}</option>
                                        @foreach ($field->options as $option)
                                        <option value="{{ $option->value }}" @if ($userValue == $option->value) selected @endif >{{ $option->value }}</option>
                                        @endforeach
                                    </select>
                                    @elseif ($field->type == 'input')
                                    <input type="text" name="{{ $field->name }}" id="{{ $field->name }}"
                                        class="form-control"   value="{{ $userValue }}" disabled>
                                    @elseif ($field->type == 'checkbox')
                                    <div class="form-check">
                                        <input type="checkbox" name="{{ $field->name }}" id="{{ $field->name }}"
                                            class="form-check-input"  @if ($userValue) checked @endif disabled>
                                        <label for="{{ $field->name }}"
                                            class="form-check-label">{{ $field->label }}</label>
                                    </div>
                                    @elseif ($field->type == 'radio')
                                    @foreach ($field->options as $option)
                                    <div class="form-check">
                                        <input type="radio" name="{{ $field->name }}" id="{{ $option->value }}"
                                            value="{{ $option->value }}" class="form-check-input"  @if ($userValue) checked @endif disabled>
                                        <label for="{{ $option->value }}"
                                            class="form-check-label">{{ $option->label }}</label>
                                    </div>
                                    @endforeach
                                    @elseif ($field->type == 'date')
                                    <input type="date" name="{{ $field->name }}" id="{{ $field->name }}"
                                        class="form-control" disabled>
                                    @endif
                                </div>
                            </div>
                            @endif

                            @endforeach

                            <div class="personal">Personal Details: </div>
                            <div class="row">
                                @foreach($customFormFields->sortBy('sort_order') as $field)
                                @php
                            $userValue = isset($UserData->{$field->name}) ? $UserData->{$field->name} : null;
                         
                         
                            @endphp
                            @if ($field->sort_order == 3 || $field->sort_order == 4 || $field->sort_order == 5
                                || $field->sort_order == 6 || $field->sort_order == 7 || $field->sort_order == 8 || $field->sort_order == 9 
                                || $field->sort_order == 10 || $field->sort_order == 11 || $field->sort_order == 12 || $field->sort_order == 13 
                                || $field->sort_order == 14 || $field->sort_order == 15 || $field->sort_order == 16 || $field->sort_order == 17)
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="{{ $field->name }}">{{ $field->label }}</label>
                                        @if ($field->type == 'select')
                                        <select name="{{ $field->name }}" id="{{ $field->name }}" class="form-control"
                                            data-dependent-id="{{ $field->id}}" disabled>
                                            <option value="">Select {{ $field->label }}</option>
                                            @foreach ($field->options as $option)
                                            <option value="{{ $option->value }}" data-field-id="{{ $option->id}}" @if ($userValue == $option->value) selected @endif>
                                                {{ $option->value }}</option>
                                            @endforeach
                                        </select>
                                      
                                        @elseif ($field->type == 'checkbox')
                                        <div class="form-check">
                                            <input type="checkbox" name="{{ $field->name }}" id="{{ $field->name }}"
                                                class="form-check-input"  @if ($userValue) checked @endif disabled>
                                            <label for="{{ $field->name }}"
                                                class="form-check-label">{{ $field->value }}</label>
                                        </div>
                                        @elseif ($field->type == 'radio')
                                        @foreach ($field->options as $option)
                                        <div class="form-check">
                                            <input type="radio" name="{{ $field->name }}" id="{{ $option->value }}"
                                                value="{{ $option->value }}" class="form-check-input"
                                                data-field-id="{{ $option->id}}"  @if ($userValue == $option->value) checked @endif disabled>
                                            <label for="{{ $option->value }}"
                                                class="form-check-label">{{ $option->value }}</label>
                                        </div>
                                        @endforeach
                                        
                                        @elseif ($field->type == 'date')
                                        <input type="date" name="{{ $field->name }}" id="{{ $field->name }}"
                                            class="form-control"  value="{{ $userValue }}" disabled>
                                     @elseif ($field->type == 'email')
                                        <input type="email" name="{{ $field->name }}" id="{{ $field->name }}"
                                            class="form-control"   value="{{ $userValue }}" disabled>
                                    @else
                                        <input type="text" name="{{ $field->name }}" id="{{ $field->name }}"
                                            class="form-control"   value="{{ $userValue }}" disabled>
                                        @endif
                                        <span class="helpLine">
                                            @foreach ($field->notes as $note)
                                            [{{$note->note}}] <br>
                                            @endforeach </span>
                                    </div>
                                </div>
                                @endif
                                @if ($field->sort_order == 18 ||$field->sort_order == 19 || $field->sort_order == 20 || $field->sort_order == 21 )
                                @if ($field->type == 'date')
                                @if($field->name == 'dob')
                                <div class="col-md-6">

                                </div>
                                <div class="col-md-6">
                                     <label for="{{ $field->name }}">{{ $field->label }}</label>
                                    <input type="text" name="{{ $field->name }}" id="{{ $field->name }}"
                                        class="form-control" data-field-id="{{ $field->id}}"
                                        data-dependent-id="{{ $field->id}}" value="{{ $userValue }}" disabled>
                                </div>

                                @endif
                                @elseif($field->type == 'number')
                                <div class="col-md-2">
                                    <label for="{{ $field->name }}">{{ $field->label }}</label>
                                    <input type="text" name="{{ $field->name }}" id="{{ $field->name }}"
                                        class="form-control" value="{{ $userValue }}" disabled>
                              
                                </div>
                                @endif
                                @endif
                                @if ($field->sort_order == 22)
                                <div class="col-md-12">
                                    @if($field->type == 'checkbox')
                                    <div class="form-check">
                                        <input type="checkbox" name="{{ $field->name }}" id="{{ $field->name }}"
                                            class="form-check-input" @if ($userValue) checked @endif disabled>
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


<!-- Add this script section to the bottom of your HTML file -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>

document.addEventListener('DOMContentLoaded', (event) => {
    const dateInput = document.getElementById('dob');
    const currentYear = new Date().getFullYear();
    const minYear = currentYear - 40;
    const maxYear = currentYear - 18;
    dateInput.setAttribute('min', `${minYear}-01-01`);
    dateInput.setAttribute('max', `${maxYear}-01-31`);
});
</script>




@endsection