@extends('admin.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs" id="sectionTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link {{ request('class_id') ? '' : 'active' }}" id="add-tab" data-bs-toggle="tab"
                    href="#add" role="tab">Add Section</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('class_id') ? 'active' : '' }}" id="manage-tab" data-bs-toggle="tab"
                    href="#manage" role="tab">Manage Sections</a>
            </li>
        </ul>
    </div>

    <div class="card-body tab-content" id="sectionTabContent">
        <!-- Add Section -->
        <div class="tab-pane fade {{ request('class_id') ? '' : 'show active' }}" id="add" role="tabpanel"
            aria-labelledby="add-tab">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('section.store') }}">
                @csrf
                <div class="mb-3">
                    <label>Section Name *</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                        placeholder="Section A, B, etc.">
                    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mb-3">
                    <label>Select Class *</label>
                    <select name="class_id" class="form-select">
                        <option value="">--Select Class--</option>
                        @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                            {{ $class->name }}</option>
                        @endforeach
                    </select>
                    @error('class_id') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mb-3">
                    <label>Class Teacher *</label>
                    <select name="teacher_id" class="form-select">
                        <option value="">--Select Teacher--</option>
                        @foreach($teachers as $teacher)
                        <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                            {{ $teacher->name }}
                            @if($teacher->subject)
                            ({{ $teacher->subject }})
                            @endif
                        </option>
                        @endforeach
                    </select>
                    @error('teacher_id') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mb-3">
                    <label>Section Capacity</label>
                    <input type="number" name="capacity" class="form-control" value="{{ old('capacity') }}"
                        placeholder="Number of students allowed in this section">
                    @error('capacity') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <button type="submit" class="btn btn-primary">Add Section</button>
            </form>
        </div>

        <!-- Manage Sections -->
        <div class="tab-pane fade {{ request('class_id') ? 'show active' : '' }}" id="manage" role="tabpanel"
            aria-labelledby="manage-tab">

            <form method="GET" action="{{ route('section.index') }}">
                <div class="row">
                    <div class="col-md-4">
                        <label>Choose Class to Manage Sections</label>
                        <select name="class_id" class="form-select" onchange="this.form.submit()">
                            <option value="">Select Class</option>
                            @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                {{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>

            @if(request('class_id'))
            <div class="mt-4">
                <table class="table table-bordered table-hover text-center">
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Section Name</th>
                            <th>Class</th>
                            <th>Capacity</th>
                            <th>Teacher</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sections as $key => $section)
                        <tr>
                            <td>{{ $sections->firstItem() + $key }}</td>
                            <td>{{ $section->name }}</td>
                            <td>{{ $section->schoolClass->name ?? 'N/A' }}</td>
                            <td>{{ $section->capacity }}</td>
                            <td>{{ $section->teacher->name ?? 'N/A' }}</td>
                            <td>
                                <a href="{{ route('section.edit', $section->id) }}"
                                    class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('section.destroy', $section->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Are you sure?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5">No sections found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                {{ $sections->withQueryString()->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection