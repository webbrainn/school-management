<style>
tr {
    white-space: nowrap;
}

/* th {
    padding: 20px !important;
} */
.dataTables_wrapper .dataTables_info,
.dataTables_wrapper .dataTables_paginate,
.dataTables_wrapper .dataTables_length,
.dataTables_wrapper .dataTables_filter {
    white-space: normal !important;
}

.dataTables_wrapper {
    overflow-x: hidden !important;
}

table.dataTable {
    width: 100% !important;
}

/* Optional: Lock pagination + entries at bottom visually */
.dataTables_paginate,
.dataTables_info {
    padding-top: 20px !important;
}
.toggle-status {
    text-decoration: none;
}
</style>

@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h3 class="mt-4 text-center">Admission List</h3>

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-table me-1"></i> All Admissions</span>

            <!-- search student -->
            <!-- <form action="{{ route('admission.index') }}" method="GET"
                class="d-flex text-center my-2 position-relative">

                <div class="position-relative w-100">
                    <input type="text" id="searchInput" name="search" class="form-control"
                        placeholder="Search by Name or Admission No" autocomplete="off">

                    <div id="suggestionBox" class="list-group shadow"
                        style="position: absolute; top: 100%; z-index: 1000; width: 100%; max-height: 200px; overflow-y: auto; display: none;">
                    </div>
                </div>

                <button type="submit" class="btn btn-sm btn-primary mx-2">Search</button>
            </form> -->
            <!--  -->

            <a href="{{ route('admission.create') }}" class="btn btn-sm btn-success">Add New Admission</a>
        </div>

        <div class="card-body">
            <div class="custom-table">
            <table id="admissionTable" class="table table-bordered table-striped table-hover text-center">
                <thead class="table-dark">
                    <tr>
                        <th>Serial No.</th>
                        <th>Registration No.</th>
                        <th>Admission No.</th>
                        <th>Session</th>
                        <th>Student Image</th>
                        <th>Child Relation</th>
                        <th>Student Type</th>
                        <th>Student Name</th>
                        <th>DOB</th>
                        <th>Gender</th>
                        <th>Only Child</th>
                        <th>Adhaar No</th>
                        <th>Email</th>
                        <th>Father's Name</th>
                        <th>Father's Qualification</th>
                        <th>Father's Occupation</th>
                        <th>Mother's Name</th>
                        <th>Mother's Qualification</th>
                        <th>Mother's Occupation</th>
                        <th>Address</th>
                        <th>Whatsapp No</th>
                        <th>Mobile No</th>
                        <th>Guardian Name</th>
                        <th>Guardian Relation</th>
                        <th>Nationality</th>
                        <th>Religion</th>
                        <th>Weight</th>
                        <th>Blood Group</th>
                        <th>Category</th>
                        <th>Last Exam Class</th>
                        <th>Last Exam School</th>
                        <th>Last Exam Year</th>
                        <th>Last Exam Year</th>
                        <th>Applying For Class</th>
                        <th>Admitted To Class</th>
                        <th>Admission Date</th>
                        <th>Language Subject</th>
                        <th>Subject Offered</th>
                        <th>Adhaar Card</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @forelse($admissions as $admission)
                    <tr>
                        <td>{{ $admission->serial_no }}</td>
                        <td>{{ $admission->registration_no}}</td>
                        <td>{{ $admission->admission_no }}</td>
                        <td>{{ $admission->session}}</td>
                        <!-- <td>{{ $admission->imageUpload}}</td> -->
                        <td>
                            @if($admission->imageUpload)
                            <img src="{{ asset($admission->imageUpload) }}" width="100" alt="Student Image">
                            @else
                            N/A
                            @endif
                        </td>
                        <td>{{ $admission->child_relation}}</td>
                        <td>{{ $admission->student_type}}</td>
                        <td>{{ $admission->student_name}}</td>
                        <td>
                            {{ $admission->dob ? $admission->dob->format('d-m-Y') : 'N/A' }}
                        </td>
                        <td>{{ $admission->gender}}</td>
                        <td>{{ $admission->only_child}}</td>
                        <td>{{ $admission->adhaar_no}}</td>
                        <td>{{ $admission->email}}</td>
                        <td>{{ $admission->father_name}}</td>
                        <td>{{ $admission->father_qualification}}</td>
                        <td>{{ $admission->father_occupation}}</td>
                        <td>{{ $admission->mother_name}}</td>
                        <td>{{ $admission->mother_qualification}}</td>
                        <td>{{ $admission->mother_occupation}}</td>
                        <td>{{ $admission->address}}</td>
                        <td>{{ $admission->whatsapp_no}}</td>
                        <td>{{ $admission->mobile_no}}</td>
                        <td>{{ $admission->guardian_name}}</td>
                        <td>{{ $admission->guardian_relation}}</td>
                        <td>{{ $admission->nationality}}</td>
                        <td>{{ $admission->religion}}</td>
                        <td>{{ $admission->weight}}</td>
                        <td>{{ $admission->blood_group}}</td>
                        <td>{{ $admission->category}}</td>
                        <td>{{ $admission->last_exam_class}}</td>
                        <td>{{ $admission->last_exam_school}}</td>
                        <td>{{ $admission->last_exam_year}}</td>
                        <td>{{ $admission->last_exam_marks}}</td>
                        <td>{{ $admission->applying_for_class}}</td>
                        <td>{{ $admission->admitted_to_class}}</td>
                        <td>{{ $admission->admission_date}}</td>
                        <td>{{ $admission->language_subject}}</td>
                        <td>{{ $admission->subjects_offered}}</td>
                        <td>
                            @if($admission->aadhaar_card)
                            <img src="{{ asset($admission->aadhaar_card) }}" width="100" alt="Adhaar Card">
                            @else
                            N/A
                            @endif
                        </td>  

                        <td>
                            <span
                                class="badge {{ $admission->status === 'Approved' ? 'badge-success' : 'badge-danger' }} toggle-status"
                                data-id="{{ $admission->id }}" data-status="{{ $admission->status }}"
                                style="cursor: pointer;">
                                {{ $admission->status }}
                            </span>
                        </td>

                        <td>
                            <a href="{{ route('admission.edit', $admission->id) }}" class="btn btn-sm btn-outline-warning"
                                title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('admission.destroy', $admission->id) }}" method="POST"
                                class="d-inline"
                                onsubmit="return confirm('Are you sure you want to delete this admission?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" type="submit" title="Delete">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center">No admission records found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
</div>

        </div>
    </div>

</div>

@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    $('#searchInput').on('keyup', function() {
        let query = $(this).val();

        if (query.length >= 1) {
            $.ajax({
                url: "{{ route('admission.search') }}",
                type: "GET",
                data: {
                    search: query
                },
                success: function(data) {
                    let dropdown = $('#suggestionBox');
                    dropdown.empty();

                    if (data.length > 0) {
                        data.forEach(function(item) {
                            dropdown.append(
                                `<a href="#" class="list-group-item list-group-item-action" data-no="${item.admission_no}">
                                        ${item.student_name ?? 'No Name'} (${item.admission_no})
                                     </a>`
                            );
                        });
                        dropdown.show();
                    } else {
                        dropdown.html('<div class="list-group-item">No results found</div>')
                            .show();
                    }
                }
            });
        } else {
            $('#suggestionBox').hide();
        }
    });

    $(document).on('click', '#suggestionBox a', function(e) {
        e.preventDefault();

        // Get admission number
        let admissionNo = $(this).data('no');

        // Set admission number in input field
        $('#searchInput').val(admissionNo);

        // Hide suggestions and submit form
        $('#suggestionBox').hide();
        $(this).closest('form').submit();
    });

    // Hide suggestion box if clicking outside
    $(document).click(function(e) {
        if (!$(e.target).closest('#searchInput, #suggestionBox').length) {
            $('#suggestionBox').hide();
        }
    });
});
</script>

<!-- popup to confirm status updation -->
<script>
$(document).ready(function() {
    $('.toggle-status').click(function() {
        let btn = $(this);
        let admissionId = btn.data('id');
        let currentStatus = btn.data('status');
        let newStatus = currentStatus === 'Approved' ? 'Pending' : 'Approved';

        Swal.fire({
            title: 'Are you sure?',
            text: `Do you want to change the status to "${newStatus}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, change it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Now we make the request only after confirmation
                $.ajax({
                    url: "{{ route('admission.toggleStatus') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: admissionId
                    },
                    success: function(response) {
                        if (response.success) {
                            btn.text(response.status);
                            btn.data('status', response
                                .status); // update the stored status

                            if (response.status === 'Approved') {
                                btn.removeClass('badge-danger').addClass(
                                    'badge-success');
                            } else {
                                btn.removeClass('badge-success').addClass(
                                    'badge-danger');
                            }

                            Swal.fire(
                                'Updated!',
                                `Status changed to "${response.status}".`,
                                'success'
                            );
                        } else {
                            Swal.fire('Error', 'Failed to update status.', 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'Something went wrong.', 'error');
                    }
                });
            }
        });
    });
});
</script>

<script>
$(document).ready(function () {
    $('#admissionTable').DataTable({
        scrollX: true, // enable horizontal scroll
        dom: 'lBfrtip',  // 'l' = length dropdown
        buttons: ['excelHtml5', 'pdfHtml5', 'print'],
        lengthChange: true, // enables the dropdown
        pageLength: 10,     // default selected value
        lengthMenu: [       // values shown in dropdown
            [10, 25, 50, 100, -1], 
            [10, 25, 50, 100, "All"]
        ]
    });
});
</script>


<!-- DataTables CSS -->
<link rel="stylesheet" href="{{ asset('admin/css/jquery.dataTables.min.css') }}">
<link rel="stylesheet" href="{{ asset('admin/css/buttons.dataTables.min.css') }}">

<!-- jQuery -->
<script src="{{ asset('admin/js/jquery-3.5.1.min.js') }}"></script>

<!-- DataTables JS -->
<script src="{{ asset('admin/js/jquery.dataTables.min.js') }}"></script>

<!-- Buttons extension -->
<script src="{{ asset('admin/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('admin/js/jszip.min.js') }}"></script>
<script src="{{ asset('admin/js/pdfmake.min.js') }}"></script>
<script src="{{ asset('admin/js/vfs_fonts.js') }}"></script>
<script src="{{ asset('admin/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('admin/js/buttons.print.min.js') }}"></script>

