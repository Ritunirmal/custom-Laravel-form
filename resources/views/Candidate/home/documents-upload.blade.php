@extends('Candidate.Layout.header')

@section('title', 'Home')

@section('content')
<style>
.btn-upload-document {
    display: inline-block;
    padding: 8px 16px;
    background-color: #336086;
    color: #fff;
    border: none;
    border-radius: 4px;
    text-decoration: none;
    cursor: pointer;
}

.btn-upload-document:hover {
    background-color: #336086;
    /* Darker shade of blue on hover */
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

                <div class="card-header basic mb-2 p-2">Document Upload:</div>
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
                    <form method="POST" action="{{ url('/candidate/documents-upload-success') }}" id="formfour"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            @foreach($UserData as $key => $document)
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="{{$document->document_name}}"
                                            class="col-form-label">{{$document->name}} @if($document->mandatory ==
                                            1)<span class="red">*</span>@endif <span
                                                class="helpLine">{{$document->span}}</span></label>
                                        <input type="file" class="form-control-file file-input btn-upload-document"
                                            data-document-id="{{$document->id}}" name="{{$document->document_name}}"
                                            accept=".jpg, .jpeg, .png, .pdf" @if(($document->mandatory ==
                                            1) && ($document->document == null)) required @endif>
                                        <input type="hidden" name="document_value[]" class="document" value="{{$document->document}}">
                                        <input type="hidden" name="document_id[]" value="{{$document->id}}">
                                        <span class="error-message" style="font-size: smaller;color: red;"></span>
                                        @if($document->document_name == 'photo')
                                        @elseif($document->document_name == 'signature')
                                        @else
                                        <span style="font-size: smaller;color: red;" class="uploaded-document"
                                            id="{{$document->document_name}}Preview">{{$document->document}}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        @if($document->document_name == 'photo')
                                        <img class="uploaded-document" id="{{$document->document_name}}Preview"
                                            src="@if($document->document != null) {{$document->document}} @else https://rmlntp.cbtexamportal.in/assests/images/sampleimage.jpg @endif "
                                            alt="Default Image" style="max-width: 150px; max-height: 150px;">
                                        @elseif($document->document_name == 'signature')
                                        <img class="uploaded-document" id="{{$document->document_name}}Preview"
                                            src="@if($document->document != null) {{$document->document}} @else https://rmlntp.cbtexamportal.in/assests/images/simplesignature.jpg @endif"
                                            alt="Default Signature" style="max-width: 150px; max-height: 150px;">
                                        @else
                                        <!-- <span class="uploaded-document" id="{{$document->document_name}}Preview"></span> -->
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            <div class="row">
    <div class="col-md-12 text-center">
        <button type="submit" class="btn btn-lg btn-success">Save & Continue</button>
    </div>
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
$(document).ready(function() {
    $('.btn-upload-document').click(function() {
        var documentId = $(this).data('document-id');
        $(this).siblings('.file-input').click(); // Trigger the corresponding file input
    });

    $('.file-input').change(function() {
        var file = this.files[0];
        var documentId = $(this).data('document-id');
        var documentName = $(this).attr('name');
        var uploadedDocumentPreview = $('#' + documentName + 'Preview');
        var fileInput = $(this); // Store a reference to the file input
        var errorSpan = $(this).siblings('.error-message');
        var Document = $(this).siblings('.document');
        // Prepare form data to send to the backend
        var formData = new FormData();
        formData.append('file', file);
        formData.append('document_id', documentId);
        formData.append('document_name', documentName);

        // Send AJAX request to upload the file
        $.ajax({
            url: '/candidate/each-document-upload', // Update the URL with your backend endpoint
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
                // fileInput.val('');
                // Display the uploaded document preview
                uploadedDocumentPreview.attr('src', response.fileUrl);
                uploadedDocumentPreview.text(response
                    .fileName);
                fileInput.siblings('.document').val(response.fileUrl);
                errorSpan.text('');
                // Clear the file input to allow re-uploading the same file

            },
            error: function(xhr, status, error) {
                // Handle error response
                console.error('Error uploading document:', error);
                // Display error message to the user (you can customize this)
                // alert('Error uploading document. Please try again.');
                errorSpan.text('Error uploading document. Please try again.');
            }
        });
    });
});
$(document).ready(function() {
    $('#formfour').submit(function(event) {
        // Prevent the default form submission behavior
        event.preventDefault();
        var formData = $(this).serialize();
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                success: function(response) {
                    window.location.replace('/candidate/payment');
                },
                error: function(xhr, status, error) {
                    // Handle error response
                }
            })

    });


});
</script>




@endsection