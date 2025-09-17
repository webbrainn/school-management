@extends('admin.layouts.app')

@section('content')

<div class="container-fluid p-4">
    <div class="card shadow">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Classes List</h4>
            <a href="{{ route('classes.create') }}" class="btn btn-primary">Add Class</a>
        </div>

        <div class="card-body">

            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif


            @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <table id="classesTable" class="table table-bordered mt-3 text-center">
                <thead>
                    <tr>
                        <th>S/No</th>
                        <th>Name</th>
                        <!-- <th>Capacity</th> -->
                        <!-- <th>Class Teacher</th> -->
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($classes as $class)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $class->name }}</td>
                        <!-- <td>{{ $class->capacity }}</td> -->
                        <!-- <td>
                            {{ optional($class->teacher)->name ?? 'N/A' }}
                            {{ $class->teacher && $class->teacher->subject ? ' (' . $class->teacher->subject . ')' : '' }}
                        </td> -->
                        <td>
                            <a href="{{ route('classes.edit', $class->id) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('classes.destroy', $class->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"
                                    onclick="return confirm('Are you sure you want to delete this class?')">
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

<script>
$(document).ready(function() {
    $('#classesTable').DataTable({
        dom: 'lBfrtip', // 'l' = length dropdown
        buttons: ['excelHtml5', 'pdfHtml5', 'print'],
        lengthChange: true,
        pageLength: 10,
        lengthMenu: [
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