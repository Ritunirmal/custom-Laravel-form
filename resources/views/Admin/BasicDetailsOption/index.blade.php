@extends('Admin.Layout.header')


@section('content')
<div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="mb-3">
                    <a href="{{ route('admin.basic.details.form.field.options.create') }}" class="btn btn-primary">Add Basic Details Form Field Options</a>
                </div>
                <table id="basic-details-form-fields-option-table" class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Field</th>
                            <th>Option</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    
@endsection

@section('scripts')
<!-- SweetAlert CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    var table1 = $('#basic-details-form-fields-option-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.basic.details.form.field.options') }}",
        columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'label',
                    name: 'label',
                    width: '50%' 
                },
                {
                    data: 'option_data',
                    name: 'option_data',
                    width: '50%' 
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    width: '20%' 
                },
            ],

    });
 
    $(document).on('click', '.deleteField', function() {
        var optionId = $(this).data('id');

        // Show Swal confirmation dialog
        Swal.fire({
            title: 'Are you sure?',
            text: 'You will not be able to recover this record!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // User confirmed, send AJAX request to delete the record
                $.ajax({
                    url: '{{ route('admin.basic.details.form.field.delete') }}',
                    type: 'POST',
                    data: { id: optionId, _token: '{{ csrf_token() }}' },
                    success: function(response) {
                        // Handle success response
                        
                        Swal.fire('Deleted!', 'The record has been deleted.', 'success');
                        table1.ajax.reload();
                        // Optionally, refresh the page or update the UI after deletion
                        // window.location.reload();
                    },
                    error: function(xhr, status, error) {
                        // Handle error response
                        Swal.fire('Error!', 'An error occurred while deleting the record.', 'error');
                    }
                });
            }
        });
    });


  

});

</script>
@endsection