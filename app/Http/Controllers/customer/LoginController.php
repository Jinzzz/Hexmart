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
use Redirect;
use Mail;
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
    /*
    Description : Customer login page
    Date        : 29/3/2022
    
    */
    public function showLoginForm()
    {
        return view('customer.login');
    }
    /*
    Description : customer logged in redirect to home page
    Date        : 29/3/2022
    
    */
    public function usrlogin(Request $request)
    {

        $this->validateLogin($request);

        if ($this->attemptLogin($request))
        {

            return $this->sendLoginResponse($request);
        }
        return $this->sendFailedLoginResponse($request);
    }
    /*
    Description : customer login validation
    Date        : 29/3/2022
    
    */
    protected function validateLogin(Request $request)
    {

        $this->validate($request, [$this->username() => 'required|email', 'password' => 'required|string', ]);
    }

    public function username()
    {
        return 'customer_email';
    }

    protected function credentials(Request $request)
    {

        $customer = Mst_Customer::where('customer_email', $request->customer_email)
            ->first();

        if ($customer)
        {
            return ['customer_email' => $request->customer_email, 'password' => $request->password, ];
        }

        return $request->only($this->username() , 'password');
    }

    public function __construct()
    {
        $this->middleware('guest:customer')
            ->except('logout');
    }

    protected function guard()
    {
        return Auth::guard('customer');
    }
    /*
    Description : Customer Logout 
    Date        : 29/3/2022
    
    */
    public function logout()
    {
       if (Auth::guest('customer')==true)
       {
         $customer_id = Auth::guard('customer')->user()->customer_id;
        Auth::guard('customer')->logout();
        } 
       return redirect('/customer/customer-login');

    }

    /*
    Description : Customer Forget-Password Page 
    Date        : 1/4/2022
    
    */
    public function forgot_password()
    {
    
       return view('customer.login.forgotpassword');

    }
    /*
    Description : Customer Forget-Password Store 
    Date        : 1/4/2022
    
    */

    public function forgotpassword_store(Request $request)
    {
        $request->validate([
            'customer_email' => 'required|email',
        ]);
        $email=Mst_Customer::where('customer_email',$request->customer_email)->exists();
        $contactEmail=$request->customer_email;
        if($email==true)
        {
            $data = array('email'=>$request->customer_email);
            Mail::send('customer.login.forgot_email', $data, function($message)
            {   
            $message->from('bincyhexeam@gmail.com');
            $message->to('bincyhexeam@gmail.com', 'bincy')->subject('Reset Password');
            });

        }
        else
        {
            return redirect()->back()->withInput()->with('error','no  matching records.');
        }
        

    }
    /*
    Description : Customer Reset-Password Page 
    Date        : 1/4/2022
    
    */

    public function Reset_Passwordlink($email)
    {
       $email=Mst_Customer::where('customer_email',$email)->first();
       return view('customer.login.passwordreset',compact('email'));

    }

    /*
    Description : Customer Reset Password stored for mst_customer table 
    Date        : 1/4/2022
    
    */

     public function Password_Reset(Request $request)
    {
       $request->validate([
            'customer_email' =>'required|email',
            'password' => 'required|min:6|required_with:confirm_password|same:confirm_password',
            'confirm_password' => 'required|min:6',
        ]);

       $customer = Mst_Customer::find($request->customer_id);
       $customer->password = Hash::make($request->password);
       $customer->update();

       return redirect()->route('customer-login');
   }


}

