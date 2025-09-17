<style>
label {
    font-weight: bold;
}
</style>

@extends('admin.layouts.app')

@section('content')
<div class="container-fluid p-4">
    <div class="card shadow">

        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Add Marks</h4>

            <div class="rightside align-items-center p-2">
                <a href="{{ route('marks.byClass') }}" class="btn btn-secondary">View Marks By Class</a>
                <a href="{{ asset('admin/templates/marks-template.xlsx') }}" class="btn btn-info mb-2">
                    Download Excel Template
                </a>
            </div>

        </div>

        <div class="card-body">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
 
            @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('marks.store') }}">
                @csrf

                <div class="form-group">
                    <label for="term">Select Term</label>
                    <select name="term" id="term" class="form-select">
                        <option value="">-- Select Term --</option>
                        <option value="Term 1">Term 1</option>
                        <option value="Term 2">Term 2</option>
                        <option value="Annual Term">Annual Term</option>
                    </select>
                </div>

                <div class="row">
                    <!-- <div class="form-group col-md-6">
                        <label>Class</label>
                        <select name="class_id" id="class_id" class="form-control">
                            <option value="">Select Class</option>
                            @foreach($classes as $class)
                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                        @error('class_id')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div> -->

                    <div class="form-group col-md-6">
                        <label for="class_id">Class</label>
                        <select name="class_id" id="class_id" class="form-control" required>
                            <option value="">-- Select Class --</option>
                            @foreach($classes as $class)
                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                        @error('class_id')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="section_id">Section</label>
                        <select name="section_id" id="section_id" class="form-select">
                            <option value="">-- Select Section --</option>
                            <!-- Filled via AJAX -->
                        </select>
                        @error('section_id')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                </div>

                <div class="row">
                <div class="form-group col-md-6">
                        <label for="student_id">Student</label>
                        <select name="student_id" id="student_id" class="form-control">
                            <option value="">Select Student</option>
                            <!-- Filled via AJAX -->
                        </select>
                        @error('student_id')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label>Roll No</label>
                        <input type="text" name="roll_no" id="roll_no" class="form-control" readonly>
                        @error('roll_no')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="exam_id">Exam</label>
                        <select name="exam_id" id="exam_id" class="form-control">
                            <option value="">-- Select Exam --</option>
                            <!-- Filled via AJAX -->
                        </select>
                        @error('exam_id')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label>Marks Obtained</label> 
                        <input type="number" name="marks_obtained" class="form-control" min="0" max="100">
                        @error('marks_obtained')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Grade</label>
                        <input type="text" name="grade" id="grade_name" class="form-control" readonly>
                        @error('grade')
                        <span>{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label>Description</label>
                        <input type="text" name="description" id="description" class="form-control" readonly>
                        @error('description')
                        <span>{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary mt-4">Save</button>
                </div>
            </form>

            @if (session('rowErrors'))
            <div class="alert alert-warning">
                <strong>Some rows were skipped:</strong>
                <ul>
                    @foreach (session('rowErrors') as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('marks.import') }}" method="POST" enctype="multipart/form-data" class="my-4">
                @csrf
                <div class="form-group">
                    <label for="file">Upload Excel File (.xlsx)</label>
                    <input type="file" name="file" class="form-control" required>
                    @error('file') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <button type="submit" class="btn btn-success mt-2">Import Marks</button>
            </form>

        </div>
    </div>
</div>
@endsection


<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Marks create page loaded');
    
    const classSelect = document.getElementById('class_id');
    const sectionSelect = document.getElementById('section_id');
    const studentSelect = document.getElementById('student_id');
    const examSelect = document.getElementById('exam_id');
    const termSelect = document.getElementById('term');
    
    // Check if all elements are found
    if (!classSelect || !sectionSelect || !studentSelect || !examSelect || !termSelect) {
        console.error('Some form elements not found:', {
            classSelect: !!classSelect,
            sectionSelect: !!sectionSelect,
            studentSelect: !!studentSelect,
            examSelect: !!examSelect,
            termSelect: !!termSelect
        });
        return;
    }

    classSelect.addEventListener('change', function() {
        const classId = this.value;
        console.log('Class changed to:', classId);
        
        if (!classId) {
            sectionSelect.innerHTML = '<option value="">-- Select Section --</option>';
            studentSelect.innerHTML = '<option value="">-- Select Student --</option>';
            examSelect.innerHTML = '<option value="">-- Select Exam --</option>';
            return;
        }
        
        sectionSelect.innerHTML = '<option value="">-- Loading Sections --</option>';
        studentSelect.innerHTML = '<option value="">-- Select Student --</option>';
        examSelect.innerHTML = '<option value="">-- Select Exam --</option>';
        
        const url = `/admin/get-sections-by-class/${classId}`;
        console.log('Fetching sections from:', url);
        
        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Sections loaded:', data);
                sectionSelect.innerHTML = '<option value="">-- Select Section --</option>';
                data.forEach(section => {
                    sectionSelect.innerHTML += `<option value="${section.id}">${section.name}</option>`;
                });
            })
            .catch(error => {
                console.error('Error loading sections:', error);
                sectionSelect.innerHTML = '<option value="">-- Error Loading Sections --</option>';
            });
    });

    function fetchStudents(sectionId) {
        console.log('Fetching students for section:', sectionId);
        
        if (!sectionId) {
            studentSelect.innerHTML = '<option value="">-- Select Student --</option>';
            return;
        }
        
        studentSelect.innerHTML = '<option value="">-- Loading Students --</option>';
        const url = `/admin/get-students-by-section/${sectionId}`;
        console.log('Fetching students from:', url);
        
        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Students loaded:', data);
                studentSelect.innerHTML = '<option value="">-- Select Student --</option>';
                data.forEach(student => {
                    studentSelect.innerHTML += `<option value="${student.id}" data-roll="${student.roll_no}">${student.first_name} ${student.last_name ?? ''} (Roll No: ${student.roll_no})</option>`;
                });
            })
            .catch(error => {
                console.error('Error loading students:', error);
                studentSelect.innerHTML = '<option value="">-- Error Loading Students --</option>';
            });
    }

    function fetchExams(sectionId, term) {
        console.log('Fetching exams for section:', sectionId, 'term:', term);
        
        if (!sectionId || !term) {
            examSelect.innerHTML = '<option value="">-- Select Exam --</option>';
            return;
        }
        
        examSelect.innerHTML = '<option value="">-- Loading Exams --</option>';
        const url = `/admin/get-exams-by-section-term/${sectionId}?term=${encodeURIComponent(term)}`;
        console.log('Fetching exams from:', url);
        
        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Exams loaded:', data);
                examSelect.innerHTML = '<option value="">-- Select Exam --</option>';
                data.forEach(exam => {
                    examSelect.innerHTML += `<option value="${exam.id}">${exam.exam_name}</option>`;
                });
            })
            .catch(error => {
                console.error('Error loading exams:', error);
                examSelect.innerHTML = '<option value="">-- Error Loading Exams --</option>';
            });
    }

    sectionSelect.addEventListener('change', function() {
        const sectionId = this.value;
        const term = termSelect.value;
        console.log('Section changed to:', sectionId, 'Term:', term);
        
        if (sectionId) {
            fetchStudents(sectionId);
            if (term) {
                fetchExams(sectionId, term);
            } else {
                examSelect.innerHTML = '<option value="">-- Select Term First --</option>';
            }
        } else {
            studentSelect.innerHTML = '<option value="">-- Select Student --</option>';
            examSelect.innerHTML = '<option value="">-- Select Exam --</option>';
        }
    });

    termSelect.addEventListener('change', function () {
        const sectionId = sectionSelect.value;
        const term = this.value;
        console.log('Term changed to:', term, 'Section:', sectionId);
        
        if (sectionId && term) {
            fetchExams(sectionId, term);
        } else if (sectionId && !term) {
            examSelect.innerHTML = '<option value="">-- Select Term First --</option>';
        } else if (!sectionId) {
            examSelect.innerHTML = '<option value="">-- Select Section First --</option>';
        }
    });

    studentSelect.addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        const rollNo = selectedOption.getAttribute('data-roll') || '';
        document.getElementById('roll_no').value = rollNo;
    });
});
</script>

<!-- for grade and description -->
<script>
const grades = @json($grades);

document.addEventListener('DOMContentLoaded', function() {
    const marksInput = document.querySelector('input[name="marks_obtained"]');
    const gradeInput = document.getElementById('grade_name');
    const descriptionInput = document.getElementById('description');

    marksInput.addEventListener('input', function() {
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
