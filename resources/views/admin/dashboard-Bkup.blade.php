@extends('admin.layouts.app')

@section('content')

<style>
.bg-custom-students {
    background-color:rgba(231, 183, 79, 1);
    color: white;
}
.bg-custom-teachers {
    background-color:rgba(110, 207, 113, 1);
    color: white;
}
.bg-custom-classes {
    background-color:rgba(100, 229, 247, 1);
    color: white;
}
.bg-custom-sections {
    background-color:rgba(82, 133, 245, 1);
    color: white;
}
.bg-custom-subjects {
    background-color:rgba(219, 150, 252, 1);
    color: white;
}
.bg-custom-fees {
    background-color:rgba(248, 116, 116, 1);
    color: white;
}
.fa-solid{
    font-size: 20px !important;
}

    #calendar {
        max-width: 100%;
        margin: 50px;
        padding: 20px;
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
</style>

<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>

    <div class="container-fluid px-4">
	
    <div class="row">
        
        <div class="col-md-3 col-sm-12 mb-4">
            <a href="{{ route('students.index') }}" style="text-decoration: none;">
                <div class="card bg-custom-students">
                    <div class="card-body">
                        <div>
                            <b>Total Students 
                                <span class="icons"><i class="fa-solid fa-users"></i></span> 
                            </b>
                            <h2>{{ $totalStudents }}</h2>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3 col-sm-12 mb-4">
            <a href="{{ route('admin.teachers.index') }}" style="text-decoration: none;">
                <div class="card bg-custom-teachers">
                    <div class="card-body">
                        <b>Total Teachers</b>
                        <span><i class="fa-solid fa-chalkboard-teacher"></i></span> 
                        <h2>{{ $totalTeachers }}</h2>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3 col-sm-12 mb-4">
            <a href="{{ route('classes.index') }}" style="text-decoration: none;">
                <div class="card bg-custom-classes">
                    <div class="card-body">
                        <b>Total Classes
                            <span><i class="fa-solid fa-school"></i></span> 
                        </b>
                        <h2>{{ $totalClasses }}</h2>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3 col-sm-12 mb-4">
            <a href="{{ route('classes.index') }}" style="text-decoration: none;">
                <div class="card bg-custom-sections">
                    <div class="card-body">
                        <b>Sections
                            <span><i class="fa-solid fa-layer-group"></i></span> 
                        </b>
                        <h2>{{ $totalClasses }}</h2>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3 col-sm-12 mb-4">
            <a href="{{ route('classes.index') }}" style="text-decoration: none;">
                <div class="card bg-custom-subjects">
                    <div class="card-body">
                        <b>Subjects
                            <span><i class="fas fa-book-open"></i></span>
                        </b>
                        <h2>{{ $totalClasses }}</h2>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3 col-sm-12 mb-4">
            <a href="{{ route('classes.index') }}" style="text-decoration: none;">
                <div class="card bg-custom-fees">
                    <div class="card-body">
                        <b>Fee Management
                            <span><i class="fa-solid fa-money-bill-wave"></i></span>
                        </b>
                        <h2>{{ $totalClasses }}</h2>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3 col-sm-12 mb-4">
            <a href="{{ route('classes.index') }}" style="text-decoration: none;">
                <div class="card bg-custom-fees">
                    <div class="card-body">
                        <b>Grades
                            <span><i class="fas fa-award"></i></span>
                        </b>
                        <h2>{{ $totalClasses }}</h2>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3 col-sm-12 mb-4">
            <a href="{{ route('classes.index') }}" style="text-decoration: none;">
                <div class="card bg-custom-fees">
                    <div class="card-body">
                        <b>Exam List
                            <span><i class="fa-solid fa-clipboard-list"></i></span>
                        </b>
                        <h2>{{ $totalClasses }}</h2>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3 col-sm-12 mb-4">
            <a href="{{ route('classes.index') }}" style="text-decoration: none;">
                <div class="card bg-custom-fees">
                    <div class="card-body">
                        <b>Add Marks
                            <span><i class="fa-solid fa-pencil-alt"></i></span>
                        </b>
                        <h2>{{ $totalClasses }}</h2>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3 col-sm-12 mb-4">
            <a href="{{ route('classes.index') }}" style="text-decoration: none;">
                <div class="card bg-custom-fees">
                    <div class="card-body">
                        <b>Marks By Class
                            <span><i class="fa-solid fa-table-columns"></i></span>
                        </b>
                        <h2>{{ $totalClasses }}</h2>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3 col-sm-12 mb-4">
            <a href="{{ route('classes.index') }}" style="text-decoration: none;">
                <div class="card bg-custom-fees">
                    <div class="card-body">
                        <b>Marks By Student
                            <span><i class="fa-solid fa-user-graduate"></i></span> 
                        </b>
                        <h2>{{ $totalClasses }}</h2>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3 col-sm-12 mb-4">
            <a href="{{ route('classes.index') }}" style="text-decoration: none;">
                <div class="card bg-custom-fees">
                    <div class="card-body">
                        <b>Student Marksheet
                            <span><i class="fa-solid fa-file-lines"></i></span> 
                        </b>
                        <h2>{{ $totalClasses }}</h2>
                    </div>
                </div>
            </a>
        </div>

    </div>
	
</div>
</div>

<div id='calendar'></div>

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