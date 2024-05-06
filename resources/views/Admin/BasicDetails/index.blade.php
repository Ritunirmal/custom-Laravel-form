@extends('Admin.Layout.header')


@section('content')
<div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="mb-3">
                    <a href="{{ route('basic.details.admin.form.field') }}" class="btn btn-primary">Add basic Details Form Field</a>
                </div>
                <table id="basic-details-form-fields-table" class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Label</th>
                            <th>Type</th>
                            <th>Sort Order</th>
                            <!-- <th>Status</th> -->
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
    var table1 = $('#basic-details-form-fields-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.basic.details.form.field.show') }}",
        columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'label',
                    name: 'label'
                },
                {
                    data: 'type',
                    name: 'type'
                },
                {
                    data: 'sort_order',
                    name: 'sort_order'
                },
                
                // Add other columns as needed
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
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