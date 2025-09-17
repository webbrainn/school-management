<style>
tr {
    white-space: nowrap;
}
/* th {
    padding: 20px !important;
} */
.dataTables_wrapper .dataTables_info,
.dataTables_wrapper .dataTables_paginate,
.dataTables_wrapper .dataTables_length,
.dataTables_wrapper .dataTables_filter {
    white-space: normal !important;
}

.dataTables_wrapper {
    overflow-x: hidden !important;
}

table.dataTable {
    width: 100% !important;
}

/* Optional: Lock pagination + entries at bottom visually */
.dataTables_paginate,
.dataTables_info {
    padding-top: 20px !important;
}

.custom-table{
    padding-bottom:10px !important;
}
</style>

@extends('admin.layouts.app')

@section('content')

<div class="container-fluid p-4">
    <div class="card shadow">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Teacher List</h4>
            <a href="{{ route('admin.teachers.create') }}" class="btn btn-primary">Add Teacher</a>
        </div>

        <div class="card-body">

            {{-- Success & Error Messages --}}
            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            {{-- Display Validation Errors --}}
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- <table class="table table-bordered mt-3 text-center"> -->
            <div class="custom-table">
                <table id="teachersTable" class="table table-bordered table-striped table-hover mt-3 text-center">
                    <thead>
                        <tr>
                            <th>S No.</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Qualification</th>
                            <th>Subject</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($teachers as $teacher)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $teacher->name }}</td>
                            <td>{{ $teacher->email }}</td>
                            <td>{{ $teacher->phone }}</td>
                            <td>{{ $teacher->qualification }}</td>
                            <td>{{ $teacher->subject }}</td>
                            <td>
                                <a href="{{ route('admin.teachers.edit', $teacher->id) }}" class="btn btn-sm btn-outline-warning"
                                    title="Edit"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.teachers.destroy', $teacher->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Are you sure to delete this teacher?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>

<script>
$(document).ready(function() {
    $('#teachersTable').DataTable({
        scrollX: true, // enable horizontal scroll
        dom: 'lBfrtip', // 'l' = length dropdown
        buttons: ['excelHtml5', 'pdfHtml5', 'print'],
        lengthChange: true, // enables the dropdown
        pageLength: 10, // default selected value
        lengthMenu: [ // values shown in dropdown
            [10, 25, 50, 100, -1],
            [10, 25, 50, 100, "All"]
        ]
    });
});
</script>

@endsection

<!-- DataTables CSS -->
<link rel="stylesheet" href="{{ asset('admin/css/jquery.dataTables.min.css') }}">
<link rel="stylesheet" href="{{ asset('admin/css/buttons.dataTables.min.css') }}">

<!-- jQuery -->
<script src="{{ asset('admin/js/jquery-3.5.1.min.js') }}"></script>

<!-- DataTables JS -->
<script src="{{ asset('admin/js/jquery.dataTables.min.js') }}"></script>

<!-- Buttons extension -->
<script src="{{ asset('admin/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('admin/js/jszip.min.js') }}"></script>
<script src="{{ asset('admin/js/pdfmake.min.js') }}"></script>
<script src="{{ asset('admin/js/vfs_fonts.js') }}"></script>
<script src="{{ asset('admin/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('admin/js/buttons.print.min.js') }}"></script>