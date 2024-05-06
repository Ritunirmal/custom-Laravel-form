<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomFormField;
use App\Models\FieldOptionControl;
use App\Models\CustomFormFieldOption;
use Illuminate\Support\Facades\Validator;
use DataTables;
class FormFieldDependentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function FormFieldDependent(Request $request)
    {
        if ($request->ajax()) {
            $options = FieldOptionControl::with(['field', 'dependentField'])->get();


           
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
                return $option->dependentOption->value; // Assuming 'value' is the option value in CustomFormFieldOption
            })
            // ->addColumn('show_options', function ($option) {
            //     return '<input type="checkbox" class="show-option-toggle" data-toggle-id="' . $option->id . '" ' . ($option->show_options ? 'checked' : '') . '>';
            // })
            // ->addColumn('disabled', function ($option) {
            //     return $option->disable_field ? 'Disabled' : 'Enabled';
            // })
            ->addColumn('action', function ($option) {
                $editBtn = '<a href="/admin/form-field-dependent/' . $option['id'] . '/edit" class="edit btn btn-primary btn-sm">Edit</a>';
                $deleteBtn = '<button class="deleteField btn btn-danger btn-sm" data-id="' . $option['id'] . '">Delete</button>';
                return $editBtn . ' ' . $deleteBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
          
        return view('Admin.FormFieldDependent.index');
    }
    public function FormFieldDependentCreate()
    {
        $field = CustomFormField::with('options')->whereNotIn('type', ['checkbox'])->get();
        $fieldoptions = CustomFormFieldOption::with('field')->get();
        return view('Admin.FormFieldDependent.create',compact('field','fieldoptions'));
    }
    public function FormFieldDependentSave(Request $request)
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
        $formField = FieldOptionControl::create([
            'field_id' => $request->input('FieldId'),
            'dependent_field_id' => $request->input('DependentFieldId'),
            'option_id' => $request->input('FieldOptionId'),
            'dependent_option_id' => $request->input('DependentFieldOptionId'),
            'show_options' => $showOptions,
            'disable_field' => $disableField,
        ]);
     
        return redirect()->back()->with('success', 'Dependent saved successfully.');
    }
    public function FormFieldDependentEdit($id)
    {
        $field = CustomFormField::with('options')->get();
        $fieldoptions = CustomFormFieldOption::with('field')->get();
        $data = FieldOptionControl::where('id',$id)->first();
        
        return view('Admin.FormFieldDependent.edit',compact('field','fieldoptions','data'));
    }
  
public function FormFieldDependentEditSave(Request $request)
{
    $request->validate([
        'id' => 'required|exists:field_option_controls,id', // Ensure the ID exists in the database
        'FieldId' => 'required',
        'DependentFieldId' => 'required',
        // Add validation rules for other fields as needed
    ]);

    $showOptions = $request->has('show_hide') ? 1 : 0;
    $disableField = $request->has('disabled') ? 1 : 0;

    // Update the record based on its ID
    FieldOptionControl::where('id', $request->input('id'))->update([
        'field_id' => $request->input('FieldId'),
        'dependent_field_id' => $request->input('DependentFieldId'),
        'option_id' => $request->input('FieldOptionId'),
        'dependent_option_id' => $request->input('DependentFieldOptionId'),
        'show_options' => $showOptions,
        'disable_field' => $disableField,
    ]);

    return redirect()->back()->with('success', 'Dependent updated successfully.');
}
public function FormFieldDependentDelete(Request $request)
{
    // Validate the request
    $validator = Validator::make($request->all(), [
        'id' => 'required|exists:field_option_controls,id',
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()->first()], 422);
    }
    $optionId = $request->input('id');

    $option = FieldOptionControl::find($optionId);
    if ($option) {
        $option->delete();

        return response()->json(['success' => true, 'message' => 'Record deleted successfully']);
    } else {
        return response()->json(['error' => 'Record not found'], 404);
    }
}
    public function FormFieldDependentToggle(Request $request)
    {
        $id = $request->input('id');
        $type = $request->input('type');
        $value = $request->input('value');

         $option = FieldOptionControl::find($id);
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
