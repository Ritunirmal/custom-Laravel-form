<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomFormField;
use App\Models\FieldNote;
use App\Models\UserRegistrationField;
use App\Models\CustomFormFieldOption;
use App\Models\FieldOptionControl;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Support\Facades\Session;
use DataTables;
use Carbon\Carbon;
class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
       
        if ($request->ajax()) {
            $data =CustomFormField::where('name','post_applied_for')->with('options')->first();
            $options=$data->options;
            return DataTables::of($options)
            ->addColumn('Post', function ($options) {
                return $options->value; // Assuming 'name' is the field name in CustomFormField
            })
            ->addColumn('Paid', function ($options) {
                $paidData = UserRegistrationField::
                where('post_applied_for', $options->value)
                ->where('status','Paid')
                ->count();
            $paid = '<a href="' . route('admin.paid.data', ['post' => $options->value]) . '" class="edit btn btn-primary btn-sm">'.$paidData.'</a>';

                return $paid;
            })
            ->addColumn('UnPaid', function ($options) {
                $paidData = UserRegistrationField::
                where('status','Unpaid')
                ->where('post_applied_for', $options->value)
                ->count();
                $paid = '<a href="'.route('admin.unpaid.data', ['post' => $options->value]) . '" class="edit btn btn-primary btn-sm">'.$paidData.'</a>';
                return $paid;
            })
          
           
            ->rawColumns(['Paid','UnPaid'])
            ->make(true);
        }

        $currentDate = Carbon::now()->toDateString();
        $userCount = UserRegistrationField::
          whereDate('created_at', $currentDate)
        ->count();
        $paidTodayCount = User::whereHas('payments', function ($query) use ($currentDate) {
            $query->whereIn('status', ['paid', 'Exemted'])
            ->whereDate('created_at', $currentDate);
        })
        ->count();
 
        $paidUsersCount =User::whereHas('payments', function ($query) {
            $query->whereIn('status', ['paid', 'Exemted']);
        })->count();
        $unpaidUsersCount = User::where('role','candidate')->doesntHave('payments')->count();
        return view('Admin.home',compact('userCount','paidTodayCount','paidUsersCount','unpaidUsersCount'));
    }
    public function candidateStatus()
    {
        $currentDate = Carbon::now()->toDateString();
        $userCount = UserRegistrationField::
        whereDate('created_at', $currentDate)
            ->count();
            $paidTodayCount = User::whereHas('payments', function ($query) use ($currentDate) {
                $query->whereIn('status', ['paid', 'Exemted'])
                ->whereDate('created_at', $currentDate);
            })
            ->count();
     
            $paidUsersCount =User::whereHas('payments', function ($query) {
                $query->whereIn('status', ['paid', 'Exemted']);
            })->count();
            $unpaidUsersCount = User::where('role','candidate')->doesntHave('payments')->count();

        // Return the counts as JSON data
        return response()->json([
            'userCount' => $userCount,
            'paidTodayCount' => $paidTodayCount,
            'paidUsersCount' => $paidUsersCount,
            'unpaidUsersCount' => $unpaidUsersCount,
        ]);
    }
    public function FormFieldShow(Request $request)
    {
        if ($request->ajax()) {
            $data = CustomFormField::select('*');
           
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editBtn = '<a href="/admin/form-field-show/' . $row['id'] . '/edit" class="edit btn btn-primary btn-sm">Edit</a>';
    
                    $deleteBtn = '<button class="deleteField btn btn-danger btn-sm" data-id="' . $row['id'] . '">Delete</button>';
                    
                    
    
                    return $editBtn . ' ' . $deleteBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
          
        return view('Admin.Formfield.index');
    }
    public function create()
    {
     
        return view('Admin.Formfield.create');
    }
    public function FormField(Request $request)
    {
    // dd($request->all());
        $request->validate([
            'name' => 'required|string',
            'type' => 'required',
            'label' => 'required',
            'sortorder' => 'required',
            'required' => 'required|boolean',
        ]);
   
        $formField = CustomFormField::create([
            'name' => $request->input('name'),
            'type' => $request->input('type'),
            'label' => $request->input('label'),
            'placeholder' => $request->input('placeholder'),
            'sort_order' => $request->input('sortorder'),
            'required' => $request->input('required'),
            'pattern' => $request->input('pattern'),
            'title' => $request->input('title'),
        ]);
        Session::flash('success', 'Form field created successfully!');
        return redirect()->route('admin.form.field');
    }
    public function FormFieldEdit($id)
    {
       
        $formField = CustomFormField::findOrFail($id);
        $data = CustomFormField::where('id','!=',$id)->get();
        
        return view('Admin.Formfield.edit', compact('formField','data'));
    }

    public function FormFieldUpdate(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string',
        'type' => 'required',
        'label' => 'required',
        'sort_order' => 'required',
        'required' => 'required|boolean',
        'pattern' =>'nullable',
        'title' => 'nullable',
        'placeholder' => 'nullable',
    ]);

    $formField = CustomFormField::findOrFail($id);
    $formField->update($request->all());
    Session::flash('success', 'Form field updated successfully!');
    return redirect()->route('admin.form.field.show');
}
}

