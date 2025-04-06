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

use App\Http\Controllers\Controller;
use App\Models\User;

class UsersController extends Controller {

	use ValidatesRequests;

    public function list(Request $request) {
        if (!auth()->user()->hasPermissionTo('show_users')) {
            abort(401);
        }
    
        // Start the query
        $query = User::query();
    
        // If the logged-in user is an employee, only show customers
        if (auth()->user()->hasRole('Employee')) {
            $query->role('Customer');
        }
    
        // Apply keyword search if present
        if ($request->filled('keywords')) {
            $query->where(function ($q) use ($request) {
                $q->where("name", "like", "%" . $request->keywords . "%")
                  ->orWhere("email", "like", "%" . $request->keywords . "%");
            });
        }
    
        // Eager load roles for performance
        $users = $query->with('roles')->get();
    
        return view('users.list', compact('users'));
    }
    

    public function register(Request $request) {
        // If user is logged in and is NOT an admin, deny access
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
    
        $user->delete();  // Correct method to delete the user
    
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

    // Handle adding credit
    // In CreditController.php

public function addCredit(Request $request, User $user)
{
    // Check if the logged-in user has the 'employee' role
    if (!auth()->user()->hasRole('Employee')) {
        return redirect()->back()->with('error', 'You do not have permission to add credit.');
    }

    // Validate input to ensure it's numeric and positive
    $request->validate([
        'amount' => 'required|numeric|min:0.01', // Enforce positive amounts only
    ]);

    // Add the credit to the specified user's account
    $user->credit += $request->input('amount');
    $user->save();

    // Redirect with a success message
    return redirect(route('profile', ['user'=>$user->id]));
}

    
    
    
} 