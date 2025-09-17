@extends('admin.layouts.app')

@section('content')

<div class="container-fluid p-4">
    <div class="card shadow">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Students List</h5>
            <a href="{{ route('students.create') }}" class="btn btn-primary">Add Student</a>
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

            <!-- Filter Form -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">Filter Students</h6>
                        </div>
                        <div class="card-body">
                            <form method="GET" action="{{ route('students.index') }}" id="filterForm">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="class_id" class="form-label">Class</label>
                                        <select class="form-select" id="class_id" name="class_id">
                                            <option value="">All Classes</option>
                                            @foreach($classes as $class)
                                                <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                                    {{ $class->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="section_id" class="form-label">Section</label>
                                        <select class="form-select" id="section_id" name="section_id" disabled>
                                            <option value="">Please select class first</option>
                                            @foreach($sections as $section)
                                                <option value="{{ $section->id }}" 
                                                        data-class="{{ $section->class_id }}"
                                                        {{ request('section_id') == $section->id ? 'selected' : '' }}>
                                                    {{ $section->name }} ({{ $section->schoolClass->name ?? 'N/A' }})
                                                </option>
                                            @endforeach
                                        </select>
                                        <div id="section-error" class="text-danger mt-1" style="display: none;">
                                            Please select class before section
                                        </div>
                                    </div>
                                    <div class="col-md-4 d-flex align-items-end">
                                        <div class="d-flex gap-2">
                                            <button type="submit" class="btn btn-primary">Filter</button>
                                            <a href="{{ route('students.index') }}" class="btn btn-secondary">Clear</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <table id="studentsTable" class="table table-bordered mt-3 text-center">
                <thead>
                    <tr>
                        <th>S NO</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Class</th>
                        <th>Section</th>
                        <th>Roll No</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                        <td>{{ $student->email }}</td>
                        <td>{{ $student->phone }}</td>
                        <td>{{ $student->class->name }}</td>
                        <td>{{ $student->section->name }}</td>
                        <td>{{ $student->roll_no}}</td>
                        <td>
                            <a href="{{ route('students.edit', $student->id) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('students.destroy', $student->id) }}" method="POST"
                                  style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"
                                        onclick="return confirm('Are you sure you want to delete this student?')">
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
$(document).ready(function () {
    $('#studentsTable').DataTable({
        dom: 'lBfrtip',  // 'l' = length dropdown
        buttons: ['excelHtml5', 'pdfHtml5', 'print'],
        lengthChange: true, // enables the dropdown
        pageLength: 10,     // default selected value
        lengthMenu: [       // values shown in dropdown
            [10, 25, 50, 100, -1], 
            [10, 25, 50, 100, "All"]
        ]
    });

    // Debug: Check if sections are loaded
    console.log('Total sections found:', $('#section_id option').length);
    console.log('Sections with data-class:', $('#section_id option[data-class]').length);
    
    // Store all section options for filtering
    var allSectionOptions = [];
    $('#section_id option[data-class]').each(function() {
        allSectionOptions.push({
            value: $(this).val(),
            text: $(this).text(),
            classId: $(this).data('class')
        });
    });

    console.log('All section options:', allSectionOptions);

    // Handle class change to filter sections
    $('#class_id').change(function() {
        var classId = $(this).val();
        var sectionSelect = $('#section_id');
        var sectionError = $('#section-error');
        
        console.log('Class selected:', classId);
        
        // Reset section dropdown
        sectionSelect.html('<option value="">Please select class first</option>');
        
        if (classId) {
            // Enable section dropdown and show sections for selected class
            sectionSelect.prop('disabled', false);
            sectionError.hide();
            
            var filteredSections = allSectionOptions.filter(function(option) {
                return option.classId == classId;
            });
            
            console.log('Filtered sections:', filteredSections);
            
            // Update the first option text
            sectionSelect.html('<option value="">All Sections</option>');
            
            filteredSections.forEach(function(option) {
                sectionSelect.append('<option value="' + option.value + '">' + option.text + '</option>');
            });
        } else {
            // Disable section dropdown and show error
            sectionSelect.prop('disabled', true);
            sectionSelect.html('<option value="">Please select class first</option>');
            sectionError.show();
        }
    });

    // Handle section change to show error if no class is selected
    $('#section_id').change(function() {
        var classId = $('#class_id').val();
        var sectionError = $('#section-error');
        
        if (!classId) {
            sectionError.show();
            $(this).val(''); // Reset selection
        } else {
            sectionError.hide();
        }
    });

    // Handle form submission to validate class selection
    $('#filterForm').submit(function(e) {
        var classId = $('#class_id').val();
        var sectionId = $('#section_id').val();
        var sectionError = $('#section-error');
        
        if (sectionId && !classId) {
            e.preventDefault();
            sectionError.show();
            return false;
        }
    });

    // Trigger change event on page load if class is selected
    if ($('#class_id').val()) {
        $('#class_id').trigger('change');
    }
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