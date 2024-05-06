<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\Home;
use Illuminate\Support\Facades\Crypt;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function showLoginForm()
{
   
    $HomeData = Home::where('status', 1)->first();
    return view('auth.login',compact('HomeData'));
}
    public function login(Request $request): RedirectResponse
    {   
        $input = $request->all(); 
     
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
      
        $privateKey = file_get_contents(storage_path('app\keys\private.pem'));
        $encryptedPassword = $request->input('password');
        openssl_private_decrypt(base64_decode($encryptedPassword), $decryptedPassword, $privateKey);

        // Now you have the decrypted password
        // dd($decryptedPassword);
 
        if(auth()->attempt(array('email' => $input['email'], 'password' =>  $decryptedPassword)))
        {
            if (auth()->user()->role == 'admin') {
                return redirect()->route('admin.home');
            }else if (auth()->user()->role == 'candidate') {
                return redirect()->route('candidate.home');
            }
        }else{
            return redirect()->route('login')
                ->with('error','Email-Address And Password Are Wrong.');
        }
          
    }

}
