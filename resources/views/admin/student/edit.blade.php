@extends('admin.layouts.app')

@section('content')

<div class="container-fluid p-4">
    <div class="card shadow">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="mb-0">Edit Student</h3>
            <a href="{{ route('students.index') }}" class="btn btn-secondary">Back</a>
        </div>

        <div class="card-body">

            <!-- Success & Error Messages -->
            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <!-- Display Validation Errors -->
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

            <form action="{{ route('students.update', $student->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Class</label>
                    <select name="class_id" class="form-control">
                        <option value="">Select Class</option>
                        @foreach ($classes as $class)
                        @php
                        $isSelected = $class->id == $student->class_id;
                        @endphp
                        <option value="{{ $class->id }}" {{ $isSelected ? 'selected' : '' }}>
                            {{ $class->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="">Select Section</label>
                    <select name="section_id" class="form-control">
                    <option value="">Select Section</option>
                    @foreach ($sections as $section)
                    <option value="{{ $section->id }}" {{ $student->section_id == $section->id ? 'selected' : '' }}>
                        {{ $section->name }} (seats left : {{ $section->remaining_seats }})
                    </option>
                    @endforeach
                </select>
                </div>
                
                <div class="mb-3">
                    <label for="roll_no" class="form-label">Roll Number</label>
                    <input type="number" name="roll_no" id="roll_no" class="form-control"
                           value="{{ old('roll_no', $student->roll_no ?? '') }}" required>
                    @error('roll_no')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">First Name</label>
                    <input type="text" name="first_name" class="form-control"
                           value="{{ old('first_name', $student->first_name) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Last Name</label>
                    <input type="text" name="last_name" class="form-control"
                        value="{{ old('last_name', $student->last_name) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $student->email) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $student->phone) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Date of Birth</label>
                    <input type="date" name="dob" class="form-control" value="{{ old('dob', $student->dob) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Gender</label>
                    <select name="gender" class="form-control">
                        <option value="Male" {{ $student->gender == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ $student->gender == 'Female' ? 'selected' : '' }}>Female</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Address</label>
                    <textarea name="address" class="form-control">{{ old('address', $student->address) }}</textarea>
                </div>

                <!-- <div class="mb-3">
                    <label class="form-label">Class</label>
                    <select name="class_id" class="form-control" required>
                        <option value="">Select Class</option>
                        @foreach ($classes as $class)
                            <option value="{{ $class->id }}" 
                                {{ $student->class_id == $class->id ? 'selected' : '' }}>
                                {{ $class->name }} (Capacity: {{ $class->capacity }})
                            </option>
                        @endforeach
                    </select>
                </div> -->

                <div class="pt-2">
                    <button type="submit" class="btn btn-success">Update Student</button>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection