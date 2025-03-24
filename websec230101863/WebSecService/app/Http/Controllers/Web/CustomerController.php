<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function index()
{
    // Ensure only employees can access the customer list
    if (!auth()->user()->hasRole('Employee')) {
        abort(403, 'Unauthorized action.');
    }

    // Fetch only users with the "Customer" role
    $customers = \App\Models\User::whereHas('roles', function ($query) {
        $query->where('name', 'Customer');
    })->get();

    return view('customers.index', compact('customers'));
}

    public function updateCredit(Request $request, Customer $customer)
    {
        // Ensure only employees can update customer credit
        if (!auth()->user()->hasRole('Employee')) {
            abort(403, 'Unauthorized action.');
        }

        // Validate input: Only positive values allowed
        $request->validate([
            'credit' => ['required', 'numeric', 'min:0']
        ]);

        // Update customer credit
        $customer->credit += $request->credit;
        $customer->save();

        return redirect()->back()->with('success', 'Customer credit updated successfully.');
    }
}
