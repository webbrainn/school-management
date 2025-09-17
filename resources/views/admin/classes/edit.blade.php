@extends('admin.layouts.app')

@section('content')

<div class="container-fluid p-4">
    <div class="card shadow">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Edit Class</h4>
            <a href="{{ route('classes.index') }}" class="btn btn-secondary">Back to List</a>
        </div>

        <div class="card-body">

            <!-- Success Message -->
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <!-- Error Messages -->
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('classes.update', $class->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Class Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $class->name) }}"
                        required>
                </div>

                <!-- <div class="mb-3">
                    <label for="capacity" class="form-label">Capacity</label>
                    <input type="number" name="capacity" class="form-control"
                        value="{{ old('capacity', $class->capacity) }}">
                </div> -->

                <!-- <div class="mb-3">
                    <label for="teacher_id" class="form-label">Class Teacher</label>
                    <select name="teacher_id" class="form-select">
                        <option value="">Select Teacher</option>
                        @foreach($teachers as $teacher)
                        <option value="{{ $teacher->id }}"
                            {{ (old('teacher_id', $class->teacher_id) == $teacher->id) ? 'selected' : '' }}>
                            {{ $teacher->name }} ({{ $teacher->subject }})
                        </option>
                        @endforeach
                    </select>
                </div> -->

                <button type="submit" class="btn btn-success">Update</button>
            </form>

        </div>

    </div>
</div>

@endsection