




@extends('admin.layouts.app')

@section('content')

<style>
    .dashboard-title {
    font-weight: 700;
    font-size: 2rem;
    color: #2c3e50;
    position: relative;
}

.dashboard-title::after {
    content: "";
    position: absolute;
    bottom: -6px;
    left: 0;
    width: 50px;
    height: 3px;
    background: linear-gradient(90deg, #4a6cf7, #7a9cff);
    border-radius: 3px;
}
.date-input-wrapper {
    position: relative;
    max-width: 180px;
}

.date-input {
    border-radius: 8px;
    padding: 8px 12px 8px 35px; /* left padding for icon */
    border: 1px solid #ddd;
    box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    transition: all 0.2s ease;
    font-size: 0.9rem;
}

.date-input:focus {
    outline: none;
    border-color: #4a6cf7;
    box-shadow: 0 0 0 3px rgba(74, 108, 247, 0.2);
}

.calendar-icon {
    position: absolute;
    top: 50%;
    left: 10px;
    transform: translateY(-50%);
    color: #4a6cf7;
    font-size: 1rem;
    pointer-events: none;
}
.dashboard-card {
    border: none;
    border-radius: 12px;
    background: #fff;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    padding: 15px;
}
.dashboard-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.12);
}

.dashboard-card .icon {
    font-size: 2rem;
    color: #4a6cf7; /* Primary accent color */
    opacity: 0.85;
}

.dashboard-card h2 {
    font-weight: 700;
    margin: 0;
    font-size: 1.8rem;
    color: #333;
}

.dashboard-card b {
    font-size: 1rem;
    color: #666;
    display: flex;
    align-items: center;
    gap: 8px;
}

.dashboard-card b i {
    font-size: 1.2rem;
}
</style>

<div class="container-fluid px-4">

    <!-- <h1 class="mt-4">Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol> -->

    <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
    <div>
        <h1 class="dashboard-title mb-1">📊 Dashboard</h1>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
    </div>

    <!-- Right side date -->
    <div class="date-input-wrapper">
    <span class="calendar-icon"><i class="fa-solid fa-calendar-days"></i></span>
    <input type="date" class="form-control date-input" value="{{ date('Y-m-d') }}">
    </div>

</div>

    <div class="container-fluid px-4">
	
    <div class="row">

         <div class="col-md-3 col-sm-6 mb-4">
            <a href="{{ route('students.index') }}" class="text-decoration-none">
                <div class="dashboard-card">
                    <b><i class="fa-solid fa-users icon"></i> Total Students</b>
                    <h2>{{ $totalStudents }}</h2>
                </div>
            </a>
        </div>

        <div class="col-md-3 col-sm-6 mb-4">
            <a href="{{ route('admin.teachers.index') }}" class="text-decoration-none">
                <div class="dashboard-card">
                    <b><i class="fa-solid fa-chalkboard-teacher icon"></i>Total Teachers</b>
                    <h2>{{ $totalTeachers }}</h2>
                </div>
            </a>
        </div>

        <div class="col-md-3 col-sm-6 mb-4">
            <a href="{{ route('classes.index') }}" class="text-decoration-none">
                <div class="dashboard-card">
                    <b><i class="fa-solid fa-school icon"></i> Total Classes</b>
                    <h2>{{ $totalClasses }}</h2>
                </div>
            </a>
        </div>

        <div class="col-md-3 col-sm-6 mb-4">
            <a href="{{ route('classes.index') }}" class="text-decoration-none">
                <div class="dashboard-card">
                    <b><i class="fa-solid fa-layer-group icon"></i> Total Sections</b>
                    <h2>{{ $totalSections }}</h2>
                </div>
            </a>
        </div>

        <div class="col-md-3 col-sm-6 mb-4">
            <a href="{{ route('classes.index') }}" class="text-decoration-none">
                <div class="dashboard-card">
                    <b><i class="fas fa-book-open icon"></i> Total Subjects</b>

                    <h2>{{ $totalSubjects }}</h2>
                </div>
            </a>
        </div>
        
        <div class="col-md-3 col-sm-6 mb-4">
            <a href="{{ route('classes.index') }}" class="text-decoration-none">
                <div class="dashboard-card">
                    <b><i class="fa-solid fa-money-bill-wave icon"></i> Total Fee</b>

                    <h2>{{ $totalfees }}</h2>
                </div>
            </a>
        </div>

        <div class="col-md-3 col-sm-6 mb-4">
            <a href="{{ route('classes.index') }}" class="text-decoration-none">
                <div class="dashboard-card">
                    <b><i class="fas fa-award icon"></i> Total Grades</b>
                    <h2>{{ $totalGrades }}</h2>
                </div>
            </a>
        </div>

        <div class="col-md-3 col-sm-6 mb-4">
            <a href="{{ route('classes.index') }}" class="text-decoration-none">
                <div class="dashboard-card">
                    <b><i class="fa-solid fa-clipboard-list icon"></i> Total Exams</b>
                    <h2>{{ $totalExams }}</h2>
                </div>
            </a>
        </div>

        <div class="col-md-3 col-sm-6 mb-4">
            <a href="{{ route('classes.index') }}" class="text-decoration-none">
                <div class="dashboard-card">
                    <b><i class="fa-solid fa-pencil-alt icon"></i> Total Marks</b>
                    <h2>{{ $totalMarks }}</h2>
                </div>
            </a>
        </div>

        <div class="col-md-3 col-sm-6 mb-4">
            <a href="{{ route('classes.index') }}" class="text-decoration-none">
                <div class="dashboard-card">
                    <b><i class="fa-solid fa-table-columns icon"></i> Marks By class</b>
                    <!-- <h2>{{ $totalMarks }}</h2> -->
                </div>
            </a>
        </div>

        <div class="col-md-3 col-sm-6 mb-4">
            <a href="{{ route('classes.index') }}" class="text-decoration-none">
                <div class="dashboard-card">
                    <b><i class="fa-solid fa-user-graduate icon"></i> Marks By Student</b>
                    <!-- <h2>{{ $totalMarks }}</h2> -->
                </div>
            </a>
        </div>

        <div class="col-md-3 col-sm-6 mb-4">
            <a href="{{ route('classes.index') }}" class="text-decoration-none">
                <div class="dashboard-card">
                    <b><i class="fa-solid fa-file-lines icon"></i> Student Marksheet</b>
                    <!-- <h2>{{ $totalMarks }}</h2> -->
                </div>
            </a>
        </div>

    </div>
	
</div>
</div>

<!-- <div id='calendar'></div> -->

@endsection

<!-- FullCalendar CSS -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css" rel="stylesheet" />

<!-- FullCalendar JS -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },

            events: [
                // Sample static events
                // {
                //     title: 'Meeting with Parents',
                //     start: '2025-07-25',
                //     end: '2025-07-25',
                // },
                // {
                //     title: 'Exam - Class 10',
                //     start: '2025-07-27',
                //     end: '2025-07-27',
                // },
            ]
        });

        calendar.render();
    });
</script>