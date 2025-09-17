@extends('admin.layouts.app')

@section('content')

<div class="container-fluid p-4">
<div class="card">

    <div class="card-body">
        <h5 class="mb-4">Edit Fee Record</h5>

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

        <form action="{{ route('fees.update', $fee->id) }}" method="POST" class="row g-3">
            @csrf
            @method('PUT')

            <!-- Class ID (Readonly) -->
            <div class="col-md-3">
                <label>Class</label>
                <input type="text" class="form-control" value="{{ $fee->class->name ?? 'N/A' }}" readonly>
                <input type="hidden" name="class_id" value="{{ $fee->class_id }}">
            </div>

            <!-- Section ID (Readonly) -->
            <div class="col-md-3">
                <label>Section</label>
                <input type="text" class="form-control" value="{{ $fee->section->name ?? 'N/A' }}" readonly>
                <input type="hidden" name="section_id" value="{{ $fee->section_id }}">
            </div>

            <!-- Student ID (Readonly) -->
            <div class="col-md-3">
                <label>Student</label>
                <input type="text" class="form-control" value="{{ $fee->student->first_name }} {{ $fee->student->last_name }}" readonly>
                <input type="hidden" name="student_id" value="{{ $fee->student_id }}">
            </div>

            <!-- Roll No -->
            <div class="col-md-3">
                <label>Roll No</label>
                <input type="text" name="roll_no" class="form-control" value="{{ $fee->roll_no }}" readonly>
                @error('roll_no')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <!-- Month -->
            <div class="col-md-3">
                <label>Month</label>
                <input type="text" name="month" class="form-control" value="{{ $fee->month }}" readonly>
                @error('month')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <!-- Year -->
            <!-- <div class="col-md-3">
                <label>Year</label>
                <input type="text" name="year" class="form-control" value="{{ $fee->year }}" readonly>
                @error('year')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div> -->

            <!-- Fee Amount -->
            <div class="col-md-3">
                <label>Class Fee Amount</label>
                <input type="number" name="fee_amount" class="form-control" value="{{ $fee->fee_amount }}" required>
                @error('fee_amount')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <!-- Amount Paid -->
            <div class="col-md-3">
                <label>Amount Paid</label>
                <input type="number" name="amount_paid" id="amount_paid" class="form-control" value="{{ $fee->amount_paid }}" required>
                @error('amount_paid')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <!-- Amount Due -->
            <div class="col-md-3">
                <label>Amount Due</label>
                <input type="number" name="amount_due" id="amount_due" class="form-control" value="{{ $fee->amount_due }}" readonly>
                @error('amount_due')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-12 pt-3 text-center">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('fees.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </form>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const feeAmountInput = document.querySelector('[name="fee_amount"]');
    const amountPaidInput = document.querySelector('[name="amount_paid"]');
    const amountDueInput = document.querySelector('[name="amount_due"]');

    function calculateDue() {
        const feeAmount = parseFloat(feeAmountInput.value) || 0;
        const paidAmount = parseFloat(amountPaidInput.value) || 0;
        const due = Math.max(feeAmount - paidAmount, 0);
        amountDueInput.value = due;
    }

    feeAmountInput.addEventListener('input', calculateDue);
    amountPaidInput.addEventListener('input', calculateDue);
});
</script>
@endsection
