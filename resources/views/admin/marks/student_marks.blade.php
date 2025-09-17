<div class="d-flex justify-content-between align-items-center p-4">
    <h4 style="font-weight: bold; color: #333; margin: 0;">
        Marks for Student : {{ $student->first_name }} {{ $student->last_name }}
    </h4>
    <div>
        <a href="{{ route('marks.byStudent') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i>Back to Student List
        </a>
    </div>
</div>

@if ($marks->isEmpty())
    <p class="text-center" style="font-weight:bold; font-size:22px; color:red;">No marks found.</p>
@else
    @php
        $totalObtained = 0;
        $totalOutOf = 0;
    @endphp

    <div class="card-body">
        <table class="table table-bordered" id="studentMarksTable">
            <thead>
                <tr>
                    <th>S/No</th>
                    <th>Term</th>
                    <th>Exam/Subject</th>
                    <th>Marks Obtained</th>
                    <th>Marks Out Of</th>
                    <th>Grade</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($marks as $mark)
                    @php
                        $totalObtained += $mark->marks_obtained;
                        $totalOutOf += optional($mark->exam)->max_marks ?? 0;
                    @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $mark->term }}</td>
                        <td>{{ optional($mark->exam)->exam_name ?? 'N/A' }}</td>
                        <td>{{ $mark->marks_obtained }}</td>
                        <td>{{ optional($mark->exam)->max_marks ?? 'N/A' }}</td>
                        <td>{{ $mark->grade }}</td>
                        <td>{{ $mark->description }}</td>
                        <td>
                            <a href="{{ route('student-marks.edit', $mark->id) }}" class="btn btn-outline-primary btn-sm" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('student-marks.destroy', $mark->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm" title="delete">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Enhanced Marks Summary Section -->
        <div class="mt-5">
            <h4 class="text-center mb-4" style="color: #2c3e50; font-weight: 600; border-bottom: 2px solid #3498db; padding-bottom: 10px;">
                <i class="fas fa-chart-line me-2"></i>Performance Summary
            </h4>
            
            <div class="row justify-content-center">
                <!-- Total Obtained Marks Card -->
                <div class="col-md-4 mb-3">
                    <div class="card h-100 border-0 shadow-sm" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <div class="card-body text-center text-white">
                            <div class="mb-3">
                                <i class="fas fa-trophy fa-2x"></i>
                            </div>
                            <h6 class="card-title mb-2" style="font-weight: 500; opacity: 0.9;">Total Obtained Marks</h6>
                            <h3 class="mb-0" style="font-weight: 700; font-size: 2.2rem;">{{ $totalObtained }}</h3>
                        </div>
                    </div>
                </div>

                <!-- Total Out Of Marks Card -->
                <div class="col-md-4 mb-3">
                    <div class="card h-100 border-0 shadow-sm" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                        <div class="card-body text-center text-white">
                            <div class="mb-3">
                                <i class="fas fa-bullseye fa-2x"></i>
                            </div>
                            <h6 class="card-title mb-2" style="font-weight: 500; opacity: 0.9;">Total Out Of Marks</h6>
                            <h3 class="mb-0" style="font-weight: 700; font-size: 2.2rem;">{{ $totalOutOf }}</h3>
                        </div>
                    </div>
                </div>

                <!-- Percentage Card -->
                <div class="col-md-4 mb-3">
                    <div class="card h-100 border-0 shadow-sm" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                        <div class="card-body text-center text-white">
                            <div class="mb-3">
                                <i class="fas fa-percentage fa-2x"></i>
                            </div>
                            <h6 class="card-title mb-2" style="font-weight: 500; opacity: 0.9;">Percentage</h6>
                            <h3 class="mb-0" style="font-weight: 700; font-size: 2.2rem;">
                                {{ $totalOutOf > 0 ? number_format(($totalObtained / $totalOutOf) * 100, 1) : '0.0' }}%
                            </h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Performance Indicator -->
            <div class="row justify-content-center mt-4">
                <div class="col-md-8">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h6 class="text-center mb-3" style="color: #2c3e50; font-weight: 600;">
                                <i class="fas fa-chart-bar me-2"></i>Performance Analysis
                            </h6>
                            
                            @php
                                $percentage = $totalOutOf > 0 ? ($totalObtained / $totalOutOf) * 100 : 0;
                                $performanceClass = '';
                                $performanceText = '';
                                $progressColor = '';
                                
                                if ($percentage >= 90) {
                                    $performanceClass = 'text-success';
                                    $performanceText = 'Excellent';
                                    $progressColor = 'bg-success';
                                } elseif ($percentage >= 80) {
                                    $performanceClass = 'text-info';
                                    $performanceText = 'Very Good';
                                    $progressColor = 'bg-info';
                                } elseif ($percentage >= 70) {
                                    $performanceClass = 'text-warning';
                                    $performanceText = 'Good';
                                    $progressColor = 'bg-warning';
                                } elseif ($percentage >= 60) {
                                    $performanceClass = 'text-primary';
                                    $performanceText = 'Average';
                                    $progressColor = 'bg-primary';
                                } else {
                                    $performanceClass = 'text-danger';
                                    $performanceText = 'Needs Improvement';
                                    $progressColor = 'bg-danger';
                                }
                            @endphp

                            <div class="text-center mb-3">
                                <span class="badge {{ $performanceClass }} fs-6 px-3 py-2" style="font-weight: 500;">
                                    <i class="fas fa-star me-1"></i>{{ $performanceText }}
                                </span>
                            </div>

                            <div class="progress mb-3" style="height: 25px; border-radius: 15px;">
                                <div class="progress-bar {{ $progressColor }}" 
                                     role="progressbar" 
                                     style="width: {{ min($percentage, 100) }}%; border-radius: 15px; font-weight: 600; font-size: 14px;"
                                     aria-valuenow="{{ $percentage }}" 
                                     aria-valuemin="0" 
                                     aria-valuemax="100">
                                    {{ number_format($percentage, 1) }}%
                                </div>
                            </div>

                            <div class="row text-center">
                                <div class="col-4">
                                    <small class="text-muted">Marks Ratio</small><br>
                                    <strong>{{ $totalObtained }}/{{ $totalOutOf }}</strong>
                                </div>
                                <div class="col-4">
                                    <small class="text-muted">Average per Exam</small><br>
                                    <strong>{{ $marks->count() > 0 ? number_format($totalObtained / $marks->count(), 1) : '0.0' }}</strong>
                                </div>
                                <div class="col-4">
                                    <small class="text-muted">Exams Taken</small><br>
                                    <strong>{{ $marks->count() }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
@endif
