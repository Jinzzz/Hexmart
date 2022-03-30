<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\admin\Mst_Customer;
use Hash;
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

     // use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/customer-dashboard';
    // protected $redirectTo = RouteServiceProvider::CUSTOMER_HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:customer')->except('logout');


    }

    protected function authenticated(Request $request, $user)
    {
        //logout from all other devices
        //auth()->logoutOtherDevices($request->password);
    }

    public function cust_store(Request $request)
    {
         // dd($request);
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:4'
        ]);

        // if (Auth::guard('customer')->attempt(['customer_email' => $request->email, 'password' => $request->password])) {

        //     return redirect()->intended('/customer-dashboard');
        // }
        //  return back()->withInput($request->only('email'));
        // return redirect()->intended(RouteServiceProvider::CUSTOMER_HOME);
        $user=Mst_Customer::where('customer_email',$request->email)->first();
        if(!$user || !Hash::check($request->password,$user->password))
        {
            return "Username or Password is not matched.";
        }
        else
        { 
          return redirect()->route('customerdashboard');
            // if (Auth::guest('customer')->attempt(['customer_email' => $request->email, 'password' => 
            // $request->password])) {
            // return redirect()->intended(route('customerdashboard'));
            // }

        }


      
        
    }
}
