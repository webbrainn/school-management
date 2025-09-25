<style>
.action {
    display: flex;
    justify-content: center;
    gap: 10px;
    align-items: center;
}

.action form {
    margin: 0;
}

tr {
    white-space: nowrap;
}

.form-section {
    padding: 20px;
    background-color: #f8f9fa;
    border-radius: 10px;
}

.tab-content {
    padding-top: 20px;
}

.table thead {
    background-color: #f1f1f1;
}

.btn {
    border-radius: 8px;
}

.dropdown-menu {
    border-radius: 10px;
    border: 1px solid #ddd;
}
</style>

@extends('admin.layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
        <ul class="nav nav-tabs" id="feeTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="manage-tab" data-bs-toggle="tab" href="#manage" role="tab">Manage Fee</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="collect-tab" data-bs-toggle="tab" href="#collect" role="tab">+ Collect Fee</a>
            </li>
        </ul>

        <div class="tab-content mt-3">
            <!-- Manage Fee Tab -->
            <div class="tab-pane fade show active" id="manage" role="tabpanel">

                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
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

                <form method="GET" action="{{ route('fees.index') }}" class="row g-3 mb-4">

                    <div class="col-md-3">
                        <label for="class_id"><i class="fas fa-school me-1"></i>Class</label>
                        <select name="class_id" id="class_id_manage" class="form-select" required>
                            <option value="">-- Select Class --</option>
                            @foreach($classes as $class)
                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                        @error('class_id')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label for="section_id"><i class="fas fa-layer-group me-1"></i>Section</label>
                        <select name="section_id" id="section_id_manage" class="form-select">
                            <option value="">-- Select Section --</option>
                            <!-- Filled via AJAX -->
                        </select>
                        @error('section_id')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label for="student_id"><i class="fas fa-user-graduate me-1"></i>Student</label>
                        <select name="student_id" id="student_id_manage" class="form-select">
                            <option value="">Select Student</option>
                            <!-- Filled via AJAX -->
                        </select>
                        @error('student_id')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-3 p-4">
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </div>
                </form>

                <!-- show selected student details  -->
                @if(request('student_id') && request('class_id') && request('section_id'))
                @php
                $selectedStudent = $students->where('id', request('student_id'))->first();
                $selectedClass = $classes->where('id', request('class_id'))->first();
                $selectedSection = $sections->where('id', request('section_id'))->first();
                @endphp
                <div class="alert alert-info mb-3">
                    <strong>
                        Fee status for
                        "{{ $selectedStudent ? $selectedStudent->first_name . ' ' . $selectedStudent->last_name : 'Student' }}"
                        from (Class: {{ $selectedClass ? $selectedClass->name : 'N/A' }},
                        Section: {{ $selectedSection ? $selectedSection->name : 'N/A' }})
                    </strong>
                </div>
                @endif
                <!-- show selected student details end -->

                @if(count($selectedFees) > 0)
                <table class="table table-bordered text-center" id="feeTable">
                    <thead>
                        <tr>
                            <th>S no</th>
                            <th>Month</th>
                            <th>Year</th>
                            <th>Fee Amount</th>
                            <th>Amount Paid</th>
                            <th>Amount Due</th>
                            <th>Date Collected</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($selectedFees as $index => $fee)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $fee->month }}</td>
                            <td>{{ $fee->year }}</td>
                            <td>{{ $fee->fee_amount }}</td>
                            <td>{{ $fee->amount_paid }}</td>
                            <td>{{ $fee->amount_due }}</td>
                            <td>{{ $fee->created_at->format('d-m-Y') }}</td>
                            <td class="action">
                                <a href="{{ route('fees.edit', $fee->id) }}" class="btn btn-sm btn-outline-primary"
                                    title="Edit"> <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('fees.destroy', $fee->id) }}" method="POST"
                                      onsubmit="return confirm('Are you sure you want to delete this fee record?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm" title="Delete"> <i
                                            class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Totals Fee Summary -->
                @php
                $totalFeeAmount = $selectedFees->sum('fee_amount');
                $totalPaid = $selectedFees->sum('amount_paid');
                $totalDue = $selectedFees->sum('amount_due');
                @endphp

                <div class="card mt-3 shadow-sm">
                    <div class="card-body text-center">
                        <h5 class="mb-3">💰 Fee Summary</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <span class="fw-bold text-primary">Total Fee Amount:</span>
                                <b>₹{{ $totalFeeAmount }}</b>
                            </div>
                            <div class="col-md-4">
                                <span class="fw-bold text-success">Total Paid:</span> <b>₹{{ $totalPaid }}</b>
                            </div>
                            <div class="col-md-4">
                                <span class="fw-bold text-danger">Total Due:</span> <b>₹{{ $totalDue }}</b>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Totals Fee Summary End -->

                @else
                @if(request()->has('student_id'))
                <div class="alert alert-danger">No fee records found for the selected student.</div>
                @endif
                @endif
            </div>

            <!-- Collect Fee Tab -->
            <div class="tab-pane fade" id="collect" role="tabpanel">

                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}
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
                    <!-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> -->
                </div>
                @endif

                <form action="{{ route('fees.store') }}" method="POST" class="row g-3">
                    @csrf

                    <div class="col-md-3">
                        <label for="class_id">Class</label>
                        <select name="class_id" id="class_id_collect" class="form-select" required>
                            <option value="">-- Select Class --</option>
                            @foreach($classes as $class)
                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                        @error('class_id')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label for="section_id">Section</label>
                        <select name="section_id" id="section_id_collect" class="form-select">
                            <option value="">-- Select Section --</option>
                            <!-- Filled via AJAX -->
                        </select>
                        @error('section_id')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label for="student_id">Student</label>
                        <select name="student_id" id="student_id_collect" class="form-select">
                            <option value="">Select Student</option>
                            <!-- Filled via AJAX -->
                        </select>
                        @error('student_id')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label>Roll No</label>
                        <input type="text" name="roll_no" id="roll_no_collect" class="form-control" readonly>
                        @error('roll_no')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- <div class="col-12">
                        <label for="month">Select Month</label>
                        <select name="month" id="month" class="form-control" required>
                            <option value="">-- Select Month --</option>
                            @foreach(['January','February','March','April','May','June','July','August','September','October','November','December'] as $month)
                                <option value="{{ $month }}">{{ $month }}</option>
                            @endforeach
                        </select>
                    </div> -->

                    <div class="col-12">
                        <label for="months">Select Month(s)</label>
                        <div class="dropdown">
                            <button class="btn btn-outline-primary form-control text-start dropdown-toggle"
                                type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Select Month(s)
                            </button>
                            <ul class="dropdown-menu p-3" style="max-height: 300px; overflow-y: auto;">
                                @foreach(['January','February','March','April','May','June','July','August','September','October','November','December']
                                as $month)
                                <li>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="months[]"
                                            id="month_{{ $month }}" value="{{ $month }}">
                                        <label class="form-check-label" for="month_{{ $month }}">{{ $month }}</label>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label>Class Fee Amount</label>
                        <input type="number" name="fee_amount" class="form-control" required>
                    </div>

                    <div class="col-md-4">
                        <label>Amount Paid</label>
                        <input type="number" name="amount_paid" id="amount_paid" class="form-control" required>
                        @error('amount_paid')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label>Amount Due</label>
                        <input type="number" name="amount_due" id="amount_due" class="form-control" readonly>
                        @error('amount_due')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-12 pt-3 text-center">
                        <button type="submit" class="btn btn-success">Collect Fee</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

<!-- Scripts -->
@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    setupFeeTab('manage'); // For Manage Fee tab
    setupFeeTab('collect'); // For Collect Fee tab

    function setupFeeTab(tabType) {
        const classSelector = `#class_id_${tabType}`;
        const sectionSelector = `#section_id_${tabType}`;
        const studentSelector = `#student_id_${tabType}`;
        const rollSelector = `#roll_no_${tabType}`;

        // On Class Change → Load Sections
        $(classSelector).on('change', function() {
            const classId = $(this).val();
            $(sectionSelector).html('<option value="">Loading...</option>');
            $(studentSelector).html('<option value="">-- Select Student --</option>');
            $(rollSelector).val('');

            if (classId) {
                $.get(`/admin/get-sections-by-class/${classId}`, function(sections) {
                    let options = `<option value="">-- Select Section --</option>`;
                    sections.forEach(function(section) {
                        options +=
                            `<option value="${section.id}">${section.name}</option>`;
                    });
                    $(sectionSelector).html(options);
                });
            }
        });

        // On Section Change → Load Students
        $(sectionSelector).on('change', function() {
            const sectionId = $(this).val();
            $(studentSelector).html('<option value="">Loading...</option>');
            $(rollSelector).val('');

            if (sectionId) {
                $.get(`/admin/get-students-by-section/${sectionId}`, function(students) {
                    let options = `<option value="">-- Select Student --</option>`;
                    students.forEach(function(student) {
                        const fullName =
                            `${student.first_name} ${student.last_name || ''}`.trim();
                        options +=
                            `<option value="${student.id}" data-roll="${student.roll_no}">${fullName} (Roll: ${student.roll_no})</option>`;
                    });
                    $(studentSelector).html(options);
                });
            }
        });

        // On Student Change → Fill Roll No Automatically
        $(studentSelector).on('change', function() {
            const rollNo = $(this).find(':selected').data('roll') || '';
            $(rollSelector).val(rollNo);
        });
    }

    // Auto-calculate Amount Due
    $('#amount_paid, [name="fee_amount"]').on('input', function() {
        var feeAmount = parseFloat($('[name="fee_amount"]').val()) || 0;
        var amountPaid = parseFloat($('#amount_paid').val()) || 0;
        var amountDue = feeAmount - amountPaid;
        $('#amount_due').val(amountDue >= 0 ? amountDue : 0);
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const dropdownBtn = document.querySelector('.dropdown-toggle');
    const checkboxes = document.querySelectorAll('input[name="month[]"]');

    checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            let selected = [];
            checkboxes.forEach(cb => {
                if (cb.checked) selected.push(cb.value);
            });
            dropdownBtn.textContent = selected.length > 0 ? selected.join(', ') :
                'Select Month(s)';
        });
    });
});
</script>
@endsection