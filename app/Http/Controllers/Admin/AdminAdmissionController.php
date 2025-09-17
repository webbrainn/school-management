<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Admission;
use Exception;
use Carbon\Carbon;

class AdminAdmissionController extends Controller
{
    
public function index(Request $request)
{
    $query = $request->get('search');
    $admissions = Admission::query();

    if ($query) {
        $admissions->where('admission_no', $query)
                   ->orWhere('student_name', 'LIKE', "%{$query}%");
    } 

       $admissions = Admission::all();
    return view('admin.admission.index', compact('admissions'));
}

public function search(Request $request)
{
    $query = $request->get('search');

    $results = Admission::where('student_name', 'LIKE', "%{$query}%")
        ->orWhere('admission_no', 'LIKE', "%{$query}%")
        ->limit(10)
        ->get(['id', 'student_name', 'admission_no']);

    return response()->json($results);
}

    public function create()
{
    try {
        // Generate Serial No.
        $latestSerial = Admission::max('serial_no');
        $serialNo = 'S' . ($latestSerial ? (int) filter_var($latestSerial, FILTER_SANITIZE_NUMBER_INT) + 1 : 1001);

        // Generate Registration No.
        $latestReg = Admission::max('registration_no');
        $registrationNo = 'R' . ($latestReg ? (int) filter_var($latestReg, FILTER_SANITIZE_NUMBER_INT) + 1 : 2001);

        // Generate Admission No.
        $latestAdmission = Admission::max('admission_no');
        $admissionNo = 'A' . ($latestAdmission ? (int) filter_var($latestAdmission, FILTER_SANITIZE_NUMBER_INT) + 1 : 3001);

        return view('admin.admission.create', compact('serialNo', 'registrationNo', 'admissionNo'));
    } catch (\Exception $e) {
        return back()->with('error', 'Failed to open create form: ' . $e->getMessage());
    }
}


    // Store new admission
    public function store(Request $request)
{
    $messages = [
        'dob.before' => 'The student must be at least 3 years old.',
        'mobile_no.digits' => 'The mobile number must be exactly 10 digits.',
        'whatsapp_no.digits' => 'The WhatsApp number must be exactly 10 digits.',
        'email.regex' => 'The email must end with .com.',
        'adhaar_no.digits' => 'The Aadhaar number must be exactly 12 digits.',
        'imageUpload.max' => 'The profile image must not be larger than 2MB.',
        'aadhaar_card.max' => 'The Aadhaar card file must not be larger than 2MB.',
    ];

    $validator = Validator::make($request->all(), [
        'serial_no' => 'required|string|unique:admissions',
        'registration_no' => 'required|string|unique:admissions',
        'admission_no' => 'required|string|unique:admissions',
        'session' => 'required|string',
        'imageUpload' => 'required|mimes:jpeg,png,jpg|max:2048',

        'child_relation' => 'required|string',
        'student_name_consent' => 'required|string',
        'class_name_consent' => 'required|string',
        'student_type' => 'required|string',

        'student_name' => 'required|string|max:255',
        'mobile_no' => 'required|string|digits:10|unique:admissions',
        'applying_for_class' => 'required|string|max:255',
        'dob' => ['required', 'date', 'before:' . Carbon::now()->subYears(3)->toDateString()],
        'gender' => 'required|string',
        'only_child' => 'required|string',
        'adhaar_no' => 'required|unique:admissions|digits:12',
        'email' => ['required', 'email', 'regex:/^[^@\s]+@[^@\s]+\.(com)$/i', 'unique:students,email',],

        'father_name' => 'required|string|max:255',
        'father_qualification' => 'required|string|max:255',
        'father_occupation' => 'required|string|max:255',

        'mother_name' => 'required|string|max:255',
        'mother_qualification' => 'required|string|max:255',
        'mother_occupation' => 'required|string|max:255',

        'address' => 'required|string',
        'whatsapp_no' => 'required|string|digits:10|unique:admissions',

        'guardian_name' => 'required|string|max:255',
        'guardian_relation' => 'required|string|max:255',

        'nationality' => 'required|string|max:100',
        'religion' => 'required|string|max:100',
        'weight' => 'required|string|max:10',
        'blood_group' => 'required|string|max:5',
        'category' => 'required|string|max:50',

        'last_exam_class' => 'required|string|max:255',
        'last_exam_school' => 'required|string|max:255',
        'last_exam_year' => 'required|numeric|digits:4',
        'last_exam_marks' => 'required|string|max:255',

        'admitted_to_class' => 'required|string|max:255',
        'admission_date' => 'required|date',
        'language_subject' => 'required|string|max:255',
        'subjects_offered' => 'required|string',

        'aadhaar_card' => 'required|mimes:jpeg,png,jpg,pdf|max:2048',
    ], $messages);

    if ($validator->fails()) {
        return back()->withErrors($validator)->withInput();
    }

    try {
        $data = $request->except(['imageUpload', 'aadhaar_card']);

        // Handle profile image upload
        if ($request->hasFile('imageUpload')) {
            $image = $request->file('imageUpload');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/admissions'), $imageName);
            $data['imageUpload'] = 'uploads/admissions/' . $imageName;
        }

        // Handle Aadhaar card upload
        if ($request->hasFile('aadhaar_card')) {
            $aadhaar = $request->file('aadhaar_card');
            $aadhaarName = time() . '_' . $aadhaar->getClientOriginalName();
            $aadhaar->move(public_path('uploads/admissions/aadhar'), $aadhaarName);
            $data['aadhaar_card'] = 'uploads/admissions/aadhar/' . $aadhaarName;
        }

        Admission::create($data);

        return redirect()->route('admission.index')->with('success', 'Admission created successfully.');
    } catch (\Exception $e) {
        return back()->withInput()->with('error', 'Failed to create admission: ' . $e->getMessage());
    }
}

    // Show edit form
    public function edit($id)
    {
        try {
            $admission = Admission::findOrFail($id);
            return view('admin.admission.edit', compact('admission'));
        } catch (Exception $e) {
            return back()->with('error', 'Failed to find admission record: ' . $e->getMessage());
        }
    }

    // Update admission
    public function update(Request $request, $id)
{
    $messages = [
        'dob.before' => 'The student must be at least 3 years old.',
        'mobile_no.digits' => 'The mobile number must be exactly 10 digits.',
        'whatsapp_no.digits' => 'The WhatsApp number must be exactly 10 digits.',
        'email.regex' => 'The email must end with .com.',
        'adhaar_no.digits' => 'The Aadhaar number must be exactly 12 digits.',
        'imageUpload.max' => 'The profile image must not be larger than 2MB.',
        'aadhaar_card.max' => 'The Aadhaar card file must not be larger than 2MB.',
    ];

    $admission = Admission::findOrFail($id);
    $validator = Validator::make($request->all(), [
        'serial_no' => 'required|string|unique:admissions,serial_no,' . $admission->id,
        'registration_no' => 'required|string|unique:admissions,registration_no,' . $admission->id,
        'admission_no' => 'required|string|unique:admissions,admission_no,' . $admission->id,
        'session' => 'nullable|string',
        'imageUpload' => 'nullable|mimes:jpeg,png,jpg|max:2048',

        'child_relation' => 'nullable|string',
        'student_name_consent' => 'nullable|string',
        'class_name_consent' => 'nullable|string',
        'student_type' => 'nullable|string',

        'student_name' => 'nullable|string|max:255',
        'mobile_no' => 'nullable|string|digits:10|unique:admissions,mobile_no,' . $admission->id . '|max:15',
        'applying_for_class' => 'nullable|string|max:255',
        'dob' => ['required', 'date', 'before:' . Carbon::now()->subYears(3)->toDateString()],
        'gender' => 'nullable|string',
        'only_child' => 'nullable|string',
        'adhaar_no' => 'nullable|digits:12|unique:admissions,adhaar_no,' . $admission->id,
     // 'email' => 'nullable|email|unique:admissions,email,' . $admission->id . '|max:255',
        'email' => ['required', 'email', 'regex:/^[^@\s]+@[^@\s]+\.(com)$/i', 'unique:students,email',],

        'father_name' => 'nullable|string|max:255',
        'father_qualification' => 'nullable|string|max:255',
        'father_occupation' => 'nullable|string|max:255',

        'mother_name' => 'nullable|string|max:255',
        'mother_qualification' => 'nullable|string|max:255',
        'mother_occupation' => 'nullable|string|max:255',

        'address' => 'nullable|string',
        'whatsapp_no' => 'nullable|string|digits:10|unique:admissions,whatsapp_no,' . $admission->id . '|max:15',

        'guardian_name' => 'nullable|string|max:255',
        'guardian_relation' => 'nullable|string|max:255',

        'nationality' => 'nullable|string|max:100',
        'religion' => 'nullable|string|max:100',
        'weight' => 'nullable|string|max:10',
        'blood_group' => 'nullable|string|max:5',
        'category' => 'nullable|string|max:50',

        'last_exam_class' => 'nullable|string|max:255',
        'last_exam_school' => 'nullable|string|max:255',
        'last_exam_year' => 'nullable|numeric|digits:4',
        'last_exam_marks' => 'nullable|string|max:255',

        'admitted_to_class' => 'nullable|string|max:255',
        'admission_date' => 'nullable|date',
        'language_subject' => 'nullable|string|max:255',
        'subjects_offered' => 'nullable|string',

        'aadhaar_card' => 'nullable|mimes:jpeg,png,jpg,pdf|max:2048',
        'status' => 'nullable|in:Pending,Approved',
    ]);

    if ($validator->fails()) {
        return back()->withErrors($validator)->withInput();
    }

    try {
        $data = $request->except(['imageUpload', 'aadhaar_card']);

        // Handle profile image upload
        if ($request->hasFile('imageUpload')) {
            $image = $request->file('imageUpload');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/admissions'), $imageName);
            $data['imageUpload'] = 'uploads/admissions/' . $imageName;

            // delete the old image if exists
            if ($admission->imageUpload && file_exists(public_path($admission->imageUpload))) {
                unlink(public_path($admission->imageUpload));
            }
        }

        // Handle Aadhaar card upload
        if ($request->hasFile('aadhaar_card')) {
            $aadhaar = $request->file('aadhaar_card');
            $aadhaarName = time() . '_' . $aadhaar->getClientOriginalName();
            $aadhaar->move(public_path('uploads/admissions/aadhar'), $aadhaarName);
            $data['aadhaar_card'] = 'uploads/admissions/aadhar/' . $aadhaarName;

        // delete the old Aadhaar file if exists
        if ($admission->adhaar_card && file_exists(public_path($admission->adhaar_card))) {
                unlink(public_path($admission->adhaar_card));
            }
        }

        $admission->update($data);

        return redirect()->route('admission.index')->with('success', 'Admission updated successfully.');
    } catch (\Exception $e) {
        return back()->withInput()->with('error', 'Failed to update admission: ' . $e->getMessage());
    }
}

public function toggleStatus(Request $request)
{
    $admission = Admission::find($request->id);

    if ($admission) {
        $admission->status = $admission->status === 'Approved' ? 'Pending' : 'Approved';
        $admission->save();

        return response()->json([
            'success' => true,
            'status' => $admission->status
        ]);
    }

    return response()->json(['success' => false]);
}

    // Delete admission
    public function destroy($id)
    {
        try {
            $admission = Admission::findOrFail($id);
            $admission->delete();

            return back()->with('success', 'Admission deleted successfully.');
        } catch (Exception $e) {
            return back()->with('error', 'Failed to delete admission: ' . $e->getMessage());
        }
    }
}