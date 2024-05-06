<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use DataTables;
use App\Models\BasicDetails;
use App\Models\BasicDetailsOption;
use App\Models\BasicDetailsControl;
class BasicDetailsController extends Controller
{
    public function basicDetailsFormFieldShow(Request $request)
    {
        if ($request->ajax()) {
            $data = BasicDetails::select('*');
           
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editBtn = '<a href="/admin/basic-details-form-field-show/' . $row['id'] . '/edit" class="edit btn btn-primary btn-sm">Edit</a>';
    
                    $deleteBtn = '<button class="deleteField btn btn-danger btn-sm" data-id="' . $row['id'] . '">Delete</button>';
                    
                    
    
                    return $editBtn . ' ' . $deleteBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
          
        return view('Admin.BasicDetails.index');
    }
    public function create()
    {
     
        return view('Admin.BasicDetails.create');
    }
    public function BasicDetailsFormField(Request $request)
    {
    // dd($request->all());
        $request->validate([
            'name' => 'required|string',
            'type' => 'required',
            'label' => 'required',
            'sortorder' => 'required',
            'required' => 'required|boolean',
            'readonly' => 'required|boolean',
        ]);
   
        $formField = BasicDetails::create([
            'name' => $request->input('name'),
            'type' => $request->input('type'),
            'label' => $request->input('label'),
            'sort_order' => $request->input('sortorder'),
            'required' => $request->input('required'),
            'readonly' => $request->input('readonly'),
            'pattern' => $request->input('pattern'),
            'title' => $request->input('title'),
        ]);
        Session::flash('success', 'Basic Details Form field created successfully!');
        return redirect()->route('admin.basic.details.form.field.show');
    }
    public function BasicDetailsFormFieldEdit($id)
    {
       
        $formField = BasicDetails::findOrFail($id);
        $data = BasicDetails::where('id','!=',$id)->get();
        
        return view('Admin.BasicDetails.edit', compact('formField','data'));
    }

    public function BasicDetailsFormFieldUpdate(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string',
        'type' => 'required',
        'label' => 'required',
        'sort_order' => 'required',
        'required' => 'required|boolean',
        'pattern' =>'nullable',
        'title' => 'nullable',
        'readonly' => 'nullable',
    ]);

    $formField = BasicDetails::findOrFail($id);
    $formField->update($request->all());
    Session::flash('success', 'Basic Deatils Form field updated successfully!');
    return redirect()->route('admin.basic.details.form.field.show');
}
public function BasicDetailsFormFieldDelete(Request $request)
{
    // Validate the request
    $validator = Validator::make($request->all(), [
        'id' => 'required',
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()->first()], 422);
    }
    $optionId = $request->input('id');

    $option = BasicDetails::find($optionId);
    if ($option) {
        $option->delete();

        return response()->json(['success' => true, 'message' => 'Record deleted successfully']);
    } else {
        return response()->json(['error' => 'Record not found'], 404);
    }
}
public function BasicDetailsFormFieldOptions(Request $request)
{
    if ($request->ajax()) {
        $data = BasicDetails::with('options')->whereNotIn('type', ['text','textarea','email','number' ,'checkbox','date'])->get();


       
        return Datatables::of($data)
        
            ->addIndexColumn()
            ->addColumn('option_data', function ($row) {
                $options = $row->options->pluck('value')->implode(', '); // Concatenate option values
                return $options;
            })
            ->addColumn('action', function ($row) {
                $editBtn = '<a href="/admin/basic-details-form-field-options/' . $row['id'] . '/edit" class="edit btn btn-primary btn-sm">Edit</a>';

                return $editBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
      
    return view('Admin.BasicDetailsOption.index');
}

public function BasicDetailsFormFieldOptionsCreate()
{
    $data = BasicDetails::whereNotIn('type', ['text','textarea','email','number' ,'checkbox','date'])->get();

    return view('Admin.BasicDetailsOption.create',compact('data'));
}
public function BasicDetailsFormFieldOptionsSave(Request $request)
{
// dd($request->all());
$validatedData = $request->validate([
    'parentField' => 'required|exists:custom_form_fields,id',
    'option_value.*' => 'required',
]);
$parentFieldId = $validatedData['parentField'];
$optionValues = $validatedData['option_value'];

foreach ($optionValues as $optionValue) {
    $option = new BasicDetailsOption();
    $option->field_id = $parentFieldId;
    $option->value = $optionValue;
    $option->save();
}
return redirect()->back()->with('success', 'Options saved successfully.');
}
public function BasicDetailsFormFieldOptionsEdit($id)
{
    $data = BasicDetails::where('id',$id)->first();
    $formField = BasicDetailsOption::where('field_id',$id)->get();
    
    return view('Admin.BasicDetailsOption.edit', compact('formField','data'));
}
public function BasicDetailsFormFieldOptionsUpdate(Request $request)
{
$validatedData = $request->validate([
    'parentField' => 'required|exists:custom_form_fields,id',
    'option_id.*' => 'nullable|exists:custom_form_field_options,id',
    'option_value.*' => 'required|string|max:255',
]);

$parentFieldId = $validatedData['parentField'];
$optionIds = $validatedData['option_id'];
$optionValues = $validatedData['option_value'];

foreach ($optionValues as $key => $optionValue) {
    if (isset($optionIds[$key]) && $optionIds[$key]) {
        // Update existing BasicDetailsOption
        $option = BasicDetailsOption::find($optionIds[$key]);
        $option->value = $optionValue;
        $option->save();
    } else {
        // Add new option
        $option = new BasicDetailsOption();
        $option->field_id = $parentFieldId;
        $option->value = $optionValue;
        $option->save();
    }
}
$optionsToDelete = BasicDetailsOption::where('field_id', $parentFieldId)
->whereNotIn('id', $optionIds)
->delete();
return redirect()->back()->with('success', 'Options saved successfully.');
}
public function BasicDetailsFormFieldDependent(Request $request)
    {
        if ($request->ajax()) {
            $options = BasicDetailsControl::with(['field', 'dependentField'])->get();


           
            return DataTables::of($options)
            ->addColumn('field', function ($option) {
                return $option->field->label; // Assuming 'name' is the field name in CustomFormField
            })
            ->addColumn('dependent_field', function ($option) {
                return $option->dependentField->label; // Assuming 'name' is the field name in CustomFormField
            })
            ->addColumn('option', function ($option) {
                return $option->fieldOption->value; // Assuming 'value' is the option value in CustomFormFieldOption
            })
            ->addColumn('dependent_option', function ($option) {
                return $option->dependentOption ? $option->dependentOption->value : '';
            })
            
            // ->addColumn('show_options', function ($option) {
            //     return '<input type="checkbox" class="show-option-toggle" data-toggle-id="' . $option->id . '" ' . ($option->show_options ? 'checked' : '') . '>';
            // })
            // ->addColumn('disabled', function ($option) {
            //     return $option->disable_field ? 'Disabled' : 'Enabled';
            // })
            ->addColumn('action', function ($option) {
                $editBtn = '<a href="/admin/basic-details=form-field-dependent/' . $option['id'] . '/edit" class="edit btn btn-primary btn-sm">Edit</a>';
                $deleteBtn = '<button class="deleteField btn btn-danger btn-sm" data-id="' . $option['id'] . '">Delete</button>';
                return $editBtn . ' ' . $deleteBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
          
        return view('Admin.BasicDetailsDepedent.index');
    }
    public function BasicDetailsFormFieldDependentCreate()
    {
        $field = BasicDetails::with('options')->whereNotIn('type', ['checkbox'])->get();
        $fieldoptions = BasicDetailsOption::with('basicDetail')->get();
        return view('Admin.BasicDetailsDepedent.create',compact('field','fieldoptions'));
    }
    public function BasicDetailsFormFieldDependentSave(Request $request)
    {
    //  dd($request->all());
        $request->validate([
            'FieldId' => 'required',
            'DependentFieldId' => 'required',
           
           
        ]);
        $showOptions = 0;
        $disableField = 0;
        
        // Check if 'show_hide' and 'disabled' fields are present in the request
        if ($request->has('show_hide')) {
            $showOptions = 1;
        }
        if ($request->has('disabled')) {
            $disableField = 1;
        }
        $formField = BasicDetailsControl::create([
            'field_id' => $request->input('FieldId'),
            'dependent_field_id' => $request->input('DependentFieldId'),
            'option_id' => $request->input('FieldOptionId'),
            'dependent_option_id' => $request->input('DependentFieldOptionId'),
            'show_options' => $showOptions,
            'disable_field' => $disableField,
        ]);
     
        return redirect()->back()->with('success', 'Dependent saved successfully.');
    }
    public function BasicDetailsFormFieldDependentEdit($id)
    {
        $field = BasicDetails::with('options')->get();
        $fieldoptions = BasicDetailsOption::with('basicDetail')->get();
        $data = BasicDetailsControl::where('id',$id)->first();
        
        return view('Admin.BasicDetailsDepedent.edit',compact('field','fieldoptions','data'));
    }
  
public function BasicDetailsFormFieldDependentEditSave(Request $request)
{
    $request->validate([
        'id' => 'required|exists:basic_details_controls,id', // Ensure the ID exists in the database
        'FieldId' => 'required',
        'DependentFieldId' => 'required',
        // Add validation rules for other fields as needed
    ]);

    $showOptions = $request->has('show_hide') ? 1 : 0;
    $disableField = $request->has('disabled') ? 1 : 0;

    // Update the record based on its ID
    BasicDetailsControl::where('id', $request->input('id'))->update([
        'field_id' => $request->input('FieldId'),
        'dependent_field_id' => $request->input('DependentFieldId'),
        'option_id' => $request->input('FieldOptionId'),
        'dependent_option_id' => $request->input('DependentFieldOptionId'),
        'show_options' => $showOptions,
        'disable_field' => $disableField,
    ]);

    return redirect()->back()->with('success', 'Dependent updated successfully.');
}
public function BasicDetailsFormFieldDependentDelete(Request $request)
{
    // Validate the request
    $validator = Validator::make($request->all(), [
        'id' => 'required|exists:field_option_controls,id',
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()->first()], 422);
    }
    $optionId = $request->input('id');

    $option = BasicDetailsControl::find($optionId);
    if ($option) {
        $option->delete();

        return response()->json(['success' => true, 'message' => 'Record deleted successfully']);
    } else {
        return response()->json(['error' => 'Record not found'], 404);
    }
}
    public function BasicDetailsFormFieldDependentToggle(Request $request)
    {
        $id = $request->input('id');
        $type = $request->input('type');
        $value = $request->input('value');

         $option = BasicDetailsControl::find($id);
         if (!$option) {
            return response()->json(['error' => 'Option not found'], 404);
        }
        if ($type === 'show_options') {
            $option->show_options = $value;
        } elseif ($type === 'disable_field') {
            $option->disable_field = $value;
        } else {
            return response()->json(['error' => 'Invalid toggle type'], 400);
        }
    
        $option->save();
    
        return response()->json(['success' => true]);
    }
}
