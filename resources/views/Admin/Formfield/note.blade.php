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
                <a href="{{ route('admin.form.field.note.create') }}" class="btn btn-primary">Add Form Field
                    Note</a>
            </div>
            <table id="form-fields-note" class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Field</th>
                        <th>Note</th>
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
    var table1 = $('#form-fields-note').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.form.field.note') }}",
        columns: [{
                data: 'id',
                name: 'id'
            },
            {
                data: 'field',
                name: 'field'
            },
            {
                data: 'note',
                name: 'note'
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
                    url: '{{ route('admin.form.field.note.delete') }}',
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