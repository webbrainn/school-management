<style>
    label{
        padding-top:20px;
        font-weight: bold;
        color: #333;
        font-size: 20px;
    }
</style>

@extends('admin.layouts.app')

@section('content')
<div class="container-fluid p-4">

    <div class="card shadow">
    <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="text-center p-2">View Marks by Student</h5>
    <a href="{{ route('marks.create') }}" class="btn btn-info">Add Student Marks</a>
    </div>

        <div class="row mb-3 p-2">
        <div class="col-md-3">
            <label>Select Class:</label>
            <select id="classDropdown" class="form-control">
                <option value="">-- Select Class --</option>
                @foreach($classes as $class)
                <option value="{{ $class->id }}">{{ $class->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <label>Select Section:</label>
            <select id="sectionDropdown" class="form-control">
                <option value="">-- Select Section --</option>
            </select>
        </div>

        <div class="col-md-3">
            <label>Select Student:</label>
            <select id="studentDropdown" class="form-control">
                <option value="">-- Select Student --</option>
            </select>
        </div>

        <div class="col-md-3">
    <label>Select Term:</label>
    <select id="termDropdown" class="form-control">
        <option value="">-- Select Term --</option>
        <option value="Term 1">Term 1</option>
        <option value="Term 2">Term 2</option>
        <option value="Annual Term">Annual Term</option>
    </select>
</div>

        <div class="col-md-3">
            <label>Select Exam:</label>
            <select id="examDropdown" class="form-control">
                <option value="">--Select Exam--</option>
            </select>
        </div>

        <div class="col-md-3 d-flex align-items-end">
            <button id="filterBtn" class="btn btn-primary" type="button">View Marks</button>
        </div>
    </div>

    @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

    <div id="marksSection">
        <!-- Student marks will load here -->
    </div>
    
    </div>

</div>
@endsection

@section('scripts')
<script>
$(document).ready(function () {
    // On Class change → Load Sections
    $('#classDropdown').on('change', function () {
        const classId = $(this).val();
        $('#sectionDropdown').html('<option value="">-- Loading Sections --</option>');
        $('#studentDropdown').html('<option value="">-- Select Student --</option>');
        $('#termDropdown').val('');
        $('#examDropdown').html('<option value="">-- Select Exam --</option>');
        $('#marksSection').html('');

        if (classId) {
            $.get(`/admin/get-sections-by-class/${classId}`, function (data) {
                let options = '<option value="">-- Select Section --</option>';
                data.forEach(section => {
                    options += `<option value="${section.id}">${section.name}</option>`;
                });
                $('#sectionDropdown').html(options);
            });
        } else {
            $('#sectionDropdown').html('<option value="">-- Select Section --</option>');
        }
    });

    // On Section change → Load Students
    $('#sectionDropdown').on('change', function () {
        const sectionId = $(this).val();
        $('#studentDropdown').html('<option value="">-- Loading Students --</option>');
        $('#examDropdown').html('<option value="">-- Select Exam --</option>');
        $('#marksSection').html('');

        if (sectionId) {
            $.get(`/admin/get-students-by-section/${sectionId}`, function (data) {
                let options = '<option value="">-- Select Student --</option>';
                data.forEach(student => {
                    options += `<option value="${student.id}">${student.roll_no ?? ''} ${student.first_name} ${student.last_name ?? ''}</option>`;
                });
                $('#studentDropdown').html(options);
            });
        }
    });

   // On Term change → Load Exams by Section and Term
$('#termDropdown').on('change', function () {
    const term = $(this).val();
    const sectionId = $('#sectionDropdown').val();
    $('#examDropdown').html('<option value="">-- Loading Exams --</option>');

    if (sectionId && term) {
        $.get(`/admin/get-exams-by-section-term/${sectionId}`, { term: term }, function (data) {
            let options = '<option value="">-- All Exam --</option>';
            data.forEach(exam => {
                options += `<option value="${exam.id}">${exam.exam_name}</option>`;
            });
            $('#examDropdown').html(options);
        }).fail(() => {
            $('#examDropdown').html('<option value="">-- Failed to Load --</option>');
        });
    } else {
        $('#examDropdown').html('<option value="">-- All Exam --</option>');
    }
});

    // On Filter Click → Load Marks
    $('#filterBtn').on('click', function () {

    const studentId = $('#studentDropdown').val();
    const examId = $('#examDropdown').val();
    const term = $('#termDropdown').val();
    $('#marksSection').html('');

    if (studentId) {
        $('#marksSection').html('<p>Loading...</p>');

        $.get(`/admin/marks/get-student-marks/${studentId}`, { 
            exam_id: examId,
            term: term
        }, function (response) {
            $('#marksSection').html(response.html);
        }).fail(function () {
            $('#marksSection').html('<div class="alert alert-danger">Failed to load marks.</div>');
        });
    } else {
        $('#marksSection').html('<div class="alert alert-warning">Please select a student.</div>');
    }
});
}); 
</script>

@endsection

