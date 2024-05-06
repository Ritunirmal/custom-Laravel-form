<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Content;
use App\Models\Home;
use DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function Welcome()
    {
        
        $content = Content::where('status',1)->first();
        $HomeData = Home::where('status',1)->first();

        // dd($data->content);
        return view('welcome',compact('content','HomeData'));
    }
    public function index()
    {
        $content = Content::where('status',1)->first();
        $HomeData = Home::where('status',1)->first();
        if (auth()->user()->role == 'admin') {
            return redirect()->route('admin.home');
        }else if (auth()->user()->role == 'candidate') {
            return redirect()->route('candidate.home');
        }
        return view('home',compact('content','HomeData'));
    }
    public function HomeContent(Request $request)
    {
        if ($request->ajax()) {
            $options = Content::all();


           
            return DataTables::of($options)
            
            ->addColumn('dependent_option', function ($option) {
                return $option->status; // Assuming 'value' is the option value in CustomFormFieldOption
            })
           
            ->addColumn('action', function ($option) {
                $editBtn = '<a href="/admin/home-content/' . $option['id'] . '/edit" class="edit btn btn-primary btn-sm">Edit</a>';
                $deleteBtn = '<button class="deleteField btn btn-danger btn-sm" data-id="' . $option['id'] . '">Delete</button>';
                return $editBtn . ' ' . $deleteBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
          
        return view('Admin.Content.index');
    }
    public function HomeContentCreate()
    {
        return view('Admin.Content.add');
    }
    public function HomeContentSave(Request $request)
    {
    //  dd($request->all());
        $request->validate([
            'content' => 'required',
           
           
        ]);
        $formField = Content::create([
            'content' => $request->input('content')
        ]);
     
        return redirect()->back()->with('success', 'Content saved successfully.');
    }
    public function HomeContentEdit($id)
    {
        $data = Content::where('id',$id)->first();
        
        return view('Admin.Content.edit',compact('data'));
    }
    public function HomeContenteEditSave(Request $request)
{
    $request->validate([
        'content' => 'required',
    ]);

   

    // Update the record based on its ID
    Content::where('id', $request->input('id'))->update([
        'content' => $request->input('content'),
    ]);

    return redirect()->back()->with('success', 'Content updated successfully.');
}
public function HomeContenteDelete(Request $request)
{
    // Validate the request
    $validator = Validator::make($request->all(), [
        'id' => 'required',
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()->first()], 422);
    }
    $optionId = $request->input('id');

    $option = Content::find($optionId);
    if ($option) {
        $option->delete();

        return response()->json(['success' => true, 'message' => 'Record deleted successfully']);
    } else {
        return response()->json(['error' => 'Record not found'], 404);
    }
}
public function HomeContenteToggle(Request $request)
{
    $id = $request->input('id');
    $type = $request->input('type');
    $value = $request->input('value');

     $option = Content::find($id);
     if (!$option) {
        return response()->json(['error' => 'Option not found'], 404);
    }
    if ($type === 'show_options') {
        $option->status = $value;
    }  else {
        return response()->json(['error' => 'Invalid toggle type'], 400);
    }

    $option->save();

    return response()->json(['success' => true]);
}
public function HomeData(Request $request)
{
    if ($request->ajax()) {
        $options = Home::all();


       
        return DataTables::of($options)
        
        ->addColumn('status', function ($option) {
            return $option->status; // Assuming 'value' is the option value in CustomFormFieldOption
        })
       
        ->addColumn('action', function ($option) {
            $editBtn = '<a href="/admin/home-data/' . $option['id'] . '/edit" class="edit btn btn-primary btn-sm">Edit</a>';
            $deleteBtn = '<button class="deleteField btn btn-danger btn-sm" data-id="' . $option['id'] . '">Delete</button>';
            return $editBtn . ' ' . $deleteBtn;
        })
        ->rawColumns(['action'])
        ->make(true);
    }
      
    return view('Admin.HomeData.index');
}
public function HomeDatatCreate()
{
    return view('Admin.HomeData.add');
}
public function HomeDataSave(Request $request)
{
// dd($request->file('logo'));
$rules = [
    'logo' => 'required|image|mimes:jpeg,jpg,png|max:200|dimensions:min_width=103,min_height=96,max_width=103,max_height=96',
];
   
    $documentType='logo';
    $validator = Validator::make($request->all(), [
        'logo' => $rules[$documentType],
        'heading' => 'required',
        'post' => 'required',
    ]);
    // if ($validator->fails()) {
    //     return response()->json(['success' => false, 'errors' => $validator->errors()->all()], 422);
    // }
    $file = $request->file('logo');
        $logoupload = 'logo';
        $uploadPath = public_path("{$logoupload}"); 
        $fileName = 'logo_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move($uploadPath, $fileName);
        $fullUrl = url("/{$logoupload}/{$fileName}");
    $formField = home::create([
        'logo' => $fullUrl,
        'heading' => $request->input('heading'),
        'post' => $request->input('post')
    ]);
 
    return redirect()->back()->with('success', 'Home Data saved successfully.');
}
public function HomeDataEdit($id)
{
    $data = Home::where('id',$id)->first();
    
    return view('Admin.HomeData.edit',compact('data'));
}
public function HomeDataEditSave(Request $request)
{
    // Define validation rules
    $validator = Validator::make($request->all(), [
        'heading' => 'required',
        'post' => 'required',
    ]);

    // Check if validation fails
    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    // Check if a file has been uploaded
    if ($request->hasFile('logo')) {
        $file = $request->file('logo');
        $logoupload = 'logo';
        $uploadPath = public_path("{$logoupload}"); 
        $fileName = 'logo_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move($uploadPath, $fileName);
        $fullUrl = url("/{$logoupload}/{$fileName}");
    } else {
        // If no file has been uploaded, retrieve the current logo URL from the database
        $existingData = Home::find($request->input('id'));
        $fullUrl = $existingData->logo;
    }

    // Update the record based on its ID
    Home::where('id', $request->input('id'))->update([
        'logo' => $fullUrl,
        'heading' => $request->input('heading'),
        'post' => $request->input('post'),
    ]);

    return redirect()->back()->with('success', 'Home Data updated successfully.');
}

public function HomeDataDelete(Request $request)
{
// Validate the request
$validator = Validator::make($request->all(), [
    'id' => 'required',
]);

if ($validator->fails()) {
    return response()->json(['error' => $validator->errors()->first()], 422);
}
$optionId = $request->input('id');

$option = Home::find($optionId);
if ($option) {
    $option->delete();

    return response()->json(['success' => true, 'message' => 'Record deleted successfully']);
} else {
    return response()->json(['error' => 'Record not found'], 404);
}
}
public function HomeDataToggle(Request $request)
{
$id = $request->input('id');
$type = $request->input('type');
$value = $request->input('value');

 $option = Home::find($id);
 if (!$option) {
    return response()->json(['error' => 'Option not found'], 404);
}
if ($type === 'show_options') {
    $option->status = $value;
}  else {
    return response()->json(['error' => 'Invalid toggle type'], 400);
}

$option->save();

return response()->json(['success' => true]);
}
}
