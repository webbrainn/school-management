
@extends('admin.layouts.app')

@section('content')
<div class="container-fluid p-4">
    <div class="card shadow">
    <div class="card-header">
        <h4>Edit Section</h4>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('section.update', $section->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Section Name *</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $section->name) }}">
                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label for="class_id" class="form-label">Select Class *</label>
                <select name="class_id" class="form-select">
                    <option value="">--Select Class--</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{ $section->class_id == $class->id ? 'selected' : '' }}>
                            {{ $class->name }}
                        </option>
                    @endforeach
                </select>
                @error('class_id') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label for="teacher_id" class="form-label">Select Class Teacher *</label>
                <select name="teacher_id" class="form-select">
                    <option value="">--Select Teacher--</option>
                    @foreach($teachers as $teacher)
                        <option value="{{ $teacher->id }}" {{ $section->teacher_id == $teacher->id ? 'selected' : '' }}>
                            {{ $teacher->name }}
                        </option>
                    @endforeach
                </select>
                @error('teacher_id') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label for="capacity" class="form-label">Capacity</label>
                <input type="number" name="capacity" class="form-control" value="{{ old('capacity', $section->capacity) }}" placeholder="Number of students allowed in this section">
            </div>

            <button type="submit" class="btn btn-primary">Update Section</button>
            <a href="{{ route('section.index') }}" class="btn btn-secondary">Back</a>
        </form>
    </div>
</div>
</div>
@endsection
