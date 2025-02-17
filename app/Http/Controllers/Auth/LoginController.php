<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Exception;
use Auth;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    protected $providers=[
        'github','facebook','google','twitter'
    ];
    //admin login =====
    public function login(Request $request)
    {
        $validated= $request->validate([
            'email'=> 'required|email',
            'password'=> 'required',
        ]);
        if (auth()->attempt(array('email' =>$request->email, 'password' =>$request->password))) {
            if (auth()->user()->is_admin==1) {
                return redirect()->route('admin.home');
            }else{
                return redirect()->back();
            }
        }else{
            return redirect()->back()->with('error','Invalid email or password');
        }
    }
     // admin login -----
    public function adminLogin()
    {
        return view('auth.admin_login');
    }
    //__socialite login all Function
    public function redirectToProvider($driver)
    {
        if (! $this->isProviderAllowed($driver)) {
            return $this->sendFailedResponse("{$driver} is not currently supported");    
        }
        try{
            return Socialite::driver($driver)->redirect();
        }catch(Exception $e){
            //you should show something simple fail message
            return $this->sendFailedResponse($e->getMessage());
        }
    }
    public function handleProviderCallback($driver)
    {
        try{
            $user=Socialite::driver($driver)->user();
        }catch(Exception $e){
            return $this->sendFailedResponse($e->getMessage());
        }
        //Chack for email in returned user
        return empty($user->email)
            ? $this->sendFailedResponse('No email id returned from {$driver} provider.')
            : $this->loginOrCreateAccount($user,$driver);
    }
    protected function sendSuccessResponse()
    {
        return redirect()->intended('home');
    }
    protected function sendFailedResponse($msg=null)
    {
        return redirect()->route('login')->withErrors(['msg'=>$msg ?: 'Unable to login, try another provider to login']);
    }
    protected function loginOrCreateAccount($providerUser,$driver)
    {
        //__chack for already found
        $user = User::where('email',$providerUser->getEmail())->first();
        //__if use already found
        if ($user) {
            //__update the avater and provider that might have changed
            $user->update([
                'avatar'=>$providerUser->avatar,
                'provider'=>$driver,
                'provider_id'=>$providerUser->id,
                'access_token'=>$providerUser->token
            ]);
        }else{
            //__create a new user
            $user = User::create([
                'name'=>$providerUser->getName(),
                'email'=>$providerUser->getEmail(),
                'avatar'=>$providerUser->getAvatar(),
                'provider'=>$driver,
                'provider_id'=>$providerUser->getId(),
                'access_token'=>$providerUser->token,
                //__user can use reset password to create a password
                'password'=>''

            ]);
        }
        //__login the user
        Auth::login($user, true);
        return $this->sendSuccessResponse();
    }
    private function isProviderAllowed($driver)
    {
        return in_array($driver,$this->providers) && config()->has("services.{$driver}");
    }
}
