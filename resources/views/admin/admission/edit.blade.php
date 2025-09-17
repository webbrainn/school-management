@extends('admin.layouts.app')

@section('content')

<div class="container">

    <div class="container-fluid header">
        <div class="row align-items-center">
            <!-- Image Column (4 units) -->
            <div class="col-lg-4 text-center">
                <img src="{{ asset('admin/image/Srswtimata.png') }}" class="img-fluid" alt="Whatsapp" />
            </div>

            <!-- Text Column (8 units) -->
            <div class="col-lg-8">
                <p class="small-text">
                    राहुल शशांक मिश्र ट्रस्ट द्वारा संचालित
                </p>
                <h1>माँ शारदे आवासीय शिक्षण संस्थान</h1>
                <p class="small-text">धरहरवा, औराई, मुजफ्फरपुर</p>
                <h1>बिहार सरकार द्वारा मान्यता प्राप्त</h1>
                <div class="text-center mt-2">
                    <strong>Address:</strong> Village - Dharharwa, Post
                    - Chainpur Dharharwa, P.S - Aurai, Distt -<br />
                    Muzaffarpur, Bihar - 843328<br />
                    Near By: Bank of Baroda, Dharharwa<br />
                </div>
            </div>
        </div>
    </div>

    <div class="contact-details">
        <div class="d-flex align-items-center gap-1">
            <img src="{{ asset('admin/image/whatsapp.png') }}" class="img-fluid" alt="Whatsapp" />
            <h1>9709529785</h1>
        </div>
        <div class="d-flex align-items-center gap-1">
            <img src="{{ asset('admin/image/gmail.png') }}" class="img-fluid" alt="Gmail" />
            <h1>rmssdhaharwa@gmail.com</h1>
        </div>
        <div class="d-flex align-items-center gap-1">
            <img src="{{ asset('admin/image/phone.png') }}" class="img-fluid" alt="Phone" />
            <h1>9709529785</h1>
        </div>
    </div>

    <div class="section-title">PARENT CONSENT FORM FOR APAAR ID</div>

    <form action="{{ route('admission.update', $admission->id) }}" method="POST" enctype="multipart/form-data"
        class="mt-4">
        @csrf
        @method('PUT')

        <div class="section-1 row m-0">
            <div class="col-md-8">
                <div class="row mt-3">
                    <div class="col-md-6">
                        <label class="form-label">Serial No.</label>
                        <input type="text" name="serial_no" class="form-control"
                            value="{{ old('serial_no', $admission->serial_no) }}" readonly/>
                        @error('serial_no') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Registration No.</label>
                        <input type="text" name="registration_no" class="form-control"
                            value="{{ old('registration_no', $admission->registration_no) }}" readonly />
                        @error('registration_no') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <label class="form-label">Admission No.</label>
                        <input type="text" name="admission_no" class="form-control"
                            value="{{ old('admission_no', $admission->admission_no) }}" readonly />
                        @error('admission_no') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Session</label>
                        <input type="text" name="session" class="form-control"
                            value="{{ old('session', $admission->session) }}" />
                        @error('session') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            <!-- <div class="col-md-4 mt-3 d-flex flex-column align-items-center">
                <label class="form-label">Upload Photo</label>
                <div class="upload-box" onclick="document.getElementById('imageUpload').click();"
                    style="cursor: pointer; width: 150px; height: 150px; position: relative; overflow: hidden; border: 2px solid red; background: #eee;">
                    <img id="preview" src="{{ asset('uploads/admissions/' . $admission->imageUpload) }}"
                        alt="Upload Image" style="width: 100%; height: 100%; object-fit: cover;" />
                </div>
                <input type="file" name="imageUpload" id="imageUpload" accept="image/*" onchange="previewImage(event)"
                       hidden />
                @error('imageUpload') <div class="text-danger mt-2">{{ $message }}</div> @enderror
            </div>
        </div> -->

        <div class="col-md-4 mt-3 d-flex flex-column align-items-center">

    <label class="form-label">Upload Photo</label>
    {{-- Upload Box --}}
    <div class="upload-box" onclick="document.getElementById('imageUpload').click();"
         style="cursor: pointer; width: 150px; height: 150px; position: relative; overflow: hidden; border: 2px solid #007bff; background: #f8f9fa; display: flex; align-items: center; justify-content: center;">
        <!-- <img id="preview"
             src="data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='150' height='150'><rect width='150' height='150' fill='%23f8f9fa'/><text x='50%' y='50%' dominant-baseline='middle' text-anchor='middle' fill='%23999' font-size='16'>Upload</text></svg>"
             alt="Upload Image"
             style="width: 140px; height: 140px; object-fit: cover; border: 2px solid #28a745; background: #fff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); display: block;" /> -->

             <img id="preview"
     src="{{ $admission->imageUpload ? asset($admission->imageUpload) : "data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='150' height='150'><rect width='150' height='150' fill='%23f8f9fa'/><text x='50%' y='50%' dominant-baseline='middle' text-anchor='middle' fill='%23999' font-size='16'>Upload</text></svg>" }}"
     alt="Upload Image"
     style="width: 140px; height: 140px; object-fit: cover; border: 2px solid #28a745; background: #fff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); display: block;" />
    </div>
    {{-- File Input --}}
    <input type="file" name="imageUpload" id="imageUpload" accept="image/*" onchange="previewImage(event)" style="display:none;" />

    {{-- Validation Error --}}
    @error('imageUpload')
        <div class="text-danger mt-2">{{ $message }}</div>
    @enderror
</div>

        <div class="mt-5">
            <p>Dear Sir/Madam,</p>
            <p class="parent-consent">
                I request the favour of your kind permission to admit my
                <select name="child_relation" class="select-daughter-son d-inline mx-2" required>
                    <option value="Daughter" {{ $admission->child_relation == 'Daughter' ? 'selected' : '' }}>Daughter
                    </option>
                    <option value="Son" {{ $admission->child_relation == 'Son' ? 'selected' : '' }}>Son</option>
                    <option value="Ward" {{ $admission->child_relation == 'Ward' ? 'selected' : '' }}>Ward</option>
                </select>

                <input type="text" name="student_name_consent" class="d-inline me-2 text-center"
                    value="{{ old('student_name_consent', $admission->student_name_consent) }}" />
                @error('student_name_consent')
            <div class="text-danger">{{ $message }}</div> @enderror

            in Class
            <input type="text" name="class_name_consent" class="d-inline mx-2 mt-3 text-center"
                value="{{ old('class_name_consent', $admission->class_name_consent) }}" />
            @error('class_name_consent') <div class="text-danger">{{ $message }}</div> @enderror

            as a
            <select name="student_type" class="d-inline my-2" required>
                <option value="Day Scholar" {{ $admission->student_type == 'Day Scholar' ? 'selected' : '' }}>Day
                    Scholar</option>
                <option value="Hosteler" {{ $admission->student_type == 'Hosteler' ? 'selected' : '' }}>Hosteler
                </option>
            </select>.
            </p>

            <p>
                I agree to abide by the Rules and Regulations of the
                school at all times.
            </p>
            <p class="text-end my-5">
                <strong>Yours faithfully</strong><br />
                <em>Signature of Parent/Guardian</em>
            </p>

        </div>

        <div class="section-title">FILL UP IN BLOCK LETTER ONLY</div>

        <div class="row mt-3">
            <div class="col-md-6">
                <label class="form-label">Student's Name</label>
                <input type="text" name="student_name" class="form-control"
                    value="{{ old('student_name', $admission->student_name) }}" />
                @error('student_name') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label">Date of Birth</label>
                <!-- <input type="date" name="dob" class="form-control" value="{{ old('dob', optional($admission->dob)->format('Y-m-d')) }}"> -->
                <input type="date" name="dob" class="form-control"
                       value="{{ old('dob', optional($admission->dob)->format('Y-m-d')) }}">
                @error('dob') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="row mt-3">
            <!-- Gender -->
            <div class="col-md-6">
                <label class="form-label">Gender</label>
                <div class="radio-group">
                    <label><input type="radio" name="gender" value="Male"
                            {{ old('gender', $admission->gender ?? '') == 'Male' ? 'checked' : '' }}> Male</label>
                    <label><input type="radio" name="gender" value="Female"
                            {{ old('gender', $admission->gender ?? '') == 'Female' ? 'checked' : '' }}> Female</label>
                </div>
            </div>

            <!-- Only Child -->

            <div class="col-md-6">
                <label class="form-label">Only Child</label>
                <div class="radio-group">
                    <label><input type="radio" name="only_child" value="Yes"
                            {{ old('only_child', $admission->only_child ?? '') == 'Yes' ? 'checked' : '' }}> Yes</label>
                    <label><input type="radio" name="only_child" value="No"
                            {{ old('only_child', $admission->only_child ?? '') == 'No' ? 'checked' : '' }}> No</label>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <label class="form-label">Adhaar No.</label>
                    <input type="text" name="adhaar_no" class="form-control"
                        value="{{ old('adhaar_no', $admission->adhaar_no) }}" />
                    @error('adhaar_no') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Email ID</label>
                    <input type="text" name="email" class="form-control"
                        value="{{ old('email', $admission->email) }}" />
                    @error('email') <div class="text-danger">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-4">
                    <label class="form-label">Father's Name</label>
                    <!-- <input type="text" name="father_name" class="form-control" /> -->
                    <input type="text" name="father_name" class="form-control"
                        value="{{ old('father_name', $admission->father_name) }}" />
                    @error('father_name') <div class="text-danger">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Father's Qualification</label>
                    <!-- <input type="text" name="father_qualification" class="form-control" /> -->
                    <input type="text" name="father_qualification" class="form-control"
                        value="{{ old('father_qualification', $admission->father_qualification) }}" />
                    @error('father_qualification')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Father's Occupation</label>
                    <!-- <input type="text" name="father_occupation" class="form-control" /> -->
                    <input type="text" name="father_occupation" class="form-control"
                        value="{{ old('father_occupation', $admission->father_occupation) }}" />
                    @error('father_occupation')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-4">
                    <label class="form-label">Mother's Name</label>
                    <!-- <input type="text" name="mother_name" class="form-control" /> -->
                    <input type="text" name="mother_name" class="form-control"
                        value="{{ old('mother_name', $admission->mother_name) }}" />
                    @error('mother_name')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Mother's Qualification</label>
                    <!-- <input type="text" name="mother_qualification" class="form-control" /> -->
                    <input type="text" name="mother_qualification" class="form-control"
                        value="{{ old('mother_qualification', $admission->mother_qualification) }}" />
                    @error('mother_qualification')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Mother's Occupation</label>
                    <!-- <input type="text" name="mother_occupation" class="form-control" /> -->
                    <input type="text" name="mother_occupation" class="form-control"
                        value="{{ old('mother_occupation', $admission->mother_occupation) }}" />
                    @error('mother_occupation')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-12">
                    <label class="form-label">Address</label>
                    <!-- <input type="text" name="address" class="form-control" /> -->
                    <input type="text" name="address" class="form-control"
                        value="{{ old('address', $admission->address) }}" />
                    @error('address')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-6">
                    <label class="form-label">WhatsApp No.</label>
                    <!-- <input type="text" name="whatsapp_no" class="form-control" /> -->
                    <input type="text" name="whatsapp_no" class="form-control"
                        value="{{ old('whatsapp_no', $admission->whatsapp_no) }}" />
                    @error('whatsapp_no')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Mobile No.</label>
                    <!-- <input type="text" name="mobile_no" class="form-control" /> -->
                    <input type="text" name="mobile_no" class="form-control"
                        value="{{ old('mobile_no', $admission->mobile_no) }}" />
                    @error('mobile_no')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-6">
                    <label class="form-label">Guardian's Name</label>
                    <!-- <input type="text" name="guardian_name" class="form-control" /> -->
                    <input type="text" name="guardian_name" class="form-control"
                        value="{{ old('guardian_name', $admission->guardian_name) }}" />
                    @error('guardian_name')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Relation</label>
                    <!-- <input type="text" name="guardian_relation" class="form-control" /> -->
                    <input type="text" name="guardian_relation" class="form-control"
                        value="{{ old('guardian_relation', $admission->guardian_relation) }}" />
                    @error('guardian_relation')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <h1 class="general-info-heading mt-4">
                GENERAL INFORMATION (STUDENT)
            </h1>

            <div class="row mt-3">
                <div class="col-md-6">
                    <label class="form-label">Nationality</label>
                    <!-- <input type="text" name="nationality" class="form-control" /> -->
                    <input type="text" name="nationality" class="form-control"
                        value="{{ old('nationality', $admission->nationality) }}" />
                    @error('nationality')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Religion</label>
                    <!-- <input type="text" name="religion" class="form-control" /> -->
                    <input type="text" name="religion" class="form-control"
                        value="{{ old('religion', $admission->religion) }}" />
                    @error('religion')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-4">
                    <label class="form-label">Weight (kg)</label>
                    <!-- <input type="text" name="weight" class="form-control" /> -->
                    <input type="text" name="weight" class="form-control"
                        value="{{ old('weight', $admission->weight) }}" />
                    @error('weight')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Blood Group</label>
                    <!-- <input type="text" name="blood_group" class="form-control" /> -->
                    <input type="text" name="blood_group" class="form-control"
                        value="{{ old('blood_group', $admission->blood_group) }}" />
                    @error('blood_group')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <!-- <label class="form-label">Category</label>
                    <select name="category" class="form-select" required>
                        <option value="">-- Select Category --</option>
                        <option value="General">General</option>
                        <option value="SC">SC</option>
                        <option value="ST">ST</option>
                        <option value="OBC">OBC</option>
                    </select> -->
                    <label class="form-label">Category</label>
                    <select name="category" class="form-select" required>
                        <option value="">-- Select Category --</option>
                        <option value="General" {{ $admission->category == 'General' ? 'selected' : '' }}>General</option>
                        <option value="SC" {{ $admission->category == 'SC' ? 'selected' : '' }}>SC</option>
                        <option value="ST" {{ $admission->category == 'ST' ? 'selected' : '' }}>ST</option>
                        <option value="OBC" {{ $admission->category == 'OBC' ? 'selected' : '' }}>OBC</option>
                    </select>
                </div>
            </div>
            <div class="details-of-last-exam mt-4 px-4">
                <div class="general-info-heading mt-3">
                    Details of Last Exam Passed (to be filled by Candidate)
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <label class="form-label">Class</label>
                        <!-- <input type="text" name="last_exam_class" class="form-control" /> -->
                        <input type="text" name="last_exam_class" class="form-control"
                            value="{{ old('last_exam_class', $admission->last_exam_class) }}" />
                        @error('last_exam_class')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">School Name with Address and Medium</label>
                        <!-- <input type="text" name="last_exam_school" class="form-control" /> -->
                        <input type="text" name="last_exam_school" class="form-control"
                            value="{{ old('last_exam_school', $admission->last_exam_school) }}" />
                        @error('last_exam_school')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row mt-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label">Year of Passing</label>
                        <!-- <input type="text" name="last_exam_year" class="form-control" /> -->
                        <input type="text" name="last_exam_year" class="form-control"
                            value="{{ old('last_exam_year', $admission->last_exam_year) }}" />
                        @error('last_exam_year')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">% marks / CGPA</label>
                        <!-- <input type="text" name="last_exam_marks" class="form-control" /> -->
                        <input type="text" name="last_exam_marks" class="form-control"
                            value="{{ old('last_exam_marks', $admission->last_exam_marks) }}" />
                        @error('last_exam_marks')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-3">
                    <label class="form-label">Applying for Class</label>
                    <!-- <input type="text" name="applying_for_class" class="form-control" /> -->
                    <input type="text" name="applying_for_class" class="form-control"
                        value="{{ old('applying_for_class', $admission->applying_for_class) }}" />
                    @error('applying_for_class')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label">Admitted to Class</label>
                    <!-- <input type="text" name="admitted_to_class" class="form-control" /> -->
                    <input type="text" name="admitted_to_class" class="form-control"
                        value="{{ old('admitted_to_class', $admission->admitted_to_class) }}" />
                    @error('admitted_to_class')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label">on Date: </label>
                    <!-- <input type="date" name="admission_date" class="form-control" /> -->
                    <input type="date" name="admission_date" class="form-control"
                           value="{{ old('admission_date', optional($admission->admission_date)->format('Y-m-d')) }}" />
                    @error('admission_date')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label">For Class IX</label>
                    <select name="language_subject" class="form-select" required>
                        <option value="">-- Select Language --</option>
                        <option value="Hindi" {{ $admission->language_subject == 'Hindi' ? 'selected' : '' }}>Hindi</option>
                        <option value="Sanskrit" {{ $admission->language_subject == 'Sanskrit' ? 'selected' : '' }}>Sanskrit</option>
                        <option value="Urdu" {{ $admission->language_subject == 'Urdu' ? 'selected' : '' }}>Urdu</option>
                    </select>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-12">
                    <label class="form-label">Subject Offered: </label>
                    <!-- <input type="text" name="subjects_offered" class="form-control" /> -->
                    <input type="text" name="subjects_offered" class="form-control"
                        value="{{ old('subjects_offered', $admission->subjects_offered) }}" />
                    @error('subjects_offered')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mt-4">
                <p class="note">
                    <strong>Note:</strong> Kindly Attach Adhaar Card of Father / Mother
                    
                    <label class="form-label">Aadhaar Card</label>
<input type="file" name="aadhaar_card" class="form-control" accept=".jpg,.jpeg,.png,.pdf" />
@error('aadhaar_card')
    <div class="text-danger">{{ $message }}</div>
@enderror

@if($admission->aadhaar_card)
    <div class="mb-2" style="float:left;">
        <a href="{{ asset($admission->aadhaar_card) }}" target="_blank">
            {{ basename($admission->aadhaar_card) }}
        </a>
    </div>
@endif
                </p>
            </div>

            <div class="footer my-4">
                <p class="my-5"><strong>Principal's Signature</strong></p>
            </div>

            <div class="text-center p-4">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {
    window.previewImage = function(event) {
        const reader = new FileReader();
        reader.onload = function() {
            document.getElementById('preview').src = reader.result;
        };
        if (event.target.files.length > 0) {
            reader.readAsDataURL(event.target.files[0]);
        }
    }
});
</script>
@endpush

@endsection