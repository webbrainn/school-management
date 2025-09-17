@extends('admin.layouts.app')

@section('content')
<div class="container-fluid p-4">
    <h4 class="mb-4">Grade Management</h4>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Tabs --}}
    <ul class="nav nav-tabs" id="gradeTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="manage-tab" data-bs-toggle="tab" data-bs-target="#manage" type="button"
                role="tab">Manage Grades</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="add-tab" data-bs-toggle="tab" data-bs-target="#add" type="button"
                role="tab">Add Grade</button>
        </li>
    </ul>

    <div class="tab-content mt-3" id="gradeTabContent">
        {{-- Manage Grades Tab --}}
        <div class="tab-pane fade show active" id="manage" role="tabpanel">
            <table class="table table-bordered table-striped mt-3 text-center">
                <thead>
                    <tr>
                        <th>S/No</th>
                        <th>Grade Name</th>
                        <th>Mark Range</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($grades as $grade)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $grade->grade_name }}</td>
                        <td>{{ $grade->mark_from }} - {{ $grade->mark_to }}</td>
                        <td>{{ $grade->description }}</td>
                        <td>
                            <a href="{{ route('grades.edit', $grade->id) }}" class="btn btn-sm btn-outline-info" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('grades.destroy', $grade->id) }}" method="POST"
                                style="display:inline-block;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"
                                    onclick="return confirm('Are you sure to delete this grade?')">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">No grades available.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Add Grade Tab --}}
        <div class="tab-pane fade" id="add" role="tabpanel">
            <form action="{{ route('grades.store') }}" method="POST" class="mt-3">
                @csrf
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label>Grade Name</label>
                        <input type="text" name="grade_name" class="form-control" value="{{ old('grade_name') }}">
                        @error('grade_name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>Mark From</label>
                        <input type="number" name="mark_from" class="form-control" value="{{ old('mark_from') }}">
                        @error('mark_from') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>Mark To</label>
                        <input type="number" name="mark_to" class="form-control" value="{{ old('mark_to') }}">
                        @error('mark_to') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>Description</label>
                        <input type="text" name="description" class="form-control" value="{{ old('description') }}">
                        @error('description') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-success">Save Grade</button>
            </form>
        </div>
    </div>
</div>
@endsection