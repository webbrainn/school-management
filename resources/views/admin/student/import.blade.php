@extends('admin.layouts.app')

@section('content')
<div class="container-fluid p-4">
    <div class="card shadow">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="mb-0">Import Students</h3>
            <a href="{{ route('students.index') }}" class="btn btn-secondary">Back to List</a>
        </div>

        <div class="card-body">
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('students.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Upload Excel File</label>
                    <input type="file" name="file" class="form-control" required>
                    @error('file')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <button type="submit" class="btn btn-success">Import</button>
            </form>

            <hr>
            <h5>Excel Format Example:</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>first_name</th>
                        <th>last_name</th>
                        <th>email</th>
                        <th>phone</th>
                        <th>dob (YYYY-MM-DD)</th>
                        <th>gender</th>
                        <th>address</th>
                        <th>class_id</th>
                        <th>section_id</th>
                        <th>roll_no</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection