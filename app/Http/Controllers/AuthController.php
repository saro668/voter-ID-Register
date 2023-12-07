<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Events\Registered;
use Mail;
use App\Models\ActivityLog;


  
class AuthController extends Controller
{
    public function register()
    {
        return view('auth/register');
    }
  
    public function registerSave(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:250',
            'email' => 'required|string|email:rfc,dns|max:250|unique:users,email',
            'password' => 'required|string|min:4|confirmed'
        ]);

        
        $token =  sha1(time());

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        

        $credentials = $request->only('email', 'password');
        Auth::attempt($credentials);
        $request->session()->regenerate();
        $user->sendEmailVerificationNotification();

        $modelActivity = new ActivityLog();
        $modelActivity->log('User Registered sucessfully', $request);

         return response()->json(['msg' => 'Registered Successfully'], 200);

    }
  
    public function login()
    {
        return view('auth/login');
    }
  
    public function loginAction(Request $request)
    {
        Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ])->validate();
  
        if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => trans('auth.failed')
            ]);
        }

        $modelActivity = new ActivityLog();
        $modelActivity->log('User Login sucessfully', $request);

  
        $request->session()->regenerate();
  
        return redirect()->route('dashboard');
    }


  
    public function logout(Request $request)
    {
        $modelActivity = new ActivityLog();
        $modelActivity->log('User logout sucessfully', $request);

        Auth::guard('web')->logout();
  
        $request->session()->invalidate();
  
        return redirect('/');
    }
 
   
}