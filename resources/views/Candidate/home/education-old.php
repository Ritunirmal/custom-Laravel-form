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

/* Form container styles */
.form-container {
    max-width: 800px;
    margin: 50px auto;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    padding: 20px;
}

/* Form field styles */
.form-container table {
    width: 100%;
}

.form-container table td {
    padding: 10px;
}

.form-container table th {
    padding: 10px;
    text-align: left;
}

/* Form footer styles */
.form-footer {
    margin-top: 20px;
    text-align: center;
}

.form-footer .btn {
    padding: 10px 20px;
    margin-right: 10px;
    border: none;
    border-radius: 5px;
    background-color: #007bff;
    color: #fff;
    cursor: pointer;
}

.form-footer .btn:last-child {
    background-color: #6c757d;
}

.form-footer .btn:hover {
    background-color: #0056b3;
}

#qualificationTable_length {
    display: none;
}

#qualificationTable_filter {
    display: none;
}

#qualificationTable_info {
    display: none;
}

#qualificationTable_paginate {
    display: none;
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
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="background-color:#db2016">
                    <div class="row">
                        <div class="col-md-3">
                            <h4 style="color:white">Educational Qualifications:</h4>
                        </div>
                        <div class="col-md-9" style="text-align:right">
                            <p style="color:white">In online form all the fields marked with red asterisk (*) are
                                compulsory fields.</p>
                        </div>
                    </div>
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
                        <table id="qualificationTable" class="table">
                            <thead>
                                <tr>
                                    <th>Qualification</th>
                                    <th>Board Name</th>
                                    <th>Year of Passing</th>
                                    <th>Subject</th>
                                    <th>Percentage</th>
                                    <th>Document</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Rows will be added dynamically -->
                            </tbody>
                        </table>
                        <div class="form-footer">
                            <button type="submit" class="btn">Submit</button>
                            <button type="button" class="btn">Back</button>
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
                    window.location.replace('/experience-details');
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
    var table = $('#qualificationTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/get-qualifications', // Route to controller method
        columns: [{
                data: 'name',
                name: 'name',
                render: function(data, type, row) {
                    if (row.input_type === 'text') {
                        return '<input class="form-control" type="text" name="qualification_name[]" value="' +
                            data + '" readonly>';
                    } else if (row.input_type === 'select') {
                        var options = JSON.parse(row
                            .option);
                        var optionsHtml =

                            optionsHtml += '<option>Select ' + data + '</option>';

                        optionsHtml += options.map(function(option) {
                            return '<option value="' + option + '">' + option +
                                '</option>';
                        }).join('');
                        return '<select class="form-control" name="qualification_name[]">' +
                            optionsHtml + '</select>';
                    } else {
                        return data;
                    }
                }
            },
            {
                data: 'board_name',
                name: 'board_name',
                render: function() {
                    return '<input  placeholder="University / Board / Institute" class="form-control" type="text" name="board_name[]">';
                }
            },
            {
                data: 'year_of_passing',
                name: 'year_of_passing',
                render: function() {
                    var currentYear = new Date().getFullYear();
                    var optionsHtml =
                        '<select class="form-control" name="year_of_passing[]"><option value="">Year of Passing</option>';
                    for (var i = currentYear; i >= 1950; i--) {
                        optionsHtml += '<option value="' + i + '">' + i + '</option>';
                    }
                    optionsHtml += '</select>';
                    return optionsHtml;
                }
            },
            {
                data: 'subject',
                name: 'subject',
                render: function() {
                    return '<input placeholder="Subject" class="form-control" type="text" name="subject[]">';
                }
            },
            {
                data: 'percentage',
                name: 'percentage',
                render: function() {
                    return '<input placeholder="% Marks" class="form-control" type="number" name="percentage[]">';
                }
            },
            {
                data: 'document',
                name: 'document',
                render: function(data, type, row) {
                    var qualificationId = row.id; // Get the qualification ID
                    return `
            <div>
                <input class="form-control file-input" type="file" accept=".pdf,.doc,.docx" style="display: none;">
                <input  type="hidden" name="documents[]">
                <a href="#" class="btn-upload-document" data-qualification-id="${qualificationId}">Upload Document</a>
                <span class="uploaded-document" style="margin-left: 10px;"></span>
            </div>
        `;
                }
            }


        ]
    });

    $('#addRow').on('click', function() {
        table.row.add({
            qualification_name: '<input type="text" name="qualification_name[]">'
        }).draw();
    });
});
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#qualificationTable').on('click', '.btn-upload-document', function() {

        var qualificationId = $(this).data('qualification-id');
        $(this).siblings('.file-input').click(); // Trigger the corresponding file input
    });

    $('#qualificationTable').on('change', '.file-input', function() {
        var file = this.files[0];
        var qualificationId = $(this).siblings('.btn-upload-document').data('qualification-id');
        var uploadedDocumentSpan = $(this).siblings('.uploaded-document');
        // Prepare form data to send to the backend
        var formData = new FormData();
        formData.append('file', file);
        formData.append('qualification_id', qualificationId);

        var fileInput = $(this); // Store a reference to the file input

        // Send AJAX request to upload the file
        $.ajax({
            url: '/education-document-upload', // Update the URL with your backend endpoint
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                // Handle success response
                console.log('Document uploaded successfully');
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