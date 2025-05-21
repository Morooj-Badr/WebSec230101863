<?php

namespace App\Http\Controllers\web;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Validation\Rules\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
use Artisan;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationEmail;
use Laravel\Socialite\Facades\Socialite;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;

class UsersController extends Controller {

	use ValidatesRequests;

    public function list(Request $request) {
        if (!auth()->user()->hasPermissionTo('show_users')) {
            abort(401);
        }
    
        
        $query = User::query();
    
        
        if (auth()->user()->hasRole('Employee')) {
            $query->role('Customer');
        }
    
        //filtering
        if ($request->filled('keywords')) {
            $query->where(function ($q) use ($request) {
                $q->where("name", "like", "%" . $request->keywords . "%")
                  ->orWhere("email", "like", "%" . $request->keywords . "%");
            });
        }
    
        
        $users = $query->with('roles')->get();
    
        return view('users.list', compact('users'));
    }
    

    public function register(Request $request) {
        
        if (auth()->check() && !auth()->user()->hasRole('Admin')) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('users.register');
    }
    
    
    

    public function doRegister(Request $request) {

    	try {
    		$this->validate($request, [
	        'name' => ['required', 'string', 'min:5'],
	        'email' => ['required', 'email', 'unique:users'],
	        'password' => ['required', 'confirmed', Password::min(8)->numbers()->letters()->mixedCase()->symbols()],
	    	]);
    	}
    	catch(\Exception $e) {

    		return redirect()->back()->withInput($request->input())->withErrors('Invalid registration information.');
    	}

    	
    	$user =  new User();
	    $user->name = $request->name;
	    $user->email = $request->email;
	    $user->password = bcrypt($request->password); //Secure
	    $user->save();

        $token = Crypt::encryptString(json_encode([
            'id' => $user->id,
            'email' => $user->email
        ]));
    
        $link = route("verify", ['token' => $token]);
    
        Mail::to($user->email)->send(new VerificationEmail($link, $user->name));
    
        return redirect('/');
    }

    public function login(Request $request) {
        return view('users.login');
    }

    public function doLogin(Request $request) {
    	
    	if(!Auth::attempt(['email' => $request->email, 'password' => $request->password]))
            return redirect()->back()->withInput($request->input())->withErrors('Invalid login information.');

        $user = User::where('email', $request->email)->first();
        Auth::setUser($user);

        if(!$user->email_verified_at)
    return redirect()->back()->withInput($request->input())
    ->withErrors('Your email is not verified.');


        return redirect('/');
    }

    public function doLogout(Request $request) {
    	
    	Auth::logout();

        return redirect('/');
    }

    public function profile(Request $request, User $user = null) {

        $user = $user??auth()->user();
        if(auth()->id()!=$user->id) {
            if(!auth()->user()->hasPermissionTo('show_users')) abort(401);
        }

        $permissions = [];
        foreach($user->permissions as $permission) {
            $permissions[] = $permission;
        }
        foreach($user->roles as $role) {
            foreach($role->permissions as $permission) {
                $permissions[] = $permission;
            }
        }

        return view('users.profile', compact('user', 'permissions'));
    }

    public function edit(Request $request, User $user = null) {
   
        $user = $user??auth()->user();
        if(auth()->id()!=$user?->id) {
            if(!auth()->user()->hasPermissionTo('edit_users')) abort(401);
        }
    
        $roles = [];
        foreach(Role::all() as $role) {
            $role->taken = ($user->hasRole($role->name));
            $roles[] = $role;
        }

        $permissions = [];
        $directPermissionsIds = $user->permissions()->pluck('id')->toArray();
        foreach(Permission::all() as $permission) {
            $permission->taken = in_array($permission->id, $directPermissionsIds);
            $permissions[] = $permission;
        }      

        return view('users.edit', compact('user', 'roles', 'permissions'));
    }

    public function save(Request $request, User $user) {

        if(auth()->id()!=$user->id) {
            if(!auth()->user()->hasPermissionTo('show_users')) abort(401);
        }

        $user->name = $request->name;
        $user->save();

        if(auth()->user()->hasPermissionTo('admin_users')) {

            $user->syncRoles($request->roles);
            $user->syncPermissions($request->permissions);

            Artisan::call('cache:clear');
        }

        //$user->syncRoles([1]);
        //Artisan::call('cache:clear');

        return redirect(route('profile', ['user'=>$user->id]));
    }

    public function delete(Request $request, User $user) {
        if (!auth()->user()->hasPermissionTo('delete_users')) {
            abort(401);
        }
    
        $user->delete();  
    
        return redirect()->route('users');
    }
    

    public function editPassword(Request $request, User $user = null) {

        $user = $user??auth()->user();
        if(auth()->id()!=$user?->id) {
            if(!auth()->user()->hasPermissionTo('edit_users')) abort(401);
        }

        return view('users.edit_password', compact('user'));
    }

    public function savePassword(Request $request, User $user) {

        if(auth()->id()==$user?->id) {
            
            $this->validate($request, [
                'password' => ['required', 'confirmed', Password::min(8)->numbers()->letters()->mixedCase()->symbols()],
            ]);

            if(!Auth::attempt(['email' => $user->email, 'password' => $request->old_password])) {
                
                Auth::logout();
                return redirect('/');
            }
        }
        else if(!auth()->user()->hasPermissionTo('edit_users')) {

            abort(401);
        }

        $user->password = bcrypt($request->password); //Secure
        $user->save();

        return redirect(route('profile', ['user'=>$user->id]));
    }
    
    public function addCreditForm()
    {
        return view('credit.add_credit'); // specify the folder path

    }

 

public function addCredit(Request $request, User $user)
{
    
    if (!auth()->user()->hasRole('Employee')) {
        return redirect()->back()->with('error', 'You do not have permission to add credit.');
    }

    
    $request->validate([
        'amount' => 'required|numeric|min:0.01', 
    ]);

   
    $user->credit += $request->input('amount');
    $user->save();

    
    return redirect(route('profile', ['user'=>$user->id]));
}

    
 
public function verify(Request $request) {
    $decryptedData = json_decode(Crypt::decryptString($request->token), true);
    $user = User::find($decryptedData['id']);
    
    
    if (!$user) abort(401);

    $user->email_verified_at = Carbon::now();
    $user->save();

    return view('users.verified', compact('user'));
}

    public function redirectToGoogle()
    {
    return  Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback() {
        try {
        $googleUser = Socialite::driver('google')->user();
        $user = User::updateOrCreate([
        'google_id' => $googleUser->id,
        ], [
        'name' => $googleUser->name,
        'email' => $googleUser->email,
        'google_token' => $googleUser->token,
        'google_refresh_token' => $googleUser->refreshToken,
        ]);
        Auth::login($user);
        return redirect('/');
        } catch (\Exception $e) {
        return redirect('/login')->with('error', 'Google login failed.'); // Handle errors
        }

    }

    
public function redirectToFacebook()
{
    return Socialite::driver('facebook')->redirect();
}

public function handleFacebookCallback()
{
    try {
        $facebookUser = Socialite::driver('facebook')->user();

        // Find or create the user in your database
        $user = User::updateOrCreate([
            'facebook_id' => $facebookUser->id,
        ], [
            'name' => $facebookUser->name,
            'email' => $facebookUser->email,
            'facebook_token' => $facebookUser->token,
            'facebook_refresh_token' => $facebookUser->refreshToken,
        ]);

        // Log the user in
        Auth::login($user);

        // Redirect to the home page or wherever you'd like
        return redirect('/');
    } catch (\Exception $e) {
        return redirect('/login')->with('error', 'Facebook login failed.'); // Handle errors
    }
}
} 