<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Qualification;
use App\Models\DropdownOption;
use App\Models\CustomFormField;
use App\Models\CustomFormFieldOption;
use DataTables;
use Illuminate\Support\Facades\Session;
class AdminQualificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function Qualification(Request $request)
    {
        if ($request->ajax()) {
            $data = Qualification::with('CustomFormFieldOption')->get();
           
           
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('post', function ($data) {
                    return $data->CustomFormFieldOption->value;
                })
                ->addColumn('action', function ($row) {
                    $editBtn = '<a href="/admin/qualification/' . $row['id'] . '/edit" class="edit btn btn-primary btn-sm">Edit</a>';
    
                    $deleteBtn = '<button class="deleteField btn btn-danger btn-sm" data-id="' . $row['id'] . '">Delete</button>';
                    
                    
    
                    return $editBtn . ' ' . $deleteBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        } 
          
        return view('Admin.Qualification.index');
    }
    public function QualificationCreate()
    {
        $field = CustomFormField::where('name','post_applied_for')->first();
        $fieldoptions = CustomFormFieldOption::where('field_id',$field->id)->get();
        return view('Admin.Qualification.create',compact('fieldoptions'));
    }
    public function QualificationSave(Request $request)
    {
    //  dd($request->all());
        $request->validate([
            'post_id' => 'required',
            'qualifications_name' => 'required',
            'name' => 'required',
            'input_type' => 'required',
            'sortorder' => 'required',
        ]);
        $showOptions = $request->has('mandatory') ? 1 : 0;
        $formField = Qualification::create([
            'post_id' => $request->input('post_id'),
            'qualifications_name' => $request->input('qualifications_name'),
            'name' => $request->input('name'),
            'input_type' => $request->input('input_type'),
            'sort_order' => $request->input('sortorder'),
            'mandatory' => $showOptions,
        ]);
        Session::flash('success', 'Qualification created successfully!');
        return redirect()->route('admin.qualification.add');
    }
    public function QualificationEdit($id)
    {
        $field = CustomFormField::where('name','post_applied_for')->first();
        $fieldoptions = CustomFormFieldOption::where('field_id',$field->id)->get();
        $qualification = Qualification::where('id',$id)->first();
        return view('admin.qualification.edit', compact('fieldoptions','qualification'));
    }

    public function qualificationEditSave(Request $request)
{
    $request->validate([
        'post_id' => 'required',
        'qualifications_name' => 'required',
        'name' => 'required',
        'input_type' => 'required',
        'sortorder' => 'required',
    ]);
    $showOptions = $request->has('mandatory') ? 1 : 0;
// Update the record based on its ID
Qualification::where('id', $request->input('id'))->update([
    'post_id' => $request->input('post_id'),
    'name' => $request->input('name'),
    'qualifications_name' => $request->input('qualifications_name'),
    'input_type' => $request->input('input_type'),
    'sort_order' => $request->input('sortorder'),
    'mandatory' => $showOptions,
]);

    Session::flash('success', 'Qualification updated successfully!');
    return redirect()->route('admin.qualification');
}
public function QualificationOptions(Request $request)
{
    if ($request->ajax()) {
        $data = Qualification::with('DropdownOption')->whereNotIn('input_type', ['input', 'checkbox'])->get();


       
        return Datatables::of($data)
        
            ->addIndexColumn()
            ->addColumn('option_data', function ($row) {
                $options = $row->DropdownOption->pluck('option')->implode(', '); // Concatenate option values
                return $options;
            })
            ->addColumn('action', function ($row) {
                $editBtn = '<a href="/admin/qualification-options/' . $row['id'] . '/edit" class="edit btn btn-primary btn-sm">Edit</a>';

                return $editBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
      
    return view('Admin.QualificationOptions.index');
}
public function QualificationOptionsCreate()
    {
        $data = Qualification::whereNotIn('input_type', ['input', 'checkbox'])->get();

        return view('Admin.QualificationOptions.create',compact('data'));
    }
    public function qualificationOptionsSave(Request $request)
    {
    // dd($request->all());
    $validatedData = $request->validate([
        'qualification' => 'required|exists:qualifications,id',
        'option_value.*' => 'required',
    ]);
    $qualifications = $validatedData['qualification'];
    $optionValues = $validatedData['option_value'];

    foreach ($optionValues as $optionValue) {
        $option = new DropdownOption();
        $option->qualification_id  = $qualifications;
        $option->option = $optionValue;
        $option->save();
    }
    return redirect()->back()->with('success', 'Qualifications Options saved successfully.');
    }
    public function QualificationOptionsEdit($id)
    {
        $data = Qualification::where('id',$id)->first();
        $formField = DropdownOption::where('qualification_id',$id)->get();
        
        return view('Admin.QualificationOptions.edit', compact('formField','data'));
    }
    public function QualificationOptionsUpdate(Request $request)
{
    $validatedData = $request->validate([
        'qualification' => 'required|exists:qualifications,id',
        'option_id.*' => 'nullable|exists:dropdown_options,id',
        'option_value.*' => 'required|string',
    ]);

    $parentFieldId = $validatedData['qualification'];
    $optionIds = $validatedData['option_id'];
    $optionValues = $validatedData['option_value'];

    foreach ($optionValues as $key => $optionValue) {
        if (isset($optionIds[$key]) && $optionIds[$key]) {
            // Update existing option
            $option = DropdownOption::find($optionIds[$key]);
            $option->option = $optionValue;
            $option->save();
        }
    }
    $optionsToDelete = DropdownOption::where('qualification_id', $parentFieldId)
    ->whereNotIn('id', $optionIds)
    ->delete();
    return redirect()->back()->with('success', 'Options saved successfully.');
}
}
