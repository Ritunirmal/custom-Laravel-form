@extends('Candidate.Layout.header')

@section('content')
<style>
#experienceTableData_length {
    display: none;
}

#experienceTableData_filter {
    display: none;
}

#experienceTableData_info {
    display: none;
}

#experienceTableData_paginate {
    display: none;
}

.btn-success {
    background-color: #28a745;
    /* Green background color */
    color: #fff;
    /* White text color */
    padding: 10px 20px;
    /* Adjust padding as needed */
    border-radius: 10px;
    /* Rounded corners */
}
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="background-color:#db2016">
                    <div class="row">
                        <div class="col-md-3">
                            <h4 style="color:white">Experience Details:</h4>
                        </div>
                        <div class="col-md-9" style="text-align:right">
                            <p style="color:white">In online form all the fields marked with red asterisk (*) are
                                compulsory fields.</p>
                        </div>
                    </div>
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
                        @if (Session::has('success'))
                        <div class="alert alert-success">
                            {{ Session::get('success') }}
                        </div>
                        @endif
                        @if (Session::has('error'))
                        <div class="alert alert-success">
                            {{ Session::get('error') }}
                        </div>
                        @endif
                    <form method="POST" action="{{ url('/experience-submit') }}" id="formthree"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Have you been an employee?</label><br>
                            <label class="radio-inline">
                                <input type="radio" name="employee" value="yes" @if(!is_null($data) && $data->value_stored == 'yes') checked @endif> Yes
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="employee" value="no" @if(!is_null($data) && $data->value_stored == 'no') checked @endif> No
                            </label>
                        </div>

                        <div id="experienceTable" style="display: none;">
                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                data-target="#exampleModal">
                                Add Experience
                            </button>

                            <table id="experienceTableData" class="table">
                                <thead>
                                    <tr>
                                        <th>Name of Organization</th>
                                        <th>Brief Job Description</th>
                                        <th>Joining Date</th>
                                        <th>Leaving Date</th>
                                        <th>Experience Certificate</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="experienceTableBody">
                                    <!-- Experience rows will be dynamically added here -->
                                </tbody>
                            </table>
                            <div class="bg1" id="totalexp">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label for="F104" class="col-form-label">Total Experience</label>
                                        <input type="text" autofocus="" id="totalExperience" name="totalExperience"
                                            placeholder="Total Experience" class="form-control" readonly="">
                                    </div>

                                </div>
                            </div>



                           
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
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="experienceModalLabel">Add Experience</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addExperienceForm" enctype="multipart/form-data">
                    <!-- Add enctype attribute for file upload -->
                    <div id="successMessage" class="alert alert-success" role="alert"></div>
                    <input type="hidden" value="" id="espId" name="expeid" disabled />
                    <div class="form-group">
                        <label for="organization">Name of Organization</label>
                        <input type="text" class="form-control" id="organization" name="organization" required>
                    </div>
                    <div class="form-group">
                        <label for="jobDescription">Brief Job Description</label>
                        <input type="text" class="form-control" id="jobDescription" name="jobDescription" required>
                    </div>
                    <div class="form-group">
                        <label for="joiningDate">Joining Date</label>
                        <input type="date" class="form-control" id="joiningDate" name="joiningDate" required>
                    </div>
                    <div class="form-group">
                        <label for="leavingDate">Leaving Date</label>
                        <input type="date" class="form-control" id="leavingDate" name="leavingDate">
                    </div>
                    <div class="form-group">
                        <label for="certificate">Experience Certificate</label>
                        <input type="file" class="form-control-file" id="certificate" name="certificate"
                            accept=".pdf,.doc,.docx" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>

            </div>

        </div>
    </div>
</div>

@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// JavaScript code (you can include it in a separate .js file)
$(document).ready(function() {
    // Check if the employee checkbox is already checked
    if ($('input[name=employee]:checked').val() === 'yes') {
        // If checked, trigger the function immediately
        toggleExperienceTable();
    }else if($('input[name=employee]:checked').val() === 'no'){
        toggleExperienceTable();
    }
});

// Function to show or hide the experience table based on radio button selection
function toggleExperienceTable() {
    
    var isEmployee = $('input[name=employee]:checked').val() === 'yes';
    var experienceTable = $('#experienceTable'); // Cache the element for performance

    // Check if the element exists before toggling its visibility
    if (experienceTable.length > 0) {
        experienceTable.toggle(isEmployee);
    }

    if (isEmployee) {
        $.ajax({
            url: "{{ route('get.experience.details') }}",
            type: "GET",
            success: function(response) {
                // Check if DataTables is already initialized
                if ($.fn.DataTable.isDataTable('#experienceTableData')) {
                    // If DataTables is already initialized, destroy the existing instance
                    $('#experienceTableData').DataTable().destroy();
                }

                // Initialize DataTables with the fetched data
                var experienceTableData = $('#experienceTableData').DataTable({
                    "processing": true,
                    "serverSide": false, // Since data is already fetched, set serverSide to false
                    "data": response, // Use the response data as the table data
                    "columns": [{
                            "data": "organization"
                        },
                        {
                            "data": "job_description"
                        },
                        {
                            "data": "joining_date"
                        },
                        {
                            "data": "leaving_date"
                        },
                        {
                            "data": "certificate",
                            "render": function(data, type, row) {
                                // If the column data is a URL, render it as a clickable link
                                if (type === 'display' && data) {
                                    return '<a href="' + data +
                                        '" target="_blank">certificate </a>';
                                }
                                return data;
                            }
                        },
                        // Modify the render function for the edit and delete buttons
                        {
                            "data": null,
                            "render": function(data, type, row) {
                                // Render edit and delete buttons for each row
                                if (type === 'display') {
                                    // Include the row id as a data attribute in the buttons
                                    return '<button class="btn btn-primary btn-sm edit-btn" data-row-id="' +
                                        row.id + '">Edit</button>' +
                                        '<button class="btn btn-danger btn-sm delete-btn" data-row-id="' +
                                        row.id + '">Delete</button>';
                                }
                                return data;
                            }
                        }


                    ]
                });


                // Calculate total years and days
                var totalYears = 0;
                var totalDays = 0;
                var totalmonths = 0;
                $.each(response, function(index, item) {
                    totalYears += parseInt(item.years);
                    totalmonths += parseInt(item.months);
                    totalDays += parseInt(item.days);
                });

                // Display total experience in the container
                $('#totalExperience').val(totalYears + ' Years ' + totalmonths + ' Months ' + totalDays +
                    ' Days');

                return experienceTableData;
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }else{
        experienceTable.hide();
    }
    var espId = "";
    $(document).on('click', '.edit-btn', function() {
        isEditing = true; // Set editing flag to true
        espId = $(this).data('row-id');
        var rowId = $(this).data('row-id');
        $.ajax({
            url: '/get-experience-details/' + rowId,
            type: 'GET',
            success: function(response) {
                // Populate the form fields with the data from the response
                $('#organization').val(response.data.organization);
                $('#jobDescription').val(response.data.job_description);
                $('#joiningDate').val(response.data.joining_date);
                $('#leavingDate').val(response.data.leaving_date);
                $('#espId').val(espId).removeAttr("disabled");
                $('#exampleModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                // Handle error
            }
        });
    });
    $('#addExperienceForm').submit(function(e) {
        e.preventDefault(); // Prevent the default form submission
        isEditing = false;
        var formData = new FormData($(this)[0]);
        if (isEditing) {
            formData.append('expeid', espId);
        }
        $.ajax({
            url: '/experience-details-submit',
            type: 'POST',
            data: formData,
            async: false,
            cache: false,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                    'content') // Include CSRF token in headers
            },
            success: function(response) {
                // Handle success response
                console.log(response);
                var experienceTableData =
                    toggleExperienceTable(); // Retrieve the DataTable instance
                if (experienceTableData) {
                    experienceTableData.ajax.reload(); // Reload the DataTable
                }
                // Close the experience model (assuming it's a Bootstrap modal)
                $('#exampleModal').modal('hide');
                $('#addExperienceForm').trigger("reset");
                // Show success message
                $('#successMessage').text("Experience added successfully").show();
            },
            error: function(xhr, status, error) {
                // Handle error
                console.error(xhr.responseText);
            }
        });
    });


}


// Handle edit button click

// Handle edit button click
$('#experienceTableData').on('click', '.edit-btn', function(e) {
    e.preventDefault(); // Prevent the default action (e.g., form submission or link click)

    // Retrieve the row id associated with the clicked edit button
    var rowId = $(this).data('row-id');
    // Handle edit logic here using the row id
    console.log('Edit clicked for row with id:', rowId);
});

// Handle delete button click
$('#experienceTableData').on('click', '.delete-btn', function(e) {
    e.preventDefault(); // Prevent the default action (e.g., form submission or link click)

    // Retrieve the row id associated with the clicked delete button
    var rowId = $(this).data('row-id');

    // Show a confirmation dialog using SweetAlert
    swal.fire({
        title: 'Are you sure?',
        text: 'You are about to delete this item!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            // Perform an AJAX request to delete the item from the server
            $.ajax({
                url: '/get-experience-details-delete/' +
                    rowId, // Adjust the URL to your delete endpoint
                type: 'DELETE', // Use the appropriate HTTP method for deletion
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                        'content') // Include CSRF token in headers
                },
                success: function(response) {
                    // Handle successful deletion
                    console.log('Item deleted:', response);

                    var experienceTableData =
                        toggleExperienceTable(); // Retrieve the DataTable instance
                    if (experienceTableData) {
                        experienceTableData.ajax.reload(); // Reload the DataTable
                    }
                },
                error: function(xhr, status, error) {
                    // Handle error
                    console.error('Error deleting item:', error);
                }
            });
        }
    });
});


// Event listener for radio button change
$('input[name=employee]').change(function() {
    toggleExperienceTable();
});
$(document).ready(function() {
    $('#successMessage').hide(); // Hide the success message initially

});
</script>

@endpush