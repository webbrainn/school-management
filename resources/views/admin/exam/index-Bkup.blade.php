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

/* Lock pagination + entries at bottom visually */
.dataTables_paginate,
.dataTables_info {
    padding-top: 20px !important;
}
</style>

@extends('admin.layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
        <ul class="nav nav-tabs" id="examTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="manage-tab" data-bs-toggle="tab" href="#manage" role="tab">Manage
                    Exam</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="add-tab" data-bs-toggle="tab" href="#add" role="tab">+ Add Exam</a>
            </li>
        </ul>

        <div class="tab-content mt-3">
            <!-- Manage Exam Tab -->
            <div class="tab-pane fade show active" id="manage" role="tabpanel">

                <form method="GET" action="{{ route('exam.index') }}" class="row g-3 mb-3">
                    <div class="col-md-4">
                        <select name="class_id" class="form-select" onchange="this.form.submit()">
                            <option value="">-- Choose Class to Manage Exams --</option>
                            @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                {{ $class->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </form>

                @if($selectedClassId)
                <table class="table table-bordered text-center" id="examsTable">
                    <!-- <h4 class="text-center mb-3">Class: {{ $selectedClassName }}</h4> -->
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Class</th>
                            <th>Subject</th>
                            <th>Term</th>
                            <!-- <th>Passing Marks Thoery</th>
                            <th>Max Marks Thoery</th>
                            <th>Passing Marks Internal</th>
                            <th>Max Marks Internal</th> -->
                            <th>Passing Marks</th>
                            <th>Max Marks</th>
                            <th>Time</th>
                            <th>Date</th>
                            <th>Session</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($exams as $index => $exam)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $exam->class->name ?? '-' }}</td>
                            <td>{{ $exam->subject->name ?? '-' }}</td>
                            <td>{{ $exam->term }}</td>
                            <!-- <td>{{ $exam->pass_marks }}</td>
                            <td>{{ $exam->max_marks }}</td>
                            <td>{{ $exam->internal_pass_marks ?? '-' }}</td>
                            <td>{{ $exam->internal_max_marks ?? '-' }}</td> -->
                            <td>
                                Theory: {{ $exam->pass_marks }}<br>
                                Internal: {{ $exam->internal_pass_marks ?? 'N/A' }}
                            </td>
                            <td>
                                Theory: {{ $exam->max_marks }}<br>
                                Internal: {{ $exam->internal_max_marks ?? 'N/A' }}
                            </td>
                            <td>{{ \Carbon\Carbon::parse($exam->start_time)->format('h:i A') }} -
                                {{ \Carbon\Carbon::parse($exam->end_time)->format('h:i A') }}</td>
                            <!-- <td>{{ $exam->exam_date }}</td> -->
                            <td>{{ \Carbon\Carbon::parse($exam->exam_date)->format('d-m-Y') }}</td>
                            <td>{{ $exam->session ?? '-' }}</td>
                            <td>
                                <a href="{{ route('exam.edit', $exam->id) }}" class="btn btn-sm btn-outline-primary"
                                    title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('exam.destroy', $exam->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Are you sure to delete this exam?')"
                                        class="btn btn-sm btn-outline-danger" title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center">No data available in table</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                @else
                <div class="alert alert-info">
                    Please select a class to manage exams.
                </div>
                @endif

            </div>

            <!-- Add Exam Tab -->
            <div class="tab-pane fade" id="add" role="tabpanel">

                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </ul>
                </div>
                @endif

                <form action="{{ route('exam.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <!-- <div class="col-md-6 mb-3">
                            <label for="name">Exam Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter exam name">
                        </div> -->
                        <div class="col-md-6 mb-3">
                            <label for="term">Select Term</label>
                            <select name="term" class="form-select" required>
                                <option value="Term 1">Term 1</option>
                                <option value="Term 2">Term 2</option>
                                <option value="Annaul Term">Annual Term</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="session">Session</label>
                            <input type="text" name="session" id="session" class="form-control"
                                placeholder="e.g., 2024-2025" required>
                        </div>

                        <!-- <div class="row"> -->
                        <div class="col-md-6 mb-3">
                            <label for="class_id">Select Class</label>
                            <select name="school_classes_id" id="class_id" class="form-select" required>
                                <option value="">-- Select Class --</option>
                                @foreach($classes as $class)
                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- select section -->
                        <div class="col-md-6 mb-3">
                            <label>Select Section</label>
                            <select name="section_id" id="sectionDropdown" class="form-select">
                                <option value="">--Select Section--</option>
                                <!-- Will be populated via AJAX -->
                            </select>
                            @error('section_id') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="subject_id">Select Exam</label>
                            <select name="subjects_id" id="subjects_id" class="form-select" required>
                                <option value="">-- Select Subject --</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="subject_name">Subject Name</label>
                            <input type="text" name="exam_name" id="subject_name" class="form-control" readonly>
                        </div>
                        <!-- </div> -->

                        <div class="col-md-6 mb-3">
                            <label for="pass_marks">Passing Marks</label>
                            <input type="text" name="pass_marks" id="pass_marks" class="form-control"
                                placeholder="e.g., 35" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="max_marks">Max Marks</label>
                            <input type="text" name="max_marks" id="max_marks" class="form-control"
                                placeholder="e.g., 100" required>
                        </div>

                        <!-- n -->
                        <!-- <div class="col-md-6 mb-3">
                            <label for="internal_pass_marks">Passing Marks For Internal</label>
                            <input type="text" name="internal_pass_marks" id="internal_pass_marks" class="form-control"
                                placeholder="e.g., 10">
                        </div> -->

                        <!-- <div class="col-md-6 mb-3">
                            <label for="internal_max_marks">Max Marks For Internal</label>
                            <input type="text" name="internal_max_marks" id="internal_max_marks" class="form-control"
                                placeholder="e.g., 25">
                        </div> -->
                        <!-- n -->

                        <div class="col-md-4 mb-3">
                            <label for="exam_date">Exam Date</label>
                            <input type="date" name="exam_date" class="form-control" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="start_time">Start Time</label>
                            <input type="time" name="start_time" class="form-control" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="end_time">End Time</label>
                            <input type="time" name="end_time" class="form-control" required>
                        </div>

                        <div class="col-12 text-center pt-4">
                            <button type="submit" class="btn btn-success">Add Exam</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#examsTable').DataTable({
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


<!-- Buttons extension -->
<script src="{{ asset('admin/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('admin/js/jszip.min.js') }}"></script>
<script src="{{ asset('admin/js/pdfmake.min.js') }}"></script>
<script src="{{ asset('admin/js/vfs_fonts.js') }}"></script>
<script src="{{ asset('admin/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('admin/js/buttons.print.min.js') }}"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function () {

    // Load sections when a class is selected
    $('#class_id').change(function () {
        let classId = $(this).val();
        $('#sectionDropdown').empty().append('<option value="">Loading...</option>');
        $('#subjects_id').empty().append('<option value="">-- Select Subject --</option>');
        $('#subject_name').val('');

        if (classId) {
            $.ajax({
                url: '/admin/get-sections/' + classId,
                type: 'GET',
                dataType: 'json',
                success: function (sections) {
                    $('#sectionDropdown').empty().append('<option value="">--Select Section--</option>');
                    $.each(sections, function (i, section) {
                        $('#sectionDropdown').append('<option value="' + section.id + '">' + section.name + '</option>');
                    });
                },
                error: function () {
                    alert('Failed to load sections.');
                    $('#sectionDropdown').empty().append('<option value="">--Select Section--</option>');
                }
            });
        } else {
            $('#sectionDropdown').empty().append('<option value="">--Select Section--</option>');
        }
    });

    // Load subjects when a section is selected
    $('#sectionDropdown').change(function () {
        let sectionId = $(this).val();
        $('#subjects_id').empty().append('<option value="">Loading...</option>');
        $('#subject_name').val('');

        if (sectionId) {
            $.ajax({
                url: '/admin/get-subjects-by-section/' + sectionId,
                type: 'GET',
                dataType: 'json',
                success: function (subjects) {
                    $('#subjects_id').empty().append('<option value="">-- Select Subject --</option>');
                    $.each(subjects, function (i, subject) {
                        $('#subjects_id').append('<option value="' + subject.id + '" data-name="' + subject.name + '">' + subject.name + '</option>');
                    });
                },
                error: function () {
                    alert('Failed to load subjects.');
                    $('#subjects_id').empty().append('<option value="">-- Select Subject --</option>');
                }
            });
        } else {
            $('#subjects_id').empty().append('<option value="">-- Select Subject --</option>');
        }
    });

    // Autofill subject name when subject is selected
    $('#subjects_id').change(function () {
        let subjectName = $(this).find('option:selected').data('name') || '';
        $('#subject_name').val(subjectName);
    });

});
</script>


<!-- <script>
document.addEventListener('DOMContentLoaded', function() {
    const classDropdown = document.getElementById('class_id');
    const sectionDropdown = document.getElementById('sectionDropdown');

    classDropdown.addEventListener('change', function() {
        const classId = this.value;
        sectionDropdown.innerHTML = '<option value="">--Select Section--</option>';

        if (classId) {
            fetch(`/admin/get-sections/${classId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        data.forEach(section => {
                            const option = document.createElement('option');
                            option.value = section.id;
                            option.text = section.name;
                            sectionDropdown.appendChild(option);
                        });
                    }
                })
                .catch(error => {
                    console.error('Error fetching sections:', error);
                });
        }
    });
});
</script> -->