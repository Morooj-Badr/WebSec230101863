<?php
namespace App\Http\Controllers\Web;
use Illuminate\Http\Request;
use DB;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Twilio\Rest\Client;

// use Illuminate\Support\Facades\DB;





class UsersController extends Controller {

    public function forgotPassword() {
        return view('users.forgot_password');
    }

    public function resetPassword(Request $request) {
        $this->validate($request, [
            'identifier' => 'required' // Can be email or mobile
        ]);
    
        $identifier = $request->input('identifier');
        $user = User::where('email', $identifier)
                    ->orWhere('mobile_number', $identifier)
                    ->first();
    
        if (!$user) {
            return redirect()->back()->withErrors('User not found.');
        }
    
        // // Generate a temporary password
        // $tempPassword = rand(100000, 999999);
        // $user->password = Hash::make($tempPassword);
        // $user->save();
    
        // if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
        //     // Send Email (You need to set up Mail in Laravel)
        //     Mail::to($user->email)->send(new \App\Mail\ResetPasswordMail($tempPassword));
        // } else {
        //     // Send SMS
        //     $twilio = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));
        //     $twilio->messages->create(
        //         $user->mobile_number,
        //         [
        //             "from" => env('TWILIO_PHONE'),
        //             "body" => "Your temporary password is: $tempPassword"
        //         ]
        //     );
        // }
    
        return redirect()->back()->with('message', 'Temporary password sent successfully.');
    }

    // SMS Sending Function (Example)
    public function sendSMS($mobile, $tempPassword) {
        // Implement an SMS API (e.g., Twilio, Egyptian SMS provider)
        return "SMS sent to $mobile with temp password: $tempPassword";
    }



    use ValidatesRequests;
    public function register(Request $request) {
    return view('users.register');
    }
    public function doRegister(Request $request) {
        
        $this->validate($request, [
        'name' => ['required', 'string', 'min:5'],
        'email' => ['required', 'email', 'unique:users'],
        'password' => ['required', 'confirmed',
        Password::min(8)->numbers()->letters()->mixedCase()->symbols()],
        ]);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password); //Secure
        $user->save();
        return redirect("/");
    }
    public function login(Request $request) {
    return view('users.login');
    }
    public function doLogin(Request $request) {
        $credentials = $request->only('email', 'password');
    
        // Check if the input is an email or a mobile number
        $field = filter_var($credentials['email'], FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile_number';
    
        // Attempt to authenticate using email or mobile
        if (!Auth::attempt([$field => $credentials['email'], 'password' => $credentials['password']])) {
            return redirect()->back()->withInput($request->input())->withErrors('Invalid login information.');
        }
    
        $user = User::where($field, $credentials['email'])->first();
        Auth::setUser($user);
    
        return redirect("/");
    }
    public function doLogout(Request $request) {
        Auth::logout();
        return redirect("/");
        }
    }