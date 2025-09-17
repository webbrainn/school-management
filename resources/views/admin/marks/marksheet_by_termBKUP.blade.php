@extends('admin.layouts.app')

@section('content')
<div class="container-fluid p-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="mb-0">
                    <i class="fas fa-graduation-cap me-2"></i>Student Marksheet - {{ $term }}
                </h3>
                <div>
                    <!-- <button onclick="window.print()" class="btn btn-light btn-sm">
                        <i class="fas fa-print me-1"></i>Print
                    </button> -->
                    <a href="{{ route('student.marksheet') }}" class="btn btn-light btn-sm ms-2">
                        <i class="fas fa-arrow-left me-1"></i>Back
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            @if($marks->isEmpty())
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle me-2"></i>No marks found for {{ $term }}.
                </div>
            @else
                <!-- Custom Client Format Marksheet -->
                <div class="marksheet-container">
                    <!-- Front Side -->
                    <div class="marksheet-page mb-4" id="marksheet-front">
                        <!-- <div class="marksheet-background">
                            <img src="{{ asset('uploads/marksheet_front.jpg') }}" alt="Marksheet Front" class="w-100 h-100">
                        </div> -->
                        <div class="marksheet-content">
                            <!-- Student Details Overlay -->
                            <div class="student-details-overlay">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="detail-item">
                                            <label>Student Name:</label>
                                            <span class="value">{{ $student->first_name }} {{ $student->last_name }}</span>
                                        </div>
                                        <div class="detail-item">
                                            <label>Roll Number:</label>
                                            <span class="value">{{ $student->roll_no ?? 'N/A' }}</span>
                                        </div>
                                        <div class="detail-item">
                                            <label>Total Exams:</label>
                                            <span class="value">{{ $exams->count() }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                    <div class="detail-item">
                                            <label>Class:</label>
                                            <span class="value">{{ $student->class->name ?? 'N/A' }}</span>
                                        </div>
                                        <div class="detail-item">
                                            <label>Section:</label>
                                            <span class="value">{{ $student->section->name ?? 'N/A' }}</span>
                                        </div>
                                        <div class="detail-item">
                                            <label>Term:</label>
                                            <span class="value">{{ $term }}</span>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>

                            <!-- Marks Table Overlay -->
                            <div class="marks-table-overlay">
                                <table class="table table-sm marks-table">
                                    <thead>
                                        <tr>
                                            <th>S/No</th>
                                            <th>Exam</th>
                                            <!-- <th>Subject</th> -->
                                            <th>Marks Obtained</th>
                                            <th>Marks Out Of</th>
                                            <th>Percentage</th>
                                            <th>Grade</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($marks as $mark)
                                            @php
                                                $subjectPercentage = $mark->exam->max_marks > 0 ? 
                                                    round(($mark->marks_obtained / $mark->exam->max_marks) * 100, 1) : 0;
                                            @endphp
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $mark->exam->exam_name ?? 'N/A' }}</td>
                                                <!-- <td>{{ $mark->subject->name ?? 'N/A' }}</td> -->
                                                <td>{{ $mark->marks_obtained }}</td>
                                                <td>{{ $mark->exam->max_marks ?? 'N/A' }}</td>
                                                <td>{{ $subjectPercentage }}%</td>
                                                <td>{{ $mark->grade ?? 'N/A' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Summary Overlay -->
                            <div class="summary-overlay">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="summary-item">
                                            <label>Total Marks:</label>
                                            <span class="value">{{ $totalMarks }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="summary-item">
                                            <label>Out Of:</label>
                                            <span class="value">{{ $maxMarks }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="summary-item">
                                            <label>Percentage:</label>
                                            <span class="value">{{ $percentage }}%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Back Side -->
                    <div class="marksheet-page" id="marksheet-back">
                        <!-- <div class="marksheet-background">
                            <img src="{{ asset('uploads/marksheet_back.jpeg') }}" alt="Marksheet Back" class="w-100 h-100">
                        </div> -->
                        <div class="marksheet-content">
                            <!-- Additional Information Overlay -->
                            <div class="additional-info-overlay">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6>Performance Analysis</h6>
                                        @php
                                            $performanceClass = '';
                                            $performanceText = '';
                                            
                                            if ($percentage >= 90) {
                                                $performanceClass = 'text-success';
                                                $performanceText = 'Excellent';
                                            } elseif ($percentage >= 80) {
                                                $performanceClass = 'text-info';
                                                $performanceText = 'Very Good';
                                            } elseif ($percentage >= 70) {
                                                $performanceClass = 'text-warning';
                                                $performanceText = 'Good';
                                            } elseif ($percentage >= 60) {
                                                $performanceClass = 'text-dark';
                                                $performanceText = 'Average';
                                            } else {
                                                $performanceClass = 'text-danger';
                                                $performanceText = 'Needs Improvement';
                                            }
                                        @endphp
                                        <div class="performance-indicator">
                                            <span class="badge {{ $performanceClass }} fs-6">{{ $performanceText }}</span>
                                        </div>
                                        
                                        <div class="progress mt-2" style="height: 20px;">
                                            <div class="progress-bar {{ $performanceClass }}" 
                                                 style="width: {{ min($percentage, 100) }}%;">
                                                {{ number_format($percentage, 1) }}%
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h6>Exams in {{ $term }}</h6>
                                        <div class="exam-list">
                                            @foreach($exams as $exam)
                                                <div class="exam-item">
                                                    <span>{{ $exam->exam_name }}</span>
                                                    @if($marks->where('exam_id', $exam->id)->count() > 0)
                                                        <span class="badge bg-success">Completed</span>
                                                    @else
                                                        <span class="badge bg-warning">Pending</span>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.marksheet-container {
    max-width: 800px;
    margin: 0 auto;
}

.marksheet-page {
    position: relative;
    width: 100%;
    height: 600px;
    margin-bottom: 20px;
    border: 1px solid #ddd;
    border-radius: 8px;
    overflow: hidden;
}

/* .marksheet-background {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1;
} */

/* .marksheet-background img {
    width: 100%;
    height: 100%;
    object-fit: cover;
} */

.marksheet-content {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 2;
    padding: 20px;
    background: rgba(255, 255, 255, 0.9);
}

.student-details-overlay {
    margin-bottom: 20px;
}

.detail-item {
    margin-bottom: 10px;
    display: flex;
    align-items: center;
}

.detail-item label {
    font-weight: bold;
    min-width: 120px;
    margin-right: 10px;
    color: #333;
}

.detail-item .value {
    font-weight: 500;
    color: #2c3e50;
}

.marks-table-overlay {
    margin-bottom: 20px;
}

.marks-table {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 8px;
    overflow: hidden;
}

.marks-table th {
    background: #3498db;
    color: white;
    font-weight: 600;
    text-align: center;
    padding: 8px;
}

.marks-table td {
    padding: 6px 8px;
    text-align: center;
    border-bottom: 1px solid #eee;
}

.summary-overlay {
    background: rgba(52, 152, 219, 0.1);
    padding: 15px;
    border-radius: 8px;
    border: 2px solid #3498db;
}

.summary-item {
    text-align: center;
    margin-bottom: 10px;
}

.summary-item label {
    display: block;
    font-weight: bold;
    color: #2c3e50;
    margin-bottom: 5px;
}

.summary-item .value {
    font-size: 1.2em;
    font-weight: 700;
    color: #3498db;
}

.additional-info-overlay {
    padding: 20px;
    background: rgba(255, 255, 255, 0.95);
    border-radius: 8px;
    height: 100%;
}

.performance-indicator {
    margin: 15px 0;
}

.exam-list {
    margin-top: 15px;
}

.exam-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 8px;
    padding: 5px 0;
    border-bottom: 1px solid #eee;
}

.exam-item:last-child {
    border-bottom: none;
}

/* Print Styles */
@media print {
    .btn, .card-header {
        display: none !important;
    }
    
    .marksheet-page {
        page-break-after: always;
        height: auto;
        min-height: 600px;
    }
    
    .marksheet-content {
        background: rgba(255, 255, 255, 0.95);
    }
    
    .card {
        border: none !important;
        box-shadow: none !important;
    }
}

/* Responsive Design */
@media (max-width: 768px) {
    .marksheet-page {
        height: auto;
        min-height: 500px;
    }
    
    .marksheet-content {
        padding: 15px;
    }
    
    .detail-item {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .detail-item label {
        min-width: auto;
        margin-bottom: 5px;
    }
}
</style>
@endsection 