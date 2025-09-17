@extends('admin.layouts.app')

@section('content')
<div class="container-fluid p-4">

    <div class="card shadow">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="">View Marks by Class</h3>
            <a href="{{ route('marks.create') }}" class="btn btn-info">Add Student Marks</a>
        </div>

        <div class="" style="padding-left:20px; padding-top:20px; font-weight:bold; font-size:20px">

            <form method="GET" action="{{ route('marks.byClass') }}" class="row g-3"
                  style="padding:20px; font-weight:bold; font-size:20px">

                <div class="col-md-3">
                    <label for="class_id">Select Class</label>
                    <select name="class_id" id="class_id" class="form-control">
                        <option value="">-- Choose Class --</option>
                        @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                            {{ $class->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="section_id">Select Section</label>
                <select name="section_id" id="section_id" class="form-control">
                    <option value="">-- Choose Section --</option>
                    @if(isset($sections))
                        @foreach($sections as $section)
                            <option value="{{ $section->id }}" {{ request('section_id') == $section->id ? 'selected' : '' }}>
                                {{ $section->name }}
                            </option>
                        @endforeach
                    @endif
                </select>
                </div>

                <div class="col-md-3">
                    <label for="term">Select Term</label>
                    <select name="term" id="term" class="form-control">
                        <option value="">-- Choose Term --</option>
                        <option value="Term 1" {{ request('term') == 'Term 1' ? 'selected' : '' }}>Term 1</option>
                        <option value="Term 2" {{ request('term') == 'Term 2' ? 'selected' : '' }}>Term 2</option>
                        <option value="Annual Term" {{ request('term') == 'Annual Term' ? 'selected' : '' }}>Annual Term</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="exam_id">Select Exam</label>
                    <select name="exam_id" id="exam_id" class="form-control">
                        <option value="">-- Choose Exam --</option>
                        @if(isset($exams))
                        @foreach($exams as $exam)
                        <option value="{{ $exam->id }}" {{ request('exam_id') == $exam->id ? 'selected' : '' }}>
                            {{ $exam->exam_name }}
                        </option>
                        @endforeach
                        @endif
                    </select>
                </div>

                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">View Marks</button>
                </div>
            </form>

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

            @if($selectedClass)
            <h5 class="mt-4 text-center" style="font-weight:bold">
                Students Marks for Class : {{ $selectedClass->name ?? 'N/A' }} {{ $selectedSection->name ?? 'N/A' }}</h5>

            @if($marks->isEmpty())
            <div class="alert alert-info">No marks found for this exam.</div>
            @else
            <table class="table table-bordered mt-3" id="MarksTable">
                <thead>
                    <tr>
                        <th>S/No</th>
                        <th>Student Name</th>
                        <th>Roll No</th>
                        <th>Exam</th>
                        <!-- <th>Subject</th> -->
                        <th>Marks Obtained</th>
                        <th>Marks Out Of</th>
                        <th>Grade</th>
                        <th>Description</th>
                        <th>Term</th>
                        <!-- <th>Sheet Image</th> -->
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($marks as $mark)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $mark->student->first_name ?? 'N/A' }} {{ $mark->student->last_name ?? '' }}</td>
                        <td>{{ $mark->roll_no }}</td>
                        <td>{{ $mark->exam->exam_name ?? '-' }}</td>
                        <!-- <td>{{ $mark->subject->name ?? '-' }}</td> -->
                        <td>{{ $mark->marks_obtained }}</td>
                        <td>{{ $mark->exam->max_marks ?? 'N/A' }}</td>
                        <td>{{ $mark->grade ?? '-' }}</td>
                        <td>{{ $mark->description ?? 'N/A' }}</td>
                        <td>{{ $mark->term ?? '-' }}</td>
                        <!-- <td>
                        @if($mark->sheet_image)
                            <a href="{{ asset('storage/' . $mark->sheet_image) }}" target="_blank">View</a>
                        @else
                            -
                        @endif
                    </td> -->
                        <td>
                            <a href="{{ route('marks.edit', $mark->id) }}" class="btn btn-outline-warning" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('marks.destroy', $mark->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger" title="Delete"
                                    onclick="return confirm('Are you sure you want to delete this student marks?')">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
            @endif

        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    $('#MarksTable').DataTable({
        dom: 'lBfrtip',
        buttons: ['excelHtml5', 'pdfHtml5', 'print'],
        lengthChange: true,
        pageLength: 10
    });

    $('#class_id').on('change', function () {
        let classId = $(this).val();
        $('#section_id').html('<option value="">-- Choose Section --</option>');
        $('#exam_id').html('<option value="">-- Choose Exam --</option>');

        if (classId) {
            $.get('/admin/get-sections/' + classId, function (data) {
                data.forEach(function (section) {
                    $('#section_id').append(`<option value="${section.id}">${section.name}</option>`);
                });
            });
        }
    });

    // Function to load exams based on section and term
    function loadExams(sectionId, term) {
        if (sectionId && term) {
            $.ajax({
                url: '/admin/get-exams-by-section-term/' + sectionId,
                method: 'GET',
                data: { term: term },
                success: function (data) {
                    $('#exam_id').html('<option value="">-- Choose Exam --</option>');
                    data.forEach(function (exam) {
                        $('#exam_id').append(`<option value="${exam.id}">${exam.exam_name}</option>`);
                    });
                },
                error: function () {
                    alert('Error loading exams.');
                }
            });
        }
    }

    // Event handler for section and term changes
    $('#section_id, #term').on('change', function () {
        const sectionId = $('#section_id').val();
        const term = $('#term').val();
        loadExams(sectionId, term);
    });

    // Event handler for exam change - no need to reload since backend handles filtering
    $('#exam_id').on('change', function() {
        // The exam dropdown will already be properly filtered by the backend
        // No additional action needed
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