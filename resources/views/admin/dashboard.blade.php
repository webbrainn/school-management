@extends('admin.layouts.app')

@section('content')
<style>
/* ====== STAT CARDS ====== */
.stat-card {
    border-radius: 12px;
    background: #fff;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    padding: 20px;
    text-align: center;
    transition: transform 0.2s ease;
}
.stat-card:hover {
    transform: translateY(-3px);
}
.stat-icon {
    font-size: 2rem;
    color: #4a6cf7;
    margin-bottom: 10px;
}
.stat-number {
    font-size: 1.8rem;
    font-weight: bold;
    color: #303030;
}
.stat-label {
    color: #666;
    font-size: 0.95rem;
}

/* ====== BOXES ====== */
.card-box {
    background: white;
    border-radius: 12px;
    padding: 15px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    height: 100%;
}
#feeChart {
    height:200px !important;
    text-align: center !important;
    align-items: center !important;
    justify-content: center !important;
}

/* ====== RECENT ACTIVITY ====== */
.activity-item {
    padding: 8px 0;
    border-bottom: 1px solid #eee;
    font-size: 0.9rem;
}
.activity-item:last-child {
    border-bottom: none;
}

/* ====== NOTICE BOARD ====== */
.notice {
    padding: 8px;
    background: #f8f9ff;
    border-radius: 8px;
    margin-bottom: 8px;
    font-size: 0.9rem;
    border-left: 4px solid #4a6cf7;
}
</style>

<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
        <div>
            <h1 class="dashboard-title mb-1">📊 Dashboard</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </div>
        <div class="date-input-wrapper">
            <span class="calendar-icon"><i class="fa-solid fa-calendar-days"></i></span>
            <input type="date" class="form-control date-input" value="{{ date('Y-m-d') }}">
        </div>
    </div>

    <!-- ====== STATS CARDS ====== -->
    <div class="row g-3 mb-4">
        <div class="col-md-3 col-sm-6">
            <a href="{{ route('students.index') }}" class="text-decoration-none">
            <div class="stat-card">
                <i class="fa-solid fa-users stat-icon"></i>
                <div class="stat-number" id="studentsCount">{{ $totalStudents }}</div>
                <div class="stat-label">Total Students</div>
            </div>
             </a>
        </div>

        <div class="col-md-3 col-sm-6">
            <a href="{{ route('students.index') }}" class="text-decoration-none">
            <div class="stat-card">
                <i class="fa-solid fa-chalkboard-teacher stat-icon"></i>
                <div class="stat-number">{{ $totalTeachers }}</div>
                <div class="stat-label">Total Teachers</div>
            </div>
            </a>
        </div>
        
        <div class="col-md-3 col-sm-6">
            <a href="{{ route('students.index') }}" class="text-decoration-none">
            <div class="stat-card">
                <i class="fa-solid fa-school stat-icon"></i>
                <div class="stat-number">{{ $totalClasses }}</div>
                <div class="stat-label">Total Classes</div>
            </div>
            </a>
        </div>

        <div class="col-md-3 col-sm-6">
            <a href="{{ route('students.index') }}" class="text-decoration-none">
            <div class="stat-card">
                <i class="fa-solid fa-layer-group stat-icon"></i>
                <div class="stat-number">{{ $totalSections }}</div>
                <div class="stat-label">Total Sections</div>
            </div>
            </a>
        </div>

    </div>

    <!-- ====== MIDDLE ROW ====== -->
    <div class="row g-3 mb-4">

        <div class="col-md-6">
            <div class="card-box">
                <h5>Fee Collection Status</h5>
                <canvas id="feeChart"></canvas>
            </div>
        </div>

        <div class="col-md-6">

            <div class="card-box">
                <h4>Recent Activities</h4>
            <ul class="list-group">
                @forelse($recentActivities as $activity)
            <li class="list-group-item">
               <small class="text-muted">{{ $activity['date']->format('d M Y') }}</small><br>
            {{ $activity['message'] }}
            </li>
            @empty
            <li class="list-group-item">No recent activity</li>
            @endforelse
            </ul>

            </div>
            
        </div>
        
    </div>

    <!-- ====== BOTTOM ROW ====== -->
    <!-- <div class="row g-3">
        <div class="col-md-6">
            <div class="card-box">
                <h5>Notice Board</h5>
                <div class="notice">🏫 School closed on Aug 15 for Independence Day</div>
                <div class="notice">📢 PTM on Aug 20, 10 AM</div>
                <div class="notice">🎯 Science Fair on Sept 10</div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card-box">
                <h5>Upcoming Events</h5>
                <div id="mini-calendar"></div>
            </div>
        </div>
    </div>
</div> -->

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- <script>
    new Chart(document.getElementById('feeChart'), {
    type: 'bar',
    data: {
        labels: ['Collected', 'Pending'],
        datasets: [{
            data: [70, 30],
            backgroundColor: ['#4CAF50', '#F44336'],
            borderRadius: 10
        }]
    },
    options: {
        indexAxis: 'y',
        plugins: { legend: { display: false } },
        scales: { x: { max: 100, ticks: { callback: v => v + '%' } } }
    }
});
</script> -->

<script>
    const ctx = document.getElementById('feeChart').getContext('2d');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Collected', 'Pending'],
            datasets: [{
                data: [{{ $collectedPercent }}, {{ $pendingPercent }}],
                backgroundColor: ['#4CAF50', '#F44336'],
                borderRadius: 10
            }]
        },
        options: {
            indexAxis: 'y',
            plugins: { 
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let value = context.raw;
                            if (context.dataIndex === 0) {
                                return '₹{{ $totalCollected }} (' + value + '%)';
                            } else {
                                return '₹{{ $totalDue }} (' + value + '%)';
                            }
                        }
                    }
                }
            },
            scales: { 
                x: { max: 100, ticks: { callback: v => v + '%' } } 
            },

            // Add click event
            onClick: function(evt, elements) {
                if (elements.length > 0) {
                    let clickedIndex = elements[0].index;
                    if (clickedIndex === 0 || clickedIndex === 1) {
                        window.location.href = "{{ url('admin/fees') }}";
                    }
                }
            }
        }
    });
</script>

<!-- Mini Calendar (jQuery UI) -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script>
$(function() {
    $("#mini-calendar").datepicker({
        changeMonth: false,
        changeYear: false,
        showOtherMonths: true
    });
});
</script>
@endsection
