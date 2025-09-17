<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">

                <!-- <div class="sb-sidenav-menu-heading">Core</div> -->
                @php
                $dashboardRoute = auth()->user()->hasRole('admin') ? 'admin.dashboard' :
                (auth()->user()->hasRole('teacher') ? 'teacher.dashboard' :
                (auth()->user()->hasRole('student') ? 'student.dashboard' : 'dashboard'));
                @endphp
                <a class="nav-link" href="{{ route($dashboardRoute) }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>

                <!-- Admissions -->
                <a class="nav-link" href="{{ route('admission.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-file-alt"></i></div>
                    Admissions
                </a>

                <!-- Teachers -->
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseTeachers"
                    aria-expanded="false" aria-controls="collapseTeachers">
                    <div class="sb-nav-link-icon"><i class="fas fa-list"></i></div>
                    Teachers
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseTeachers" aria-labelledby="headingOne"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{ route('admin.teachers.index') }}">All Teachers</a>
                        <a class="nav-link" href="#">Add Teachers</a>
                    </nav>
                </div>

                <!-- Students -->
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseStudents"
                    aria-expanded="false" aria-controls="collapseStudents">
                    <div class="sb-nav-link-icon"><i class="fas fa-list-alt"></i></div>
                    Students
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseStudents" aria-labelledby="headingSubCat"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{ route('students.index') }}">All Students</a>
                        <a class="nav-link" href="{{ route('students.create') }}">Add Students</a>
                    </nav>
                </div>
                <!-- Students -->

                <!-- Classes -->
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseClasses"
                    aria-expanded="false" aria-controls="collapseClasses">
                    <div class="sb-nav-link-icon"><i class="fas fa-list-alt"></i></div>
                    Classes
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseClasses" aria-labelledby="headingClasses"
                     data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{ route('classes.index') }}">All Classes</a>
                        <a class="nav-link" href="{{ route('classes.create') }}">Add Classes</a>
                    </nav>
                </div>
                <!-- Classes -->

                <!-- Section -->
                <a class="nav-link" href="{{ route('section.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-layer-group"></i></div>
                    Sections
                </a>

                <!-- Subject -->
                <a class="nav-link" href="{{ route('subject.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-book"></i></div>
                    Subjects
                </a>

                <!-- Fee -->
                <a class="nav-link" href="{{ route('fees.index') }}">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-indian-rupee-sign"></i></div>
                    Fee Management
                </a>

                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseExam"
                    aria-expanded="false" aria-controls="collapseExam">
                    <div class="sb-nav-link-icon"><i class="fas fa-book-reader"></i></div>
                    Exam
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseExam" aria-labelledby="headingExam"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{ route('exam.index') }}">Exam List</a>
                        <a class="nav-link" href="{{ route('grades.index') }}">Grades</a>
                        <a class="nav-link" href="{{ route('marks.create') }}">Add Marks</a>
                        <a class="nav-link" href="{{ route('marks.byClass') }}">View Marks by Class</a>
                        <a class="nav-link" href="{{ route('marks.byStudent') }}">View Marks by Student</a>
                        <!-- <a class="nav-link" href="{{ route('results.student', 2) }}">Student Result</a> -->
                        <a class="nav-link" href="{{ route('student.marksheet') }}">Student Marksheet</a>
                    </nav>
                </div>

                <!-- Exam -->
                <!-- <a class="nav-link" href="{{ route('exam.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-book-reader"></i></div>
                    Exams
                </a> -->
                <!-- Exam -->
                
                <!-- Addons Section -->
                <!-- <div class="sb-sidenav-menu-heading">Addons</div>
                <a class="nav-link" href="charts.html">
                    <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                    Charts
                </a>
                <a class="nav-link" href="tables.html">
                    <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                    Tables
                </a> -->
                <!--  -->

            </div> <!-- closing main nav -->
        </div> <!-- closing sidebar menu -->

    </nav>
</div>