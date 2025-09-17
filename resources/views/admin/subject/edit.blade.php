<style>
    label{
        font-weight: bold;
    }
</style>
@extends('admin.layouts.app')

@section('content')
<div class="container-fluid p-4">
    <div class="card shadow">

        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>Edit Subject</h4>
            <a href="{{ route('subject.index') }}" class="btn btn-secondary">Back</a>
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

            <form action="{{ route('subject.update', $subject->id) }}" method="POST">
                @csrf @method('PUT')

                <div class="form-group">
                    <label>Name *</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $subject->name) }}">
                    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label>Short Name *</label>
                    <input type="text" name="short_name" class="form-control"
                        value="{{ old('short_name', $subject->short_name) }}">
                    @error('short_name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label>Select Class *</label>
                    <select name="class_id" class="form-control">
                        @foreach($classes as $class)
                        <option value="{{ $class->id }}"
                            {{ old('class_id', $subject->class_id) == $class->id ? 'selected' : '' }}>{{ $class->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('class_id') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <!-- section -->
                <div class="form-group">
                    <label>Select Section *</label>
                    <select name="section_id" class="form-control">
                        @foreach($sections as $section)
                        <option value="{{ $section->id }}"
                            {{ old('section_id', $subject->section_id) == $section->id ? 'selected' : '' }}>
                            {{ $section->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('section_id') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label>Select Teacher *</label>
                    <select name="teacher_id" class="form-control">
                        @foreach($teachers as $teacher)
                        <option value="{{ $teacher->id }}"
                            {{ old('teacher_id', $subject->teacher_id) == $teacher->id ? 'selected' : '' }}>
                            {{ $teacher->name }}
                            @if($teacher->subject)
                            ({{ $teacher->subject }})
                            @endif
                        </option>
                        @endforeach
                    </select>
                    @error('teacher_id') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
            </form>

        </div>
    </div>
</div>
@endsection