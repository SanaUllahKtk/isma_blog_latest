<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Hash;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Symfony\Component\HttpFoundation\Request;

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
    public function store(Request $request)
    {
        // dd($request);

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);


        // return $request->only('email', 'password');

        $user = User::where('email', $request->email)->first();


        if ($user->isAdmin !== '1') {
            return redirect()->route('site.home');
        }
        // return Hash::check($request->password, $user->password);

        // return Hash::make($request->password);
        //compare password
        if (!\Hash::check($request->password, $user->password)) {
            return redirect()->back()->with('error', 'Password does not match');
        }

        //login user

        auth()->login($user);


        return redirect()->route('admin.home');
    }


    // Login
    public function index()
    {
        $pageConfigs = [
            'bodyClass' => "bg-full-screen-image",
            'blankPage' => true
        ];

        return view('/auth/login', [
            'pageConfigs' => $pageConfigs
        ]);
    }
}
