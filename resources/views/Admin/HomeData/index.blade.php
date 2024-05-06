@extends('Admin.Layout.header')


@section('content')
<style>
.switch {
    position: relative;
    display: inline-block;
    width: 40px;
    height: 20px;
}

.switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: .4s;
    transition: .4s;
}

.slider:before {
    position: absolute;
    content: "";
    height: 16px;
    width: 16px;
    left: 2px;
    bottom: 2px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
}

input:checked+.slider {
    background-color: #2196F3;
}

input:focus+.slider {
    box-shadow: 0 0 1px #2196F3;
}
input:checked+.slider:before {
    -webkit-transform: translateX(20px);
    -ms-transform: translateX(20px);
    transform: translateX(20px);
}

/* Rounded sliders */
.slider.round {
    border-radius: 34px;
}

.slider.round:before {
    border-radius: 50%;
}
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="mb-3">
                <a href="{{ route('admin.home.data.create') }}" class="btn btn-primary">Add Home Data</a>
            </div>
            <table id="home-data" class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Logo</th>
                        <th>Heading</th>
                        <th>Post</th>
                        <th>Status</th>
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
    var table1 = $('#home-data').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.home.data') }}",
        columns: [{
                data: 'id',
                name: 'id'
            },
            {
                data: 'logo',
                name: 'logo'
            },
            {
                data: 'heading',
                name: 'heading'
            },
            {
                data: 'post',
                name: 'post'
            },
            {
                data: 'status',
                name: 'status',
                render: function(data, type, full, meta) {
                    // Custom toggle switch HTML
                    var toggleHTML = '<label class="switch">';
                    toggleHTML +=
                        '<input type="checkbox" class="show-option-toggle" data-toggle-id="' +
                        full.id + '" ' + (data ? 'checked' : '') + '>';
                    toggleHTML += '<span class="slider round"></span>';
                    toggleHTML += '</label>';
                    return toggleHTML;
                }
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
                    url: '{{ route('admin.home.data.delete') }}',
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

    $('#home-data').on('change', '.show-option-toggle', function() {
      
        var toggleType = $(this).hasClass('show-option-toggle') ? 'show_options' : 'disable_field';
        var toggleId = $(this).data('toggle-id');
        var newValue = $(this).prop('checked') ? 1 : 0;
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        // Send AJAX request to update the toggle value
        $.ajax({
            url: '{{ route('admin.home.data.toggle') }}',

            type: 'POST',
            data: {
                id: toggleId,
                type: toggleType,
                value: newValue
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Toggle value updated successfully.',
                    showConfirmButton: false,
                    timer: 1500
                });
            },
            error: function(xhr, status, error) {
                // Handle error response if needed
            }
        });
    });
  

});

</script>
@endsection