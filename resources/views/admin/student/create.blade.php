@extends('admin.layouts.app')

@section('content')

<div class="container-fluid p-4">
    <div class="card shadow">
        
    <div class="card-header d-flex justify-content-between align-items-center">
    <h3 class="mb-0">Add New Student</h3>
    <div>
        <!-- <a href="" class="btn btn-primary me-2">Bulk Upload</a> -->
        <a href="{{ route('students.index') }}" class="btn btn-secondary">Back to List</a>
    </div>
    </div>

        <div class="card-body">

             <!-- Success Message -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- General Error Message -->
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('students.store') }}" method="POST">
                @csrf

                <div class="row">

                <div class="col-md-6 mb-3">
                    <label class="form-label">Class</label>
                    <select name="class_id" id="class_id" class="form-control">
                        <option value="">Select Class</option>
                        @foreach ($classes as $class)
                        <option value="{{ $class->id }}">
                            {{ $class->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('class_id')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Section</label>
                    <select name="section_id" id="section_id" class="form-control" required>
                        <option value="">Select Section</option>
                    </select>
                    @error('section_id')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">First Name</label>
                    <input type="text" name="first_name" class="form-control" value="{{ old('first_name') }}">
                    @error('first_name')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Last Name</label>
                    <input type="text" name="last_name" class="form-control" value="{{ old('last_name') }}">
                    @error('last_name')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="roll_no" class="form-label">Roll Number</label>
                    <input type="number" name="roll_no" id="roll_no" class="form-control"
                           value="{{ old('roll_no', $student->roll_no ?? '') }}" required>
                    @error('roll_no')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                    @error('email')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                    @error('phone')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Date of Birth</label>
                    <input type="date" name="dob" class="form-control" value="{{ old('dob') }}">
                    @error('dob')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Gender</label>
                    <select name="gender" class="form-control" required>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                    @error('gender')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Address</label>
                    <textarea name="address" class="form-control">{{ old('address') }}</textarea>
                    @error('address')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                </div>

                <button type="submit" class="btn btn-success">Add Student</button>
            </form>

            <form action="{{ route('students.import') }}" method="POST" enctype="multipart/form-data" class="my-4">
            @csrf
            <div class="form-group">
                <label for="file">Upload Excel File (.xlsx)</label>
                <input type="file" name="file" class="form-control" required>
                @error('file') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="d-flex align-items-center mt-2">
                <button type="submit" class="btn btn-info me-2">Import Students</button>
                <a href="{{ asset('admin/templates/students-template.xlsx') }}" class="btn btn-warning">
                    Download Excel Template
                </a>
            </div>
            </form>

        </div>
    </div>
</div>

@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#class_id').on('change', function() {
        var classId = $(this).val();

        if (classId) {
            $.ajax({
                url: "{{ route('admin.getSectionsByClass') }}",
                type: "GET",
                data: {
                    class_id: classId
                },
                success: function(data) {
                    $('#section_id').empty().append(
                        '<option value="">Select Section</option>');
                    $.each(data, function(key, section) {
                        let seatsLeft = section.capacity - section.students_count;
                        let disabled = seatsLeft <= 0 ? 'disabled' : '';
                        let label = section.name + ' (Seats left: ' + seatsLeft +')';
                        $('#section_id').append('<option value="' + section.id +
                            '" ' + disabled + '>' + label + '</option>');
                    });
                },
                error: function() {
                    alert('Error fetching sections.');
                }
            });
        } else {
            $('#section_id').empty().append('<option value="">Select Section</option>');
        }
    });
});
</script>
