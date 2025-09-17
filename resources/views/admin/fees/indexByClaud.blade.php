<style>
:root {
    --primary-color: #667eea;
    --primary-dark: #5a6fd8;
    --secondary-color: #764ba2;
    --success-color: #48bb78;
    --danger-color: #f56565;
    --warning-color: #ed8936;
    --info-color: #4299e1;
    --light-bg: #f8fafc;
    --card-shadow: 0 10px 25px rgba(0,0,0,0.1);
    --border-radius: 16px;
    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

body {
    /* background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); */
    min-height: 100vh;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.card {
    background: white;
    border-radius: var(--border-radius);
    box-shadow: var(--card-shadow);
    border: none;
    overflow: hidden;
    transition: var(--transition);
    margin: 2rem auto;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
}

.card-body {
    padding: 2rem;
}

/* Enhanced Tabs */
.nav-tabs {
    border: none;
    margin-bottom: 2rem;
    background: var(--light-bg);
    border-radius: 12px;
    padding: 0.5rem;
}

.nav-tabs .nav-link {
    border: none;
    border-radius: 10px;
    padding: 1rem 2rem;
    font-weight: 600;
    color: #64748b;
    transition: var(--transition);
    position: relative;
    overflow: hidden;
}

.nav-tabs .nav-link:hover {
    color: var(--primary-color);
    background: rgba(102, 126, 234, 0.1);
}

.nav-tabs .nav-link.active {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
}

.nav-tabs .nav-link::before {
    content: '\f013';
    font-family: 'Font Awesome 6 Free';
    font-weight: 900;
    margin-right: 0.5rem;
}

.nav-tabs .nav-link[href="#collect"]::before {
    content: '\f055';
}

/* Enhanced Form Controls */
.form-control,
.form-select {
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    padding: 0.75rem 1rem;
    transition: var(--transition);
    font-size: 0.95rem;
}

.form-control:focus,
.form-select:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

label {
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
}

/* Enhanced Buttons */
.btn {
    border-radius: 10px;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    transition: var(--transition);
    position: relative;
    overflow: hidden;
}

.btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: var(--transition);
}

.btn:hover::before {
    left: 100%;
}

.btn-primary {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    border: none;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
}

.btn-success {
    background: linear-gradient(135deg, var(--success-color), #38a169);
    border: none;
}

.btn-outline-primary {
    border: 2px solid var(--primary-color);
    color: var(--primary-color);
}

.btn-outline-primary:hover {
    background: var(--primary-color);
    border-color: var(--primary-color);
    transform: translateY(-2px);
}

.btn-outline-danger {
    border: 2px solid var(--danger-color);
    color: var(--danger-color);
}

.btn-outline-danger:hover {
    background: var(--danger-color);
    border-color: var(--danger-color);
    transform: translateY(-2px);
}

/* Enhanced Table */
#feeTable {
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    margin-top: 2rem;
    font-size: 0.92rem;
}

#feeTable thead th {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
    font-weight: 600;
    padding: 1rem 0.75rem;
    border: none;
    font-size: 0.9rem;
}

#feeTable tbody tr {
    transition: var(--transition);
}

#feeTable tbody tr:hover {
    background: rgba(102, 126, 234, 0.05);
    transform: scale(1.01);
}

#feeTable tbody td {
    padding: 1rem 0.75rem;
    vertical-align: middle;
    border-bottom: 1px solid #e2e8f0;
}

.action {
    display: flex;
    justify-content: center;
    gap: 0.5rem;
    align-items: center;
}

.action form {
    margin: 0;
}

/* Enhanced Dropdown */
.dropdown-toggle {
    display: flex;
    align-items: center;
    justify-content: space-between;
    min-height: 50px;
}

.dropdown-menu {
    border: none;
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    border-radius: 12px;
    padding: 1rem;
    margin-top: 0.5rem;
    max-height: 300px;
    overflow-y: auto;
}

.form-check {
    padding: 0.5rem 0;
    border-radius: 8px;
    transition: var(--transition);
}

.form-check:hover {
    background: rgba(102, 126, 234, 0.05);
}

.form-check-input:checked {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
}

/* Enhanced Alerts */
.alert {
    border: none;
    border-radius: 12px;
    padding: 1rem 1.5rem;
    font-weight: 500;
    margin-bottom: 1.5rem;
}

.alert-success {
    background: linear-gradient(135deg, rgba(72, 187, 120, 0.1), rgba(56, 161, 105, 0.1));
    color: var(--success-color);
    border-left: 4px solid var(--success-color);
}

.alert-danger {
    background: linear-gradient(135deg, rgba(245, 101, 101, 0.1), rgba(229, 62, 62, 0.1));
    color: var(--danger-color);
    border-left: 4px solid var(--danger-color);
}

.alert-info {
    background: linear-gradient(135deg, rgba(66, 153, 225, 0.1), rgba(49, 130, 206, 0.1));
    color: var(--info-color);
    border-left: 4px solid var(--info-color);
}

/* Input Groups */
.input-group-text {
    background: var(--light-bg);
    border: 2px solid #e2e8f0;
    border-right: none;
    border-radius: 12px 0 0 12px;
}

.input-group .form-control {
    border-left: none;
    border-radius: 0 12px 12px 0;
}

/* Fee Amount Badges */
.fee-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.85rem;
}

.fee-badge.paid {
    background: rgba(72, 187, 120, 0.1);
    color: var(--success-color);
}

.fee-badge.due {
    background: rgba(245, 101, 101, 0.1);
    color: var(--danger-color);
}

.fee-badge.partial {
    background: rgba(237, 137, 54, 0.1);
    color: var(--warning-color);
}

/* Loading States */
.loading {
    opacity: 0.6;
    pointer-events: none;
    position: relative;
}

.loading::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 20px;
    height: 20px;
    border: 2px solid #f3f3f3;
    border-top: 2px solid var(--primary-color);
    border-radius: 50%;
    animation: spin 1s linear infinite;
    transform: translate(-50%, -50%);
}

@keyframes spin {
    0% { transform: translate(-50%, -50%) rotate(0deg); }
    100% { transform: translate(-50%, -50%) rotate(360deg); }
}

/* Responsive Design */
@media (max-width: 768px) {
    .card-body {
        padding: 1.5rem;
    }
    
    .nav-tabs .nav-link {
        padding: 0.75rem 1rem;
        font-size: 0.9rem;
    }
    
    #feeTable {
        font-size: 0.8rem;
    }
    
    .btn {
        padding: 0.5rem 1rem;
    }
}

/* Animation Classes */
.fade-in {
    animation: fadeIn 0.6s ease-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

tr {
    white-space: nowrap;
}
</style>

@extends('admin.layouts.app')

@section('content')
<div class="card fade-in">
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
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-triangle me-2"></i>
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
                        <select name="class_id" id="class_id_manage" class="form-control" required>
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
                        <select name="student_id" id="student_id_manage" class="form-control">
                            <option value="">Select Student</option>
                            <!-- Filled via AJAX -->
                        </select>
                        @error('student_id')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-3 p-4">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-filter me-2"></i>Filter
                        </button>
                    </div>
                </form>

                @if(count($selectedFees) > 0)
                <div class="table-responsive">
                <table class="table table-bordered text-center" id="feeTable">
                    <thead>
                        <tr>
                            <th><i class="fas fa-hashtag me-1"></i>S no</th>
                            <th><i class="fas fa-calendar-alt me-1"></i>Month</th>
                            <th><i class="fas fa-calendar me-1"></i>Year</th>
                            <th><i class="fas fa-money-bill me-1"></i>Fee Amount</th>
                            <th><i class="fas fa-check-circle me-1"></i>Amount Paid</th>
                            <th><i class="fas fa-exclamation-circle me-1"></i>Amount Due</th>
                            <th><i class="fas fa-clock me-1"></i>Date Collected</th>
                            <th><i class="fas fa-cogs me-1"></i>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($selectedFees as $index => $fee)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $fee->month }}</td>
                            <td>{{ $fee->year }}</td>
                            <td>
                                <span class="fee-badge">₹{{ number_format($fee->fee_amount) }}</span>
                            </td>
                            <td>
                                <span class="fee-badge {{ $fee->amount_paid >= $fee->fee_amount ? 'paid' : ($fee->amount_paid > 0 ? 'partial' : 'due') }}">
                                    ₹{{ number_format($fee->amount_paid) }}
                                </span>
                            </td>
                            <td>
                                <span class="fee-badge {{ $fee->amount_due > 0 ? 'due' : 'paid' }}">
                                    ₹{{ number_format($fee->amount_due) }}
                                </span>
                            </td>
                            <td>{{ $fee->created_at->format('d-m-Y') }}</td>
                            <td class="action">
                                <a href="{{ route('fees.edit', $fee->id) }}" class="btn btn-sm btn-outline-primary"
                                   title="Edit"> <i class="fas fa-edit"></i>
                                </a>
                              
                                  <form action="{{ route('fees.destroy', $fee->id) }}"
                                      method="POST" onsubmit="return confirm('Are you sure you want to delete this fee record?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm"
                                            title="Delete"> <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                                </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
                @else
                    @if(request()->has('student_id'))
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            No fee records found for the selected student.
                        </div>
                    @endif
                @endif
            </div>

            <!-- Collect Fee Tab -->
            <div class="tab-pane fade" id="collect" role="tabpanel">
                
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @if($errors->any())
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
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
                    <label for="class_id"><i class="fas fa-school me-1"></i>Class</label>
                        <select name="class_id" id="class_id_collect" class="form-control" required>
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
                       <select name="section_id" id="section_id_collect" class="form-select">
                            <option value="">-- Select Section --</option>
                            <!-- Filled via AJAX -->
                        </select>
                        @error('section_id')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label for="student_id"><i class="fas fa-user-graduate me-1"></i>Student</label>
                        <select name="student_id" id="student_id_collect" class="form-control">
                            <option value="">Select Student</option>
                            <!-- Filled via AJAX -->
                        </select>
                        @error('student_id')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="col-md-3">
                        <label><i class="fas fa-id-badge me-1"></i>Roll No</label>
                        <input type="text" name="roll_no" id="roll_no_collect" class="form-control" readonly>
                        @error('roll_no')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-12">
                    <label for="months"><i class="fas fa-calendar-check me-1"></i>Select Month(s)</label>
                    <div class="dropdown">
                    <button class="btn btn-outline-primary form-control text-start dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Select Month(s)
                    </button>
                    <ul class="dropdown-menu p-3" style="max-height: 300px; overflow-y: auto; width: 100%;">
                        @foreach(['January','February','March','April','May','June','July','August','September','October','November','December'] as $month)
                            <li>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="months[]" id="month_{{ $month }}" value="{{ $month }}">
                                    <label class="form-check-label" for="month_{{ $month }}">{{ $month }}</label>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label><i class="fas fa-money-bill-wave me-1"></i>Class Fee Amount</label>
                        <div class="input-group">
                            <span class="input-group-text">₹</span>
                            <input type="number" name="fee_amount" class="form-control" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label><i class="fas fa-hand-holding-usd me-1"></i>Amount Paid</label>
                        <div class="input-group">
                            <span class="input-group-text">₹</span>
                            <input type="number" name="amount_paid" id="amount_paid" class="form-control" required>
                        </div>
                        @error('amount_paid')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label><i class="fas fa-exclamation-triangle me-1"></i>Amount Due</label>
                        <div class="input-group">
                            <span class="input-group-text">₹</span>
                            <input type="number" name="amount_due" id="amount_due" class="form-control" readonly>
                        </div>
                        @error('amount_due')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-12 pt-3 text-center">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="fas fa-money-check me-2"></i>Collect Fee
                        </button>
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
$(document).ready(function () {
    setupFeeTab('manage');  // For Manage Fee tab
    setupFeeTab('collect'); // For Collect Fee tab

    function setupFeeTab(tabType) {
        const classSelector = `#class_id_${tabType}`;
        const sectionSelector = `#section_id_${tabType}`;
        const studentSelector = `#student_id_${tabType}`;
        const rollSelector = `#roll_no_${tabType}`;

        // On Class Change → Load Sections
        $(classSelector).on('change', function () {
            const classId = $(this).val();
            $(sectionSelector).html('<option value="">Loading...</option>');
            $(studentSelector).html('<option value="">-- Select Student --</option>');
            $(rollSelector).val('');

            if (classId) {
                $.get(`/admin/get-sections-by-class/${classId}`, function (sections) {
                    let options = `<option value="">-- Select Section --</option>`;
                    sections.forEach(function (section) {
                        options += `<option value="${section.id}">${section.name}</option>`;
                    });
                    $(sectionSelector).html(options);
                });
            }
        });

        // On Section Change → Load Students
        $(sectionSelector).on('change', function () {
            const sectionId = $(this).val();
            $(studentSelector).html('<option value="">Loading...</option>');
            $(rollSelector).val('');

            if (sectionId) {
                $.get(`/admin/get-students-by-section/${sectionId}`, function (students) {
                    let options = `<option value="">-- Select Student --</option>`;
                    students.forEach(function (student) {
                        const fullName = `${student.first_name} ${student.last_name || ''}`.trim();
                        options += `<option value="${student.id}" data-roll="${student.roll_no}">${fullName} (Roll: ${student.roll_no})</option>`;
                    });
                    $(studentSelector).html(options);
                });
            }
        });

        // On Student Change → Fill Roll No
        $(studentSelector).on('change', function () {
            const rollNo = $(this).find(':selected').data('roll') || '';
            $(rollSelector).val(rollNo);
        });
    }

    // Auto-calculate Amount Due
    $('#amount_paid, [name="fee_amount"]').on('input', function () {
        var feeAmount = parseFloat($('[name="fee_amount"]').val()) || 0;
        var amountPaid = parseFloat($('#amount_paid').val()) || 0;
        var amountDue = feeAmount - amountPaid;
        $('#amount_due').val(amountDue >= 0 ? amountDue : 0);
    });
});
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const dropdownBtn = document.querySelector('.dropdown-toggle');
        const checkboxes = document.querySelectorAll('input[name="month[]"]');

        checkboxes.forEach(function (checkbox) {
            checkbox.addEventListener('change', function () {
                let selected = [];
                checkboxes.forEach(cb => {
                    if (cb.checked) selected.push(cb.value);
                });
                dropdownBtn.textContent = selected.length > 0 ? selected.join(', ') : 'Select Month(s)';
            });
        });
    });
</script>

@endsection