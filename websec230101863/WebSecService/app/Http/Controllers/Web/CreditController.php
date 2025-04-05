<?php
namespace App\Http\Controllers\Web;
use App\Models\User;

use Illuminate\Http\Request;
use Auth;
use App\Models\Product;
use App\Models\Purchase;
use App\Http\Controllers\Controller;


class CreditController extends Controller
{
    // Show the form for adding credit (GET request)
    public function addCredit(Request $request)
    {
        // Validate the input (amount is required and numeric, no min or max constraints)
        $request->validate([
            'amount' => 'required|numeric',  // No min or max
        ]);
    
        // Get the authenticated user
        $user = Auth::user();
    
        // Add credit to the user's existing credit
        $user->credit += $request->amount;
        $user->save();
    
        // Redirect back to the profile with a success message
        return redirect()->route('profile', ['user' => $user->id])
            ->with('success', 'Credit added successfully!');
    }

    public function purchaseProduct(Request $request, $productId)
{
    $product = Product::findOrFail($productId);
    $user = Auth::user();

    // Check if the product has enough stock
    if ($product->quantity > 0) {
        // Check if the user has enough credit
        if ($user->credit >= $product->price) {
            // Deduct the price from user's credit
            $user->credit -= $product->price;
            $user->save();

            // Create a new purchase record
            $purchase = new Purchase();
            $purchase->user_id = $user->id;
            $purchase->product_id = $product->id;
            $purchase->quantity = 1; // You can adjust this if you need to track multiple quantities
            $purchase->total_price = $product->price;
            $purchase->save();

            // Update the product quantity in the database
            $product->quantity -= 1; // Decrease quantity by 1 for each purchase
            $product->save();

            return redirect()->route('profile')->with('success', 'Product purchased successfully!');
        } else {
            return back()->with('error', 'Not enough credit to purchase this product.');
        }
    } else {
        return back()->with('error', 'This product is out of stock.');
    }
}
// In CreditController.php

public function chargeCredit(Request $request, User $user)
{
    // Check if the authenticated user has the 'Employee' role
    if (!auth()->user()->hasRole('Employee')) {
        return redirect()->back()->with('error', 'You do not have permission to charge credit.');
    }

    // Validate the input to ensure it's a positive numeric value
    $request->validate([
        'amount' => 'required|numeric|min:1',  // Minimum value 1, or adjust as needed
    ]);
     
    // Add the credit to the specified user's account
    $user->credit += $request->input('amount');
    $user->save();

    return redirect()->route('profile', ['user' => $user->id])
                     ->with('success', 'Credit charged successfully!');
}


}
