@extends('admin.layouts.app')

@section('content')
<div class="container-fluid p-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="mb-0">
                    <i class="fas fa-graduation-cap me-2"></i>Student Marksheet
                </h3>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-light btn-sm">
                    <i class="fas fa-arrow-left me-1"></i>Back to Dashboard
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
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title text-center mb-4">
                                <i class="fas fa-search me-2"></i>Select Student and Exam for Marksheet
                            </h5>

                            <form id="marksheetForm" method="GET">
                                <div class="row">
                                    <!-- Class Selection -->
                                    <div class="col-md-6 mb-3">
                                        <label for="class_id" class="form-label fw-bold">
                                            <i class="fas fa-school me-1"></i>Select Class
                                        </label>
                                        <select name="class_id" id="class_id" class="form-select" required>
                                            <option value="">-- Choose Class --</option>
                                            @foreach($classes as $class)
                                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Section Selection -->
                                    <div class="col-md-6 mb-3">
                                        <label for="section_id" class="form-label fw-bold">
                                            <i class="fas fa-layer-group me-1"></i>Select Section
                                        </label>
                                        <select name="section_id" id="section_id" class="form-select" required>
                                            <option value="">-- Choose Section --</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Student Selection -->
                                    <div class="col-md-6 mb-3">
                                        <label for="student_id" class="form-label fw-bold">
                                            <i class="fas fa-user-graduate me-1"></i>Select Student
                                        </label>
                                        <select name="student_id" id="student_id" class="form-select" required>
                                            <option value="">-- Choose Student --</option>
                                        </select>
                                    </div>

                                    <!-- Term Selection -->
                                    <div class="col-md-6 mb-3">
                                        <label for="term" class="form-label fw-bold">
                                            <i class="fas fa-calendar me-1"></i>Select Term
                                        </label>
                                        <select name="term" id="term" class="form-select" required>
                                            <option value="">-- Choose Term --</option>
                                            <option value="Term 1">Term 1</option>
                                            <option value="Term 2">Term 2</option>
                                            <option value="Annual Term">Annual Term</option>
                                            <option value="All">All Terms</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Note about Term-based Selection -->
                                    <!-- <div class="col-md-12 mb-3">
                                        <div class="alert alert-info">
                                            <i class="fas fa-info-circle me-2"></i>
                                            <strong>Note:</strong> The marksheet will show all exams for the selected term. No need to select a specific exam.
                                        </div>
                                    </div> -->
                                </div>

                                <div class="text-center mt-4">
                                    <button type="submit" class="btn btn-primary btn-lg px-5" id="generateMarksheet">
                                        <i class="fas fa-file-pdf me-2"></i>Generate Marksheet
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Instructions -->
                    <div class="card border-0 bg-light mt-4">
                        <div class="card-body">
                            <h6 class="card-title text-primary">
                                <i class="fas fa-info-circle me-2"></i>Instructions
                            </h6>
                            <ul class="mb-0">
                                <li>Select the class and section to load available students</li>
                                <li>Choose a student from the dropdown</li>
                                <li>Select the term for which you want to generate the marksheet</li>
                                <li>Click "Generate Marksheet" to view all exams for the selected term</li>
                                <!-- <li>The marksheet will show both front and back sides with your custom format</li> -->
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const classSelect = document.getElementById('class_id');
    const sectionSelect = document.getElementById('section_id');
    const studentSelect = document.getElementById('student_id');
    const termSelect = document.getElementById('term');
    const form = document.getElementById('marksheetForm');

    // Class change event
    classSelect.addEventListener('change', function() {
        const classId = this.value;
        
        // Reset dependent dropdowns
        sectionSelect.innerHTML = '<option value="">-- Choose Section --</option>';
        studentSelect.innerHTML = '<option value="">-- Choose Student --</option>';

        if (classId) {
            // Load sections for the selected class
            fetch(`/admin/get-sections-by-class/${classId}`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(section => {
                        sectionSelect.innerHTML += `<option value="${section.id}">${section.name}</option>`;
                    });
                })
                .catch(error => {
                    console.error('Error loading sections:', error);
                });
        }
    });

    // Section change event
    sectionSelect.addEventListener('change', function() {
       const sectionId = this.value;
        
        // Reset dependent dropdowns
        studentSelect.innerHTML = '<option value="">-- Choose Student --</option>';

        if (sectionId) {
            // Load students for the selected section
            fetch(`/admin/get-students-by-section/${sectionId}`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(student => {
                        studentSelect.innerHTML += `<option value="${student.id}">${student.first_name} ${student.last_name} (Roll: ${student.roll_no})</option>`;
                    });
                })
                .catch(error => {
                    console.error('Error loading students:', error);
                });
        }
    });

    // Term change event - no need to load exams since we'll show all exams for the term
    termSelect.addEventListener('change', function() {
        // Just validate that term is selected
        console.log('Term selected:', this.value);
    });

    // Form submission
    form.addEventListener('submit', function(e) {
    e.preventDefault();
    console.log("Form submitted");

    const studentId = studentSelect.value;
    const term = termSelect.value;

    if (studentId && term) {
        if (term === 'All') {
            // Redirect to full year marksheet route
            console.log('Redirecting to full year marksheet:', studentId);
            window.location.href = `/admin/marksheet/${studentId}`;
        } else { 
            // Redirect to term-specific marksheet
            window.location.href = `/admin/marksheet/${studentId}/term/${encodeURIComponent(term)}`;
        }
    } else {
        alert('Please select both student and term to generate marksheet.');
    }
});

});
</script> 
@endsection 

