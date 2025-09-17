@extends('admin.layouts.app')

@section('content')

<div class="container-fluid p-4">
    <div class="card shadow">

        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Edit Teacher</h4>
            <a href="{{ route('admin.teachers.index') }}" class="btn btn-secondary">View All Teachers</a>
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

            <form action="{{ route('admin.teachers.update', $teacher->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>Name:</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $teacher->name) }}"
                           required>
                    @error('name')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Email:</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $teacher->email) }}"
                        required>
                    @error('email')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Phone:</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $teacher->phone) }}"
                        required>
                    @error('phone')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Qualification:</label>
                    <input type="text" name="qualification" class="form-control"
                        value="{{ old('qualification', $teacher->qualification) }}">
                    @error('qualification')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Subject:</label>
                    <input type="text" name="subject" class="form-control" value="{{ old('subject', $teacher->subject) }}">
                    @error('subject')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- <div class="form-group">
                    <label>Bio:</label>
                    <textarea name="bio" class="form-control">{{ old('bio', $teacher->bio) }}</textarea>
                </div> -->

                <div class="d-flex justify-content-end p-2">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('admin.teachers.index') }}" class="btn btn-secondary ml-2">Back</a>
                </div>

            </form>
        </div>

    </div>
</div>

@endsection