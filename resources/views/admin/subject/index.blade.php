<style>
label {
    font-weight: bold;
}
</style>

@extends('admin.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs" id="subjectTab" role="tablist">
            <li class="nav-item">
                <!-- <a class="nav-link active" id="add-tab" data-bs-toggle="tab" href="#add" role="tab">Add Subject</a> -->

                <a class="nav-link {{ request('class_id') ? '' : 'active' }}" id="add-tab" data-bs-toggle="tab"
                    href="#add" role="tab">Add Subject</a>
                <!-- <a class="nav-link {{ request('class_id') ? '' : 'active' }}" id="add-tab" data-bs-toggle="tab"
                    href="{{ route('subject.index') }}" role="tab">Add Subject</a> -->
            </li>
            <li class="nav-item">
                <!-- <a class="nav-link" id="manage-tab" data-bs-toggle="tab" href="#manage" role="tab">Manage Subjects</a> -->
                <a class="nav-link {{ request('class_id') ? 'active' : '' }}" id="manage-tab" data-bs-toggle="tab"
                    href="#manage" role="tab">Manage Subjects</a>
            </li>
        </ul>
    </div>

    <div class="card-body tab-content" id="subjectTabContent">

        <!-- Add Subject -->
        <!-- <div class="tab-pane fade show active" id="add" role="tabpanel" aria-labelledby="add-tab"> -->
        <div class="tab-pane fade {{ request('class_id') ? '' : 'show active' }}" id="add" role="tabpanel"
            aria-labelledby="add-tab">

            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form method="POST" action="{{ route('subject.store') }}">
                @csrf
                <div class="mb-3">
                    <label>Name *</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                        placeholder="Name of subject">
                    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="mb-3">
                    <label>Short Name *</label>
                    <input type="text" name="short_name" class="form-control" value="{{ old('short_name') }}"
                        placeholder="Eg. B.Eng">
                    @error('short_name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="mb-3">
                    <label>Select Class *</label>
                    <select name="class_id" id="classDropdown" class="form-select">
                        <option value="">--Select Class--</option>
                        @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                            {{ $class->name }}</option>
                        @endforeach
                    </select>
                    @error('class_id') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <!-- Select Section -->
                <div class="mb-3">
                    <label>Select Section</label>
                    <select name="section_id" id="sectionDropdown" class="form-select">
                        <option value="">--Select Section--</option>
                        <!-- Will be populated via AJAX -->
                    </select>
                    @error('section_id') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mb-3">
                    <label>Subject Teacher *</label>
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

                <button type="submit" class="btn btn-primary">Submit form <i class="fas fa-paper-plane"></i></button>
            </form>
        </div>

        <!-- Manage Subjects -->
        <!-- <div class="tab-pane fade" id="manage" role="tabpanel" aria-labelledby="manage-tab"> -->
        <div class="tab-pane fade {{ request('class_id') ? 'show active' : '' }}" id="manage" role="tabpanel"
            aria-labelledby="manage-tab">

            <!-- <form method="GET" action="#manage"> -->
            <form method="GET" action="{{ route('subject.index') }}">
                <div class="row">
                    <div class="col-md-4">
                        <label>Choose Class to Manage Subjects</label>
                        <select name="class_id" id="filterClassDropdown" class="form-select">
                            <option value="">Select Class</option>
                            @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                {{ $class->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label>Choose Section</label>
                        <select name="section_id" id="filterSectionDropdown" class="form-select">
                            <option value="">Select Section</option>
                            @if(request('class_id'))
                            @foreach($sections->where('class_id', request('class_id')) as $section)
                            <option value="{{ $section->id }}"
                                {{ request('section_id') == $section->id ? 'selected' : '' }}>
                                {{ $section->name }}
                            </option>
                            @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </div>
                </div>
            </form>


            @if(request()->has('class_id') && request()->has('section_id') && request('class_id') &&
            request('section_id'))
            <div class="mt-4">

                <table class="table table-bordered table-hover text-center">
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Name</th>
                            <th>Short Name</th>
                            <th>Class</th>
                            <th>Section</th>
                            <th>Subject Teacher</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($subjects as $key => $subject)
                        <tr>
                            <td>{{ $subjects->firstItem() + $key }}</td>
                            <td>{{ $subject->name }}</td>
                            <td>{{ $subject->short_name }}</td>
                            <td>{{ $subject->class->name ?? 'N/A' }}</td>
                            <td>{{ $subject->section->name ?? 'N/A' }}</td>
                            <td>{{ $subject->teacher->name ?? 'N/A' }}</td>
                            <td>
                                <a href="{{ route('subject.edit', $subject->id) }}"
                                    class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('subject.destroy', $subject->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"
                                        onclick="return confirm('Delete this subject?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No subjects found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                {{ $subjects->withQueryString()->links() }}
            </div>
            @endif
        </div>

    </div>
</div>
@endsection

<!-- @push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // If there's a class_id in the URL, show the Manage tab
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('class_id')) {
        const manageTab = new bootstrap.Tab(document.querySelector('#manage-tab'));
        manageTab.show();
    }
});
</script>
@endpush -->

<!-- Show section dropdown after select the class in add tab-->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const classDropdown = document.getElementById('classDropdown');
    const sectionDropdown = document.getElementById('sectionDropdown');

    classDropdown.addEventListener('change', function() {
        const classId = this.value;
        sectionDropdown.innerHTML = '<option value="">--Select Section--</option>';

        if (classId) {
            fetch(`/admin/get-sections/${classId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        data.forEach(section => {
                            const option = document.createElement('option');
                            option.value = section.id;
                            option.text = section.name;
                            sectionDropdown.appendChild(option);
                        });
                    }
                })
                .catch(error => {
                    console.error('Error fetching sections:', error);
                });
        }
    });
});
</script>


<!-- show section dropdown on manage tab-->
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const classDropdown = document.getElementById('filterClassDropdown');
    const sectionDropdown = document.getElementById('filterSectionDropdown');

    classDropdown.addEventListener('change', function() {
        const classId = this.value;
        sectionDropdown.innerHTML = '<option value="">Select Section</option>';

        if (classId) {
            fetch(`/admin/get-sections/${classId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        data.forEach(section => {
                            const option = document.createElement('option');
                            option.value = section.id;
                            option.text = section.name;
                            sectionDropdown.appendChild(option);
                        });
                    }
                })
                .catch(error => {
                    console.error('Error fetching sections:', error);
                });
        }
    });
});
</script>
@endpush