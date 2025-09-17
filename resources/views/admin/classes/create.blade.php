@extends('admin.layouts.app')

@section('content')

<div class="container-fluid p-4">
    <div class="card shadow">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="mb-0">Add New Class</h3>
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

            <!-- Add Class Form -->
            <form action="{{ route('classes.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Class Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                </div>

                <!-- <div class="mb-3">
                    <label for="capacity" class="form-label">Capacity</label>
                    <input type="number" name="capacity" class="form-control" value="{{ old('capacity') }}">
                </div> -->

                <!-- <div class="mb-3">
                    <label for="teacher_id" class="form-label">Class Teacher</label>
                    <select name="teacher_id" class="form-select">
                        <option value="">Select Teacher</option>
                        @foreach($teachers as $teacher)
                        <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                            {{ $teacher->name }} {{ $teacher->subject ? '(' . $teacher->subject . ')' : '' }}
                        </option>
                        @endforeach
                    </select>
                    @error('teacher_id') <small class="text-danger">{{ $message }}</small> @enderror
                </div> -->

                <div class="pt-4">
                    <button type="submit" class="btn btn-success">Create</button>
                </div>
            </form>

        </div>

    </div>
</div>

@endsection