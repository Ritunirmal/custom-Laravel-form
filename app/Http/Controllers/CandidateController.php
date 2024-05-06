<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomFormField;
use App\Models\CustomFormFieldOption;
use App\Models\FieldOptionControl;
use App\Models\UserRegistrationField;
use App\Models\UserBasicDetailsField;
use App\Models\BasicDetails;
use App\Models\BasicDetailsControl;
use Illuminate\Support\Facades\Auth;
use App\Models\Qualification;
use App\Models\DropdownOption;
use App\Models\UserQualification;
use App\Models\UserQualificationCheckbox;
use App\Models\UserDocument;
use App\Models\BirthYear;
use App\Models\Experience;
use App\Models\ExperienceForm;
use Illuminate\Support\Facades\Validator;
use DataTables;
use Razorpay\Api\Api;
use App\Models\Payment;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use DateTime;
use DB;
class CandidateController extends Controller
{
    protected $razorpay;

    
    public function __construct()
    {
        $this->middleware('auth');
        $this->razorpay = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
    }
    public function index()
    {
        $customFormFields = CustomFormField::with('notes')->orderBy('sort_order')->get();
        $dob = BirthYear::first();
        $existingUser = UserRegistrationField::where('user_id', Auth::user()->id)->first();
        if($existingUser)
       
        {
            return redirect()->route('candidate.registration');
        }
        else{
            return view('Candidate.home.index' ,compact('customFormFields','dob'));
           
        }
        // dd($dob);
       
    }
    public function getDependentFieldData(Request $request)
{
    $fieldId = $request->input('field_id');
    $dependentFieldData = FieldOptionControl::where('option_id', $fieldId)->get();
    
    if ($dependentFieldData->isNotEmpty()) {
        $dependentOptions = [];

        foreach ($dependentFieldData as $data) {
            $dependentOptionId = $data->dependent_option_id;
            $dependentFieldId = $data->dependent_field_id;

            // Initialize the dependent option ID if it's not already in the array
            if (!isset($dependentOptions[$data->id])) {
                $dependentOptions[$data->id] = [
                    'disable_field' => false,
                    'show_options' => false,
                    'dependent_field'=>$dependentFieldId,
                    'dependent_options'=>$dependentOptionId,
                ];
            }

            // Update the disable_field and show_options settings for the current dependent option ID
            if ($data->disable_field) {
                $dependentOptions[$data->id]['disable_field'] = true;
            }
            if ($data->show_options) {
                $dependentOptions[$data->id]['show_options'] = true;
            }
            
        }

        return response()->json(['data' => $dependentOptions]);
    }

    return response()->json(['error' => 'Data not found'], 404);
}
public function submitFormOne(Request $request)
{
    
    $existingUser = UserRegistrationField::where('user_id', Auth::user()->id)->first();
    if ($existingUser) {
        // User already exists, handle accordingly
        return redirect()->back()->with('error', 'User already exists!');
    }
    Validator::extend('check_category_for_non_up_domicile', function ($attribute, $value, $parameters, $validator) {
        if ($validator->getData()['are_you_domicile_of_uttar_pradesh'] !== 'Yes' && $value !== 'Unreserved (UR)') {
            return false;
        }
        return true;
    });
    Validator::extend('check_age_for_category', function ($attribute, $value, $parameters, $validator) {
        $category = $validator->getData()['category'];
        $ageInYears = $dob = $validator->getData()['year'];
       
        // Define allowable age limits based on recruitment type and category
        $allowableAgeLimits = [
            'Unreserved (UR)' => 40,
            'Other Backward Classes(Non Creamy Layer) (OBC)' => 45,
            'Scheduled Caste (SC)' => 45,
            'Scheduled Tribes (ST)' => 45,
            'Economically Weaker Sections (EWS)' => 40,
        ];
        $data = $validator->getData();
        if (isset($data['are_you_domicile_of_uttar_pradesh']) && $data['are_you_domicile_of_uttar_pradesh'] !== 'No' &&  $data['are_you_domicile_of_uttar_pradesh'] === 'Yes') {
            // Add 5 years for 'Unreserved (UR)' category
            if ($category === 'Unreserved (UR)') {
                $allowableAgeLimits['Unreserved (UR)'] += 5;
            }
            // Add 10 years for 'OBC', 'SC', 'ST' categories
            elseif (in_array($category, ['Other Backward Classes(Non Creamy Layer) (OBC)', 'Scheduled Caste (SC)', 'Scheduled Tribes (ST)'])) {
                $allowableAgeLimits[$category] += 10;
            }
        }
        if (isset($data['are_you_an_exservicemen']) && $data['are_you_an_exservicemen'] === 'Yes') {
           
           $addExtra=$validator->getData()['period_of_service_in_defence'];
           $allowableAgeLimits[$category] += $addExtra;
           $allowableAgeLimits[$category] += 3;
        //  
         
            if (55 > $allowableAgeLimits[$category]) {
                $allowableAgeLimits[$category] += 15;   
              
            }
            else{
                $allowableAgeLimits[$category] = $allowableAgeLimits[$category];
                
            }
            
        }
    
        // Check if age limit is valid based on category and recruitment type
        if ($ageInYears > $allowableAgeLimits[$category]) {
            // Age limit check failed
            return false;
        }
  
        return true;
    
    });
 
    $request->validate([
        'recruitment_type' => 'required',
        'post_applied_for' => 'required',
        'name' => 'required', 
        'email' => 'required', 
        'mobile' => 'required', 
        // 'alternate_mobile' => 'required', 
        'are_you_domicile_of_uttar_pradesh' => 'required', 
        'aadhar_number' => 'required|size:12', 
        'gender' => 'required', 
        'nationality' => 'required', 
        'are_you_a_person_with_benchmark_disabilities' => $request->input('are_you_domicile_of_uttar_pradesh') == 'Yes' ? 'required' : '',
        'category' => [
            'required',
            'check_category_for_non_up_domicile',
            'check_age_for_category', // Using the custom rule for category validation
        ], 
        'dob' => 'required|date_format:d-m-Y', 
        'undertaking' => 'required', 
        'are_you_an_exservicemen' => 'required', 
        'discharge_certificate_no' => $request->input('are_you_an_exservicemen') == 'Yes' ? 'required' : '',
        'date_of_issue_exserviceman' => $request->input('are_you_an_exservicemen') == 'Yes' ? 'required' : '',
        'period_of_service_in_defence' => $request->input('are_you_an_exservicemen') == 'Yes' ? 'required' : '',
        'dependent_of_freedom_fighter' => 'required', 
        //  'year'=>'required',
        //  'month'=>'required',
        //  'day'=>'required',
    ], [
        'category.check_category_for_non_up_domicile' => 'When you are not a domicile of Uttar Pradesh, the category must be Unreserved (UR).',
        'category.check_age_for_category' => 'The age must be within the allowable limits for the selected category',

    ]);
    $dob = Carbon::createFromFormat('d-m-Y', $request->dob)->format('Y-m-d');
    if ($request->input('are_you_a_person_with_benchmark_disabilities') == 'Yes') {
        $fee = 0; // Set fee amount to 0 for all categories if applicant has a disability
    } else {
        // Fee calculation based on category if no disability
        if ($request->category == 'Unreserved (UR)') {
            $fee = 1180;
        } else if ($request->category == 'Other Backward Classes(Non Creamy Layer) (OBC)') {
            $fee = 1180;
        } else if ($request->category == 'Scheduled Caste (SC)') {
            $fee = 708;
        } else if ($request->category == 'Scheduled Tribes (ST)') {
            $fee = 708;
        } else if ($request->category == 'Economically Weaker Sections (EWS)') {
            $fee = 1180;
        }
    }
    // dd($fee);
 if($request->undertaking == 'on'){
$undertaking=1;
 }else{
    $undertaking=0; 
 }
    $applicationForm = new UserRegistrationField();
    $applicationForm->user_id =Auth::user()->id;
    $applicationForm->recruitment_type = $request->recruitment_type;
    $applicationForm->post_applied_for = $request->post_applied_for;
    $applicationForm->name = $request->name;
    $applicationForm->email = Auth::user()->email;
    $applicationForm->mobile = Auth::user()->mobile_number;
    $applicationForm->alternate_mobile = $request->alternate_mobile;
    $applicationForm->are_you_domicile_of_uttar_pradesh = $request->are_you_domicile_of_uttar_pradesh;
    $applicationForm->aadhar_number = $request->aadhar_number;
    $applicationForm->gender = $request->gender;
    $applicationForm->nationality = $request->nationality;
    $applicationForm->are_you_an_exservicemen = $request->are_you_an_exservicemen;
    $applicationForm->discharge_certificate_no = $request->discharge_certificate_no;
    $applicationForm->date_of_issue_exserviceman = $request->date_of_issue_exserviceman;
    $applicationForm->period_of_service_in_defence = $request->period_of_service_in_defence;
    $applicationForm->dependent_of_freedom_fighter = $request->dependent_of_freedom_fighter;
    $applicationForm->are_you_a_person_with_benchmark_disabilities = $request->are_you_a_person_with_benchmark_disabilities;
    $applicationForm->category = $request->category;
    $applicationForm->year = $request->year;
    $applicationForm->month = $request->month;
    $applicationForm->day = $request->day;
    $applicationForm->dob = $dob;
    $applicationForm->undertaking = $undertaking;
    $applicationForm->fee = $fee;
    $applicationForm->status = 'Unpaid';
    $applicationForm->save();
    if ($applicationForm) {
        $photo = new UserDocument();
        $photo->user_id = Auth::user()->id;
        $photo->document_name = 'photo'; // Change this according to your needs
        $photo->mandatory = true;
        $photo->name = 'Upload Photo';
        $photo->span = '(Only jpeg / jpg / png , Max 200 KB, Width/Height - Min 150px Max 200px)';
        $photo->save();

        $signature = new UserDocument();
        $signature->user_id = Auth::user()->id;
        $signature->document_name = 'signature'; // Change this according to your needs
        $signature->mandatory = true;
        $signature->name = 'Upload Signature';
        $signature->span = 'Only jpeg / jpg / png, Max 200 KB, Width/Height - Min 150px Max 50px)';
        $signature->save();

        $dateOfBirth = new UserDocument();
        $dateOfBirth->user_id = Auth::user()->id;
        $dateOfBirth->document_name = 'proof_of_date_of_birth'; // Change this according to your needs
        $dateOfBirth->mandatory = true;
        $dateOfBirth->name = 'Upload Proof of Date of Birth';
        $dateOfBirth->span = '(Only PDF, Maximum 2 MB)';
        $dateOfBirth->save();

        $noc = new UserDocument();
        $noc->user_id = Auth::user()->id;
        $noc->document_name = 'noc'; // Change this according to your needs
        $noc->mandatory = false;
        $noc->name = 'Upload No Objection Certificate (NOC) Certificate';
        $noc->span = '(Only PDF, Maximum 2 MB)';
        $noc->save();
    }
    if ($request->are_you_domicile_of_uttar_pradesh == 'Yes') {
        $domicile = new UserDocument();
        $domicile->user_id = Auth::user()->id;
        $domicile->document_name = 'are_you_domicile_of_uttar_pradesh'; // Change this according to your needs
        $domicile->mandatory = true;
        $domicile->name = 'Upload Domicile of Uttar Pradesh Certificate';
        $domicile->span = '(Only PDF, Maximum 2 MB)';
        $domicile->save();
    }
    if ($request->are_you_a_person_with_benchmark_disabilities == 'Yes') {
        $disabilities = new UserDocument();
        $disabilities->user_id = Auth::user()->id;
        $disabilities->document_name = 'are_you_a_person_with_benchmark_disabilities'; // Change this according to your needs
        $disabilities->mandatory = true;
        $disabilities->name = 'Upload Disabilities Certificate';
        $disabilities->span = '(Only PDF, Maximum 2 MB)';
        $disabilities->save();
    }
    if ($request->are_you_an_exservicemen == 'Yes') {
        $exservicemen  = new UserDocument();
        $exservicemen ->user_id = Auth::user()->id;
        $exservicemen ->document_name = 'are_you_an_exservicemen'; // Change this according to your needs
        $exservicemen->mandatory = true;
        $exservicemen->name = 'Upload Ex-Servicemen Certificate';
        $exservicemen->span = '(Only PDF, Maximum 2 MB)';
        $exservicemen ->save();
    }
    if ($request->category !== 'Unreserved (UR)') {
        $exservicemen  = new UserDocument();
        $exservicemen ->user_id = Auth::user()->id;
        $exservicemen ->document_name = 'category'; // Change this according to your needs
        $exservicemen->mandatory = true;
        $exservicemen->name = 'Upload Category Certificate';
        $exservicemen->span = '(Only PDF, Maximum 2 MB)';
        $exservicemen ->save();
    }
    if ($request->dependent_of_freedom_fighter == 'Yes') {
        $exservicemen  = new UserDocument();
        $exservicemen ->user_id = Auth::user()->id;
        $exservicemen ->document_name = 'dependent_of_freedom_fighter'; // Change this according to your needs
        $exservicemen->mandatory = true;
        $exservicemen->name = 'Upload CDependent of Freedom-Fighter (DFF)';
        $exservicemen->span = '(Only PDF, Maximum 2 MB)';
        $exservicemen ->save();
    }
    // Redirect or perform any other action after successful submission
    return redirect()->back()->with('success', 'Application submitted successfully!');
}
public function Registration(Request $request)
    {
        $userId=Auth::user()->id;
        $UserData = UserRegistrationField::where('user_id', $userId)->first();
        $customFormFields = CustomFormField::with('notes')->orderBy('sort_order')->get();
        if($UserData)
       
        {
            return view('Candidate.home.registration' ,compact('customFormFields','UserData'));
        }
        else{
            return redirect()->route('candidate.home');
        }
       
    }
    public function BasicDetails()
    {
        $userId=Auth::user()->id;
        $UserData = UserBasicDetailsField::where('user_id', $userId)->first();
        $customFormFields = BasicDetails::with('options')->where('is_active', true)->orderBy('sort_order')->get();
        $exsitingUser= UserRegistrationField::where('user_id', $userId)->first();
        if($exsitingUser)
       
        {
            return view('Candidate.home.basic-details' ,compact('customFormFields','UserData'));
        }
        else{
            return redirect()->route('candidate.home');
        }
     

        
    }
    public function BasicDetailsData(Request $request)
    {
        $fieldId = $request->input('field_id');
        $dependentFieldData = BasicDetailsControl::where('option_id', $fieldId)->get();
        
        if ($dependentFieldData->isNotEmpty()) {
            $dependentOptions = [];
    
            foreach ($dependentFieldData as $data) {
                $dependentOptionId = $data->dependent_option_id;
                $dependentFieldId = $data->dependent_field_id;
    
                // Initialize the dependent option ID if it's not already in the array
                if (!isset($dependentOptions[$dependentOptionId])) {
                    $dependentOptions[$dependentOptionId] = [
                        'disable_field' => false,
                        'show_options' => false,
                        'dependent_field'=>$dependentFieldId,
                    ];
                }
    
                // Update the disable_field and show_options settings for the current dependent option ID
                if ($data->disable_field) {
                    $dependentOptions[$dependentOptionId]['disable_field'] = true;
                }
                if ($data->show_options) {
                    $dependentOptions[$dependentOptionId]['show_options'] = true;
                }
                
            }
    
            return response()->json(['dependent_options' => $dependentOptions]);
        }
    
        return response()->json(['error' => 'Data not found'], 404);
    }
    public function BasicDetailsSave(Request $request)
    {
        // Check if the user already has basic details saved
        $existingUser = UserBasicDetailsField::where('user_id', Auth::user()->id)->first();
        
        // If the user already exists, update the details
        if ($existingUser) {
            // Validate the request for updating
            $request->validate([
                'father_name' => 'required',
                'mother_name' => 'required',
                'marital_status' => 'required', 
                'spouse_name' => $request->input('marital_status') == 'Married' ? 'required' : '',
                'pincode' => 'required', 
                'state' => 'required', 
                'city' => 'required', 
                'permanent_address_one' => 'required', 
                'correspondence_pincode' => 'required', 
                'correspondence_state' => 'required', 
                'correspondence_city' => 'required', 
                'correspondence_address_one' => 'required',
                'undertaking' => 'required', 
            ]);
    
            // Convert checkbox value to boolean
            $undertaking = $request->has('undertaking');
    
            // Update the existing user's details
            $existingUser->update(array_merge($request->all(), ['undertaking' => $undertaking]));
    
            return redirect()->back()->with('success', 'User details updated successfully!');
        }
    
        // If the user doesn't exist, save new details
        $request->validate([
            'father_name' => 'required',
            'mother_name' => 'required',
            'marital_status' => 'required', 
            'spouse_name' => $request->input('marital_status') == 'Married' ? 'required' : '',
            'pincode' => 'required', 
            'state' => 'required', 
            'city' => 'required', 
            'permanent_address_one' => 'required', 
            'correspondence_pincode' => 'required', 
            'correspondence_state' => 'required', 
            'correspondence_city' => 'required', 
            'correspondence_address_one' => 'required',
            'undertaking' => 'required', 
        ]);
    
        // Convert checkbox value to boolean
        $undertaking = $request->has('undertaking');
    
        // Create a new instance of UserBasicDetailsField model
        $applicationForm = new UserBasicDetailsField($request->all());
        $applicationForm->user_id = Auth::user()->id;
        $applicationForm->undertaking = $undertaking;
        $applicationForm->save();
    
        return redirect()->back()->with('success', 'User details saved successfully!');
    }
    

public function EducationalQualifications(Request $request)
    {
        $userId=Auth::user()->id;
        $userData = UserRegistrationField::where('user_id', $userId)->first();
        $postId = CustomFormFieldOption::where('value', $userData->post_applied_for)->first();
        $qualifications = Qualification::with('DropdownOption')->where('post_id', $postId->id)->orderBy('sort_order')->get();
        $qualificationscheckbox = Qualification::with('DropdownOption')->where('post_id', $postId->id)->where('input_type','checkbox')->orderBy('sort_order')->get();
        $UserQualifiation = UserQualification::where('user_id', $userId)->get();
        $UserQualifiationCheckbox = UserQualificationCheckbox::where('user_id', $userId)->get();
        $exsitingUser= UserBasicDetailsField::where('user_id', $userId)->first();
        if($exsitingUser)
       
        {
            return view('Candidate.home.education-qualification',compact('qualifications','UserQualifiation','UserQualifiationCheckbox','qualificationscheckbox'));
        }
        else{
            return redirect()->route('candidate.basic.detail');
        }
    // dd($UserQualifiationCheckbox[0]->checked);
       
    }
   
    public function EducationDocumentUpload(Request $request)
    {
        // Validate the request data
        $request->validate([
            'file' => 'required|mimes:pdf,doc,docx|max:2048', // Adjust maximum file size and allowed file types as needed
            'qualification_id' => 'required|exists:qualifications,id',
        ]);
    
        // Process the uploaded file
        $file = $request->file('file');
        $qualificationId = $request->qualification_id;
        
        // Get the user ID
        $userId = Auth::user()->id;
        
        // Create directory structure based on user ID and qualification ID
        $uploadPath = public_path('uploads/' . $userId . '/education_documents');
        if (!file_exists($uploadPath)) {
            // Create the directory if it does not exist
            mkdir($uploadPath, 0755, true);
        }
    
        // Generate a unique file name
        $fileName = 'education_document_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        
        // Move the uploaded file to the designated directory
        $file->move($uploadPath, $fileName);
    
        // Optionally, you can perform additional processing here, such as saving the file path to the database
    
        return response()->json(['success' => true, 'fileName' => $fileName]);
    }
    public function EducationalQualificationSubmit(Request $request)
{
    // Validate the form data
      
    $request->validate([
        // 'qualification_name.*' => 'required|string',
        'board_name' => 'required|array',
        'board_name.*' => 'required|string',
        'year_of_passing' => 'required|array',
        'year_of_passing.*' => 'required|integer',
        'subject' => 'required|array',
        'subject.*' => 'required|string',
        'percentage' => 'required|array',
        'percentage.*' => 'required|numeric',
        'documents.*' => 'required',
    ]);
// 
    try {
        // Process each qualification submitted in the form
        foreach ($request->qualification_name as $key => $qualificationName) {
           
            $qualificationData = [
                'user_id' => Auth::user()->id,
                'qualification_name' => $request->qualification_name[$key],
                'board_name' => $request->board_name[$key],
                'year_of_passing' => $request->year_of_passing[$key],
                'subject' => $request->subject[$key],
                'percentage' => $request->percentage[$key],
                'document'=> $request->documents[$key]
            ];
            $existingQualification = UserQualification::where('user_id', Auth::user()->id)
            ->where('qualification_name', $request->qualification_name[$key])
            ->first();
            if ($existingQualification) {
                $existingQualification->update($qualificationData);
            } else {
                $qualification = new UserQualification($qualificationData);
                $qualification->save();
            }
              
            
        }
       
      
        $qualificationIds = $request->input('qualification_ids');
        $checkboxQualificationNames = $request->input('qualification_name_for_checkbox');
        $checkboxValues = $request->input('qualification_name_checkbox');
        
        foreach ($checkboxQualificationNames as $key => $checkboxQualificationNames) {
            $qualificationId=$qualificationIds[$key];
            $checkboxQualificationName = $checkboxValues[$qualificationId];
            $isChecked = $checkboxQualificationName === 'on' ? 1 : 0;
            $checkboxQualification = [
                'user_id' => Auth::user()->id,
                'checkbox_name' =>  $checkboxQualificationNames,
                'checked' => $isChecked,
            ];
            $existingcheckbox = UserQualificationCheckbox::where('user_id', Auth::user()->id)
            ->where('checkbox_name', $checkboxQualificationNames)
            ->first();
            if ($existingcheckbox) {
                $existingcheckbox->update($checkboxQualification);
            } else {
                $checkboxdata = new UserQualificationCheckbox($checkboxQualification);
                $checkboxdata->save();
            }
        }
        
      

        // Redirect the user after successful form submission
        return redirect()->back()->with('success', 'Qualifications added successfully.');
    } catch (\Exception $e) {
        // If an exception occurs, handle it appropriately
        return redirect()->back()->with('error', 'An error occurred while adding qualifications. Please try again.');
    }
}
public function ExperienceDetails()
    
    {
        $data = DB::table('experience_forms')
        ->where('user_id', Auth::user()->id)
        ->first();
        $exsitingUser= UserQualification::where('user_id', Auth::user()->id)->first();
        if($exsitingUser)
       
        {
            return view('Candidate.home.experience',compact('data'));
        }
        else{
            return redirect()->route('candidate.educational.qualifications');
        }
       
        
    }
    public function GetExperienceDetails()
    {
        $userId = Auth::id();
        $experiences = Experience::select(['id','organization', 'job_description', 'joining_date', 'leaving_date','years','months','days', 'certificate'])->get();
        return response()->json($experiences);
    }
    public function ExperienceDetailsSubmit(Request $request)
{
    $validator = Validator::make($request->all(), [
        'organization' => 'required|string|max:255',
        'jobDescription' => 'required|string',
        'joiningDate' => 'required|date',
        'leavingDate' => 'nullable|date',
        'certificate' => 'required|file|mimes:pdf,doc,docx|max:2048',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()->all()], 422);
    }

    $file = $request->file('certificate');
    $fileName = 'experience_document_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
    $filePath =  $file->move(public_path('uploads/education'), $fileName);
    $start_date = new DateTime($request->input('joiningDate'));
    $leave_date = new DateTime($request->input('leavingDate'));
    $interval = $start_date->diff($leave_date);
    $total_years = $interval->y;
    $total_months = $interval->m;
    $total_days = $interval->d;
    
    $experience = new Experience();
    $experience->user_id = Auth::user()->id;
    $experience->organization = $request->input('organization');
    $experience->job_description = $request->input('jobDescription');
    $experience->joining_date = $request->input('joiningDate');
    $experience->leaving_date = $request->input('leavingDate');
    $experience->years = $total_years;
    $experience->months = $total_months;
    $experience->days = $total_days;
    $experience->certificate ='uploads/education/'.$fileName;

    
    
    
   



    if($request->has('expeid')) {
        $experience->where('id', $request->input('expeid'))->update($experience->toArray());
    } else {
        $experience->save();
    }

    return response()->json(['success' => true]);
}

    public function GetExperienceDetailsDelete($id){
        try {
            // Find the experience detail by its ID
            $experienceDetail = Experience::findOrFail($id);

            // Delete the experience detail
            $experienceDetail->delete();

            return response()->json(['success' => true, 'message' => 'Experience detail deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete experience detail', 'error' => $e->getMessage()], 500);
        }
    }
    public function GetExperienceDetailsGet($id) {
        try {
            // Find the experience detail by its ID
            $experienceDetail = Experience::findOrFail($id);
    
            return response()->json(['success' => true, 'data' => $experienceDetail]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to retrieve experience detail', 'error' => $e->getMessage()], 500);
        }
    }
    public function ExperienceSubmit(Request $request)
{
    // Validate the form data
    //  dd($request->all());
    $request->validate([
        'employee' => 'required',
        'totalExperience' => $request->input('employee') == 'yes' ? 'required' : '',
    ]);
    // dd($request->all());
    try {
        if($request->input('employee') == 'yes'){
            $ex =$request->input('totalExperience');
        }else{
           $ex = 0;
        }
           $experienceForm = new ExperienceForm();
           
           $experienceForm->user_id = Auth::user()->id;
           $experienceForm->value_stored = $request->input('employee');
           $experienceForm->total_experience = $ex;
          

           $data = DB::table('experience_forms')
           ->where('user_id', Auth::user()->id)
           ->first();
        
           if($data) {
            $experienceForm->where('user_id', Auth::user()->id)->update($experienceForm->toArray());
        } else {
            $experienceForm->save();
        }
        

        // Redirect the user after successful form submission
        return redirect()->route('candidate.documents.upload');
    } catch (\Exception $e) {
        // If an exception occurs, handle it appropriately
        return redirect()->back()->with('error', 'An error occurred while adding qualifications. Please try again.');
    }
}

public function DocumentsUpload(Request $request)
{
    $userId=Auth::user()->id;
    $UserData = UserDocument::where('user_id', $userId)->get();
    $exsitingUser = ExperienceForm::where('user_id', $userId)->first();
    if($exsitingUser)
       
    {
     
    return view('Candidate.home.documents-upload' ,compact('UserData'));
    }
    else{
        return redirect()->route('candidate.experience.details');
    }

}
public function EachDocumentUpload(Request $request)
    {
        $rules = [
            'photo' => 'required|image|mimes:jpeg,jpg,png|max:200|dimensions:min_width=150,min_height=150,max_width=200,max_height=200',
            'signature' => 'required|image|mimes:jpeg,jpg,png|max:200|dimensions:min_width=150,min_height=50,max_width=150,max_height=50',
            'other' => 'required|file|mimes:pdf|max:2048', // Adjust maximum file size and allowed file types as needed
        ];
    
        // Determine the document type based on the document ID
        $documentId = $request->document_name;
        if ($documentId == 'photo') {
            $documentType = 'photo';
        } elseif ($documentId == 'signature') {
            $documentType = 'signature';
        } else {
            $documentType = 'other';
        }
    
        // Validate the request data based on the determined document type
        $validator = Validator::make($request->all(), [
            'file' => $rules[$documentType],
            'document_id' => 'required|exists:user_documents,id',
        ]);
    
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()->all()], 422);
        }
    
        // Process the uploaded file
        $file = $request->file('file');
        $userId = Auth::user()->id;
        $documentTypeDirectory = $documentType === 'other' ? 'certificate' : $documentType; // Use 'certificate' directory for other documents
        $uploadPath = public_path("uploads/{$userId}/documents/{$documentTypeDirectory}");
    
        // Move the uploaded file to the designated directory
        
        $fileName = 'document_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move($uploadPath, $fileName);
        if ($documentType === 'photo' || $documentType === 'signature') {
            $fullUrl = url("uploads/{$userId}/documents/{$documentTypeDirectory}/{$fileName}");
            return response()->json(['success' => true, 'fileUrl' => $fullUrl]);
        }else{
            $fullUrl = url("uploads/{$userId}/documents/{$documentTypeDirectory}/{$fileName}");
            return response()->json(['success' => true, 'fileName' => $fileName,'fileUrl' => $fullUrl]);
        }
        // Optionally, you can perform additional processing here, such as saving the file path to the database
    
       
    }  
    public function DocumentsUploadSuccess(Request $request)
    {
       
        // dd($request->all());
        try {
            foreach ($request->document_id as $key => $documentId) {
               if(($request->document_id[$key]) && ($request->document_value[$key])){
                // dd($request->document_id[$key]);
                UserDocument::where('id',$request->document_id[$key])
                ->where('user_id', Auth::user()->id) 
                ->update(['document' =>$request->document_value[$key]]);
            
               }
         
                
            }
           
            return redirect()->back()->with('success', 'Qualifications added successfully.');
        } catch (\Exception $e) {
            // If an exception occurs, handle it appropriately
            return redirect()->back()->with('error', 'An error occurred while adding qualifications. Please try again.');
        }
    }  
    public function showPaymentForm(Request $request) {
        $userId=Auth::user()->id;
        $User= UserRegistrationField::where('user_id', $userId)->first();
        if($User->fee == 0){
            $payment = Payment::create([
                'user_id' => Auth::user()->id,
                'razorpay_payment_id' => '',
                'razorpay_order_id' => '',
                'razorpay_signature' => '',
                'payment_mode' => '',
                'amount' => 0,
                'status' => 'Exemted',
                // Add other payment data as needed
            ]);
           $UserData = Payment::where('user_id', $userId)->first();
           return view('Candidate.home.successfully-registered',compact('UserData'));
        }else{
            return view('Candidate.home.payment',compact('User'));
        }
     
    }
    public function createPayment(Request $request)
    {
        $userId=Auth::user()->id;
        $UserData = UserRegistrationField::where('user_id', $userId)->first();
        $order = $this->razorpay->order->create([
            'amount' => $UserData->fee * 100, // Amount in paise
            'currency' => 'INR', // Change currency as needed
            'receipt' => uniqid(),
            'payment_capture' => 1, // Auto-capture payment
        ]);

        return response()->json(['order_id' => $order->id]);
    }

    public function paymentCallback(Request $request)
    {
        $payment = $this->razorpay->utility->verifyPaymentSignature([
            'razorpay_signature' => $request->input('razorpay_signature'),
            'razorpay_payment_id' => $request->input('razorpay_payment_id'),
            'razorpay_order_id' => $request->input('razorpay_order_id'),
        ]);

        if ($payment['status'] === 'success') {
            $paymentId = $attributes['razorpay_payment_id'];
            $orderId = $attributes['razorpay_order_id'];
            $amount = $attributes['amount'];
            // Save payment details to your database
            Payment::create([
                'user_id' => Auth::user()->id,
                'payment_id' => $paymentId,
                'order_id' => $orderId,
                'amount' => $amount,
                // Add other relevant fields as needed
            ]);
            // Payment successful, process your logic here
            return response()->json(['success' => true]);
        } else {
            // Payment failed, handle accordingly
            return response()->json(['success' => false]);
        }
    }
    public function paymentDone(Request $request)
    {
        $payment = Payment::create([
            'user_id' => Auth::user()->id,
            'razorpay_payment_id' => $request->input('razorpay_payment_id'),
            'razorpay_order_id' => $request->input('razorpay_order_id'),
            'razorpay_signature' => $request->input('razorpay_signature'),
            'payment_mode' => 'Online',
            'amount' => $request->input('amount'),
            'status' => 'Paid',
            // Add other payment data as needed
        ]);
        UserRegistrationField::where('user_id', Auth::user()->id) 
                ->update(['status' =>'Paid']);
        return response()->json(['success' => true, 'payment' => $payment]);
        
    }
    public function SuccessfullyRegistered(Request $request)
    {
        $userId=Auth::user()->id;
        $UserData = Payment::where('user_id', $userId)->first();
        return view('Candidate.home.successfully-registered',compact('UserData'));
        
    }
    public function FormPreview(Request $request)
    {
        $userId=Auth::user()->id;
        $reg = UserRegistrationField::where('user_id', $userId)->first();
        return view('Candidate.home.form-preview',compact('reg'));
        
    }
}