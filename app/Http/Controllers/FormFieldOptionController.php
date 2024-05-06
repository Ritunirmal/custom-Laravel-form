<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DataTables;
use App\Models\CustomFormField;
use App\Models\CustomFormFieldOption;
class FormFieldOptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function FormFieldOptions(Request $request)
    {
        if ($request->ajax()) {
            $data = CustomFormField::with('options')->whereNotIn('type', ['text','textarea','email','number' ,'checkbox','date'])->get();


           
            return Datatables::of($data)
            
                ->addIndexColumn()
                ->addColumn('option_data', function ($row) {
                    $options = $row->options->pluck('value')->implode(', '); // Concatenate option values
                    return $options;
                })
                ->addColumn('action', function ($row) {
                    $editBtn = '<a href="/admin/form-field-options/' . $row['id'] . '/edit" class="edit btn btn-primary btn-sm">Edit</a>';
    
                    return $editBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
          
        return view('Admin.FormFieldOption.index');
    }
   
    public function FormFieldOptionsCreate()
    {
        $data = CustomFormField::whereNotIn('type', ['text','textarea','email','number' ,'checkbox','date'])->get();

        return view('Admin.FormFieldOption.create',compact('data'));
    }
    public function FormFieldOptionsSave(Request $request)
    {
    // dd($request->all());
    $validatedData = $request->validate([
        'parentField' => 'required|exists:custom_form_fields,id',
        'option_value.*' => 'required',
    ]);
    $parentFieldId = $validatedData['parentField'];
    $optionValues = $validatedData['option_value'];

    foreach ($optionValues as $optionValue) {
        $option = new CustomFormFieldOption();
        $option->field_id = $parentFieldId;
        $option->value = $optionValue;
        $option->save();
    }
    return redirect()->back()->with('success', 'Options saved successfully.');
    }
    public function FormFieldOptionsEdit($id)
    {
        $data = CustomFormField::where('id',$id)->first();
        $formField = CustomFormFieldOption::where('field_id',$id)->get();
        
        return view('Admin.FormFieldOption.edit', compact('formField','data'));
    }
    public function FormFieldOptionsUpdate(Request $request)
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
            // Update existing option
            $option = CustomFormFieldOption::find($optionIds[$key]);
            $option->value = $optionValue;
            $option->save();
        } else {
            // Add new option
            $option = new CustomFormFieldOption();
            $option->field_id = $parentFieldId;
            $option->value = $optionValue;
            $option->save();
        }
    }
    $optionsToDelete = CustomFormFieldOption::where('field_id', $parentFieldId)
    ->whereNotIn('id', $optionIds)
    ->delete();
    return redirect()->back()->with('success', 'Options saved successfully.');
}

}
