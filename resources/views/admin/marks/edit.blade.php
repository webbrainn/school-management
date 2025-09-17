@extends('admin.layouts.app')

@section('content')
<div class="container-fluid p-4">

    <div class="card shadow">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>Edit Marks</h3>
            <!-- <a href="{{ route('marks.byClass', ['class_id' => $mark->class_id]) }}" class="btn btn-secondary">Back</a> -->
            <a href="{{ route('marks.byClass') }}" class="btn btn-secondary">Back</a>
        </div>

        <div class="card-body">
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> Please fix the following issues:
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('marks.update', $mark->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>Term</label>
                    <select name="term" class="form-select">
                        <option value="Term 1" {{ $mark->term == 'Term 1' ? 'selected' : '' }}>Term 1</option>
                        <option value="Term 2" {{ $mark->term == 'Term 2' ? 'selected' : '' }}>Term 2</option>
                        <option value="Term 3" {{ $mark->term == 'Term 3' ? 'selected' : '' }}>Term 3</option>
                    </select>
                </div>

                <div class="row">
                <div class="form-group col-md-6">
                    <label for="student_id">Student</label>
                    <select name="student_id" class="form-control" required disabled>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}" {{ $student->id == $mark->student_id ? 'selected' : '' }}>
                                {{ $student->first_name }} {{ $student->last_name }}
                            </option>
                        @endforeach
                    </select>
                    <input type="hidden" name="student_id" value="{{ $mark->student_id }}">
                </div>

                <div class="form-group col-md-6">
                    <label for="roll_no">Roll No</label>
                    <input type="text" name="roll_no" id="roll_no" class="form-control" value="{{ old('roll_no', $mark->roll_no) }}" readonly>
                    @error('roll_no') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6">
                    <label for="exam_id">Exam</label>
                    <select name="exam_id" class="form-control" required>
                        @foreach($exams as $exam)
                            <option value="{{ $exam->id }}" {{ $exam->id == $mark->exam_id ? 'selected' : '' }}>
                                {{ $exam->exam_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-6">
                        <label for="marks_obtained">Marks Obtained</label>
                        <input type="number" name="marks_obtained" class="form-control"
                               value="{{ old('marks_obtained', $mark->marks_obtained) }}"
                               min="0" max="100" required>
                        @error('marks_obtained') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                

                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="grade">Grade</label>
                        <input type="text" name="grade" id="grade_name" class="form-control" value="{{ $mark->grade }}" readonly>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="description">Description</label>
                        <input type="text" name="description" id="description" class="form-control" value="{{ $mark->description }}" readonly>
                    </div>
                </div>

                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-primary">Update Marks</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


<script>
const grades = @json($grades); // Send from controller

document.addEventListener('DOMContentLoaded', function() {
    const marksInput = document.querySelector('input[name="marks_obtained"]');
    const gradeInput = document.getElementById('grade_name');
    const descriptionInput = document.getElementById('description');

    marksInput.addEventListener('input', function () {
        const marks = parseFloat(this.value);
        let grade = '';
        let description = '';

        if (!isNaN(marks)) {
            for (let i = 0; i < grades.length; i++) {
                const from = parseFloat(grades[i].mark_from);
                const to = parseFloat(grades[i].mark_to);
                if (marks >= from && marks <= to) {
                    grade = grades[i].grade_name;
                    description = grades[i].description;
                    break;
                }
            }
        }

        gradeInput.value = grade;
        descriptionInput.value = description;
    });
});
</script>