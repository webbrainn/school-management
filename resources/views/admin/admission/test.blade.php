@extends('admin.layouts.app') 

@section('content')
<div class="container mt-5">
    <h3>Test Image Upload Preview</h3>

    <!-- Hidden File Input -->
    <input type="file" name="imageUpload" id="imageUpload" accept="image/*" onchange="previewImage(event)" hidden />

    <!-- Image Preview -->
    <img id="imagePreview"
         src="https://placehold.co/150x150"
         alt="Preview"
         onclick="document.getElementById('imageUpload').click()"
         style="cursor: pointer; border: 1px solid #ccc; padding: 10px; border-radius: 5px;" />
</div>
@endsection

@push('scripts')
<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function () {
            document.getElementById('imagePreview').src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endpush
