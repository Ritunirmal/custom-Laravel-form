<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FieldNote;
use Illuminate\Support\Facades\Validator;
use App\Models\CustomFormField;
use DataTables;


class NoteFormFieldController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function FormFieldDependentNote(Request $request)
    {
        if ($request->ajax()) {
            $data = FieldNote::with('field')->get();
           
           
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('field', function ($data) {
                    return $data->field->label;
                })
                ->addColumn('action', function ($row) {
                    $editBtn = '<a href="/admin/form-field-note/' . $row['id'] . '/edit" class="edit btn btn-primary btn-sm">Edit</a>';
    
                    $deleteBtn = '<button class="deleteField btn btn-danger btn-sm" data-id="' . $row['id'] . '">Delete</button>';
                    
                    
    
                    return $editBtn . ' ' . $deleteBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        } 
          
        return view('Admin.Formfield.note');
    }
    public function FormFieldNoteCreate()
    {
        $field = CustomFormField::with('options')->get();
        return view('Admin.Formfield.note-create',compact('field'));
    }
    public function FormFieldNoteSave(Request $request)
    {
    //  dd($request->all());
        $request->validate([
            'FieldId' => 'required',
            'note' => 'required',
           
           
        ]);

       
        $formField = FieldNote::create([
            'field_id' => $request->input('FieldId'),
            'note' => $request->input('note')
        ]);
     
        return redirect()->back()->with('success', 'Note saved successfully.');
    }
    public function FormFieldNoteEdit($id)
    {
        $field = CustomFormField::with('options')->get();
        $data = FieldNote::where('id',$id)->first();
        
        return view('Admin.Formfield.note-edit',compact('field','data'));
    }
  
public function FormFieldNoteEditSave(Request $request)
{
    $request->validate([
        'id' => 'required', // Ensure the ID exists in the database
        'FieldId' => 'required',
        'note' => 'required',
        // Add validation rules for other fields as needed
    ]);

   

    // Update the record based on its ID
    FieldNote::where('id', $request->input('id'))->update([
        'field_id' => $request->input('FieldId'),
        'note' => $request->input('note'),
    ]);

    return redirect()->back()->with('success', 'Note updated successfully.');
}
public function FormFieldNoteDelete(Request $request)
{
    // Validate the request
    $validator = Validator::make($request->all(), [
        'id' => 'required',
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()->first()], 422);
    }
    $optionId = $request->input('id');

    $option = FieldNote::find($optionId);
    if ($option) {
        $option->delete();

        return response()->json(['success' => true, 'message' => 'Record deleted successfully']);
    } else {
        return response()->json(['error' => 'Record not found'], 404);
    }
}
}
