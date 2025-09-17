<style>
label {
    font-weight: bold;
}
</style>

@extends('admin.layouts.app')

@section('content')
<div class="container-fluid p-4">
    <div class="card shadow">

        <div class="card-header">
            <h3 class="mb-0">Edit Exam</h3>
        </div>

        <div class="card-body">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <form action="{{ route('exam.update', $exam->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label for="term">Term</label>
                        <select name="term" id="term" class="form-select" required>
                            <option value="Term 1" {{ $exam->term == 'Term 1' ? 'selected' : '' }}>Term 1</option>
                            <option value="Term 2" {{ $exam->term == 'Term 2' ? 'selected' : '' }}>Term 2</option>
                            <option value="Term 3" {{ $exam->term == 'Annual Term' ? 'selected' : '' }}>Annual Term</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="session">Session</label>
                        <input type="text" name="session" id="session" class="form-control" placeholder="e.g. 2024-2025"
                            value="{{ $exam->session }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="class_id">Select Class</label>
                        <select name="school_classes_id" id="class_id" class="form-select" required>
                            <option value="">-- Select Class --</option>
                            @foreach($classes as $class)
                            <option value="{{ $class->id }}"
                                {{ $exam->school_classes_id == $class->id ? 'selected' : '' }}>
                                {{ $class->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- section -->
                    <div class="col-md-6 mb-3">
                        <label for="section_id">Select Section</label>
                        <select name="section_id" id="section_id" class="form-select">
                            <option value="">-- Select Section --</option>
                            @foreach($sections as $section)
                            <option value="{{ $section->id }}"
                                {{ $exam->section_id == $section->id ? 'selected' : '' }}>
                                {{ $section->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="subject_id">Select Exam</label>
                        <select name="subjects_id" id="subjects_id" class="form-select" required>
                            <option value="">-- Select Exam --</option>
                            @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}"
                                {{ $exam->subjects_id == $subject->id ? 'selected' : '' }}>
                                {{ $subject->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="subject_name">Subject Name (auto-filled)</label>
                        <input type="text" name="exam_name" id="subject_name" class="form-control"
                            value="{{ old('exam_name', $exam->exam_name) }}" readonly>
                    </div>


                    <div class="col-md-6 mb-3">
                        <label for="pass_marks">Passing Marks</label>
                        <input type="text" name="pass_marks" id="pass_marks" class="form-control"
                            value="{{ $exam->pass_marks }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="max_marks">Max Marks</label>
                        <input type="text" name="max_marks" id="max_marks" class="form-control"
                            value="{{ $exam->max_marks }}" required>
                    </div>

                    <!-- <div class="col-md-6 mb-3">
                    <label for="internal_pass_marks">Passing Marks For Internal</label>
                    <input type="text" name="internal_pass_marks" id="internal_pass_marks" class="form-control"
                        value="{{ $exam->internal_pass_marks }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="internal_max_marks">Max Marks For Internal</label>
                    <input type="text" name="internal_max_marks" id="internal_max_marks" class="form-control"
                        value="{{ $exam->internal_max_marks }}">
                </div> -->

                    <div class="col-md-4 mb-3">
                        <label for="exam_date">Exam Date</label>
                        <input type="date" name="exam_date" id="exam_date" class="form-control"
                            value="{{ $exam->exam_date }}" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="start_time">Start Time</label>
                        <input type="time" name="start_time" id="start_time" class="form-control"
                            value="{{ $exam->start_time }}" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="end_time">End Time</label>
                        <input type="time" name="end_time" id="end_time" class="form-control"
                            value="{{ $exam->end_time }}" required>
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Update Exam</button>
                        <a href="{{ route('exam.index') }}" class="btn btn-secondary">Back</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- <script>
$(document).ready(function() {
    $('#class_id').change(function() {
        var classId = $(this).val();
        console.log('Selected Class ID:', classId); // Debugging

        if (classId) {
            $.ajax({
                url: '/admin/get-subjects/' + classId,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    console.log('Subjects fetched:', data); // Debugging

                    $('#subjects_id').empty().append(
                        '<option value="">-- Select Subject --</option>');

                    if (Array.isArray(data) && data.length > 0) {
                        $.each(data, function(index, subject) {
                            $('#subjects_id').append('<option value="' + subject
                                .id + '">' + subject.name + '</option>');
                        });
                    } else {
                        $('#subjects_id').append(
                            '<option value="">No subjects found</option>');
                    }
                },
                error: function(xhr) {
                    console.error('AJAX error:', xhr.responseText); // Debugging
                    alert('Failed to fetch subjects.');
                }
            });
        } else {
            $('#subjects_id').empty().append('<option value="">-- Select Subject --</option>');
        }
    });

    // When subject changes, auto-fill the subject name
    $('#subjects_id').change(function() {
        var selectedOption = $(this).find('option:selected');
        var subjectName = selectedOption.data('name') || '';
        console.log('Selected Subject Name:', subjectName);
        $('#subject_name').val(subjectName);
    });

});
</script> -->

<script>
$(document).ready(function() {
    const sectionSelect = $('#section_id');
    const subjectSelect = $('#subjects_id');
    const subjectNameInput = $('#subject_name');

    const selectedSectionId = sectionSelect.val();
    const selectedSubjectId = "{{ old('subjects_id', $exam->subjects_id) }}";

    // Function to fetch subjects by section
    function fetchSubjects(sectionId, selectedId = null) {
        if (!sectionId) return;

        $.ajax({
            url: '/admin/get-subjects-by-section/' + sectionId,
            type: 'GET',
            dataType: 'json',
            success: function(subjects) {
                subjectSelect.empty().append('<option value="">-- Select Subject --</option>');
                subjects.forEach(subject => {
                    const selected = subject.id == selectedId ? 'selected' : '';
                    subjectSelect.append(
                        `<option value="${subject.id}" data-name="${subject.name}" ${selected}>${subject.name}</option>`
                        );
                });

                // Set subject name input
                const selectedOption = subjectSelect.find('option:selected');
                subjectNameInput.val(selectedOption.data('name') || '');
            },
            error: function(xhr) {
                console.error('Error fetching subjects:', xhr.responseText);
            }
        });
    }

    // On section change, refetch subjects
    sectionSelect.change(function() {
        const sectionId = $(this).val();
        fetchSubjects(sectionId);
    });

    // On subject change, auto-fill subject name
    subjectSelect.change(function() {
        const selectedName = $(this).find(':selected').data('name');
        subjectNameInput.val(selectedName || '');
    });

    // Initial fetch on load (for edit pre-fill)
    fetchSubjects(selectedSectionId, selectedSubjectId);
});
</script>