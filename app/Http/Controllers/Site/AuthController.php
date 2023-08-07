<?php

namespace App\Http\Controllers\Site;

use DB;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\FileUploader;
use App\Http\Controllers\Controller;
use App\Mail\User\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Validation\ValidationException;


class AuthController extends Controller
{

    function __construct()
    {
        $this->middleware('site.guest')->except('logout');
    }

    public function login()
    {
        return view('site.login');
    }

    public function register()
    {
         $form = DB::table('form')->first();
        return view('site.sign-up',compact('form'));
    }

    public function signUp(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'number' => 'required|numeric|digits:10',
            'company_name' => 'required|string|max:255',
            'company_address' => 'required|string|max:3000',
            'password_confirmation' => 'required|same:password',
            'form' => 'nullable|file|mimes:pdf,png,jpg,jpeg|max:2048'
        ]);

        $data = $request->except([
            'name', 'email', 'password', 'number', 'company_name', 'company_address', 'password_confirmation', 'form',
            'company_logo', 'pan_document', 'quality_certifications'
        ]);

        if($request->has('company_logo')){
            $request->validate([
                'company_logo' => 'required|file|mimes:pdf,png,jpg,jpeg|max:2048'
            ]);

           $data['company_logo'] = FileUploader::uploadFile($request->file('company_logo'), 'images/company-logo');
        }

        if($request->has('pan_document')){
            $request->validate([
                'pan_document' => 'required|file|mimes:pdf,png,jpg,jpeg|max:2048'
            ]);
            $data['pan_document']  = FileUploader::uploadFile($request->file('pan_document'), 'images/pan-document');
        }

        if($request->has('quality_certifications')){
            $request->validate([
                'quality_certifications' => 'required|file|mimes:pdf,png,jpg,jpeg|max:2048'
            ]);
            $data['quality_certifications']= FileUploader::uploadFile($request->file('quality_certifications'), 'images/gst-document');
        }


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->number,
            'company_name' => $request->company_name,
            'company_address' => $request->company_address,
            'status' => 'pending',
            'form_data' => $request->file('form') ? FileUploader::uploadFile($request->file('form'), 'images/form') : null,
            'extra_data' => json_encode($data),
        ]);

        auth()->login($user);

        return response()->json([
            'message' => 'User created successfully , Contract admin for account activation',
            'status' => 'success',
        ]);
    }


    public function checkLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {
            return response()->json([
                'message' => 'User logged in successfully',
                'status' => 'success',
                'redirect' => '/',
            ]);
        }
        
        
        throw ValidationException::withMessages([
      'message' => 'Invalid username or password',
    ]);

        return response()->json([
            'message' => 'Invalid credentials',
            'status' => 'failure',
        ],422);
    }


    public function logout()
    {
        auth()->logout();

        return redirect()->route('site.home');
    }


    public function forgetPassword()
    {
        Artisan::call('optimize:clear');
        return view('site.forget-password');
    }


    public function sendOtp(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'message' => 'Email not found',
                'status' => 'failure',
            ]);
        }

        $otp = rand(100000, 999999);

        DB::table('password_resets')->where('email', $request->email)->delete();


        \Mail::to($user->email)->send(new Password($user, $otp));


        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $otp,
            'created_at' => Carbon::now()
        ]);
    }


    public function confirmOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|numeric|digits:6',
            'password' => 'required|min:6',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'message' => 'Email not found',
                'status' => 'failure',
            ]);
        }

        $token = DB::table('password_resets')->where('email', $request->email)->first();

        if (!$token) {
            return response()->json([
                'message' => 'Invalid OTP',
                'status' => 'failure',
            ]);
        }

        if ($token->token != $request->otp) {
            return response()->json([
                'message' => 'Invalid OTP',
                'status' => 'failure',
            ]);
        }

        $user->password = Hash::make($request->password);

        $user->save();

        auth()->login($user);


        DB::table('password_resets')->where('email', $request->email)->delete();

        return response()->json([
            'message' => 'Password changed successfully',
            'status' => 'success',
            'redirect' => route('dashboard.home')
        ]);
    }
}
