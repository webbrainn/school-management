@extends('admin.layouts.app')

@section('content')
<div class="container-fluid p-4">
    <h4 class="mb-4">Edit Grade</h4>

    {{-- Display success message --}}
   @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    {{-- Display validation errors --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Edit form --}}
    <form action="{{ route('grades.update', $grade->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-3 mb-3">
                <label>Grade Name</label>
                <input type="text" name="grade_name" class="form-control" value="{{ old('grade_name', $grade->grade_name) }}">
                @error('grade_name') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="col-md-3 mb-3">
                <label>Mark From</label>
                <input type="number" name="mark_from" class="form-control" value="{{ old('mark_from', $grade->mark_from) }}">
                @error('mark_from') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="col-md-3 mb-3">
                <label>Mark To</label>
                <input type="number" name="mark_to" class="form-control" value="{{ old('mark_to', $grade->mark_to) }}">
                @error('mark_to') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="col-md-3 mb-3">
                <label>Description</label>
                <input type="text" name="description" class="form-control" value="{{ old('description', $grade->description) }}">
                @error('description') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('grades.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
