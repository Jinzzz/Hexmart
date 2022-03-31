<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Crypt;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use App\Models\admin\Mst_Customer;

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
    protected $redirectTo = '/customer-dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */


    public function showLoginForm()
    {
        return view('customer.login');
    }


    public function usrlogin(Request $request)
    {
       
        
        $this->validateLogin($request);

        if ($this->attemptLogin($request)) {


            return $this->sendLoginResponse($request);
        }
        return $this->sendFailedLoginResponse($request);
    }

    protected function validateLogin(Request $request)
    {
        
        $this->validate($request, [
        $this->username() => 'required|email',
                'password' => 'required|string',
        ]);
    }
    
    public function username()
    {
        return 'customer_email';
    }


    protected function credentials(Request $request)
    {
        
        $customer = Mst_Customer::where('customer_email',$request->customer_email)->first();
       
        if ($customer) {
                return [
                    'customer_email'=>$request->customer_email,
                    'password'=>$request->password,
                ];
            }

        return $request->only($this->username(), 'password');
    }
    

    public function __construct()
    {
        //$this->middleware('guest');
        $this->middleware('guest:customer')->except('logout');
    }

    protected function guard()
    {
        return Auth::guard('customer');
    }

     public function logout(Request $request)
    {
        $customer_id  = Auth::guard('customer')->user()->customer_id;

       

        Auth::guard('customer')->logout();
        

        return redirect('customerlogin');
    }


}
