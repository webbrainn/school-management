@extends('admin.layouts.app')

@section('content')

<div class="container-fluid p-4">
    <div class="card shadow">

        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="mb-0">Add Teacher</h3>
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

            <form action="{{ route('admin.teachers.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label>Name:</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                    @error('name')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Email:</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                    @error('email')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Phone:</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                    @error('phone')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- <div class="form-group">
                    <label>Password:</label>
                    <div class="input-group">
                        <input type="password" name="password" class="form-control" id="password" required>
                        <span class="input-group-text" onclick="togglePassword()" style="cursor: pointer;">
                            <i class="fa fa-eye-slash" id="togglePasswordIcon"></i>
                        </span>
                    </div>
                </div> -->

                <div class="form-group">
                    <label>Qualification:</label>
                    <input type="text" name="qualification" class="form-control" value="{{ old('qualification') }}">
                    @error('qualification')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Subject:</label>
                    <input type="text" name="subject" class="form-control" value="{{ old('subject') }}">
                    @error('subject')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- <div class="form-group">
                <label>Bio:</label>
                <textarea name="bio" class="form-control">{{ old('bio') }}</textarea>
                </div> -->

                <div class="d-flex justify-content-end p-2">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>

            </form>
        </div>

    </div>
</div>
@endsection

<script>
function togglePassword() {
    const passwordInput = document.getElementById("password");
    const icon = document.getElementById("togglePasswordIcon");

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        // icon.classList.remove("fa-eye");
        // icon.classList.add("fa-eye-slash");
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    } else {
        passwordInput.type = "password";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    }
}
</script>