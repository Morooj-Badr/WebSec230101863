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
    
    public function addCredit(Request $request)
    {
        
        $request->validate([
            'amount' => 'required|numeric',  
        ]);
    
        $user = Auth::user();
    
       
        $user->credit += $request->amount;
        $user->save();
    
        
        return redirect()->route('profile', ['user' => $user->id])
            ->with('success', 'Credit added successfully!');
    }

    public function purchaseProduct(Request $request, $productId)
{
    $product = Product::findOrFail($productId);
    $user = Auth::user();

    
    if ($product->quantity > 0) {
        
        if ($user->credit >= $product->price) {
          
            $user->credit -= $product->price;
            $user->save();

            
            $purchase = new Purchase();
            $purchase->user_id = $user->id;
            $purchase->product_id = $product->id;
            $purchase->quantity = 1;
            $purchase->total_price = $product->price;
            $purchase->save();

            $product->quantity -= 1; 
            $product->save();

            return redirect()->route('profile')->with('success', 'Product purchased successfully!');
        } else {
            return back()->with('error', 'Not enough credit to purchase this product.');
        }
    } else {
        return back()->with('error', 'This product is out of stock.');
    }
}


public function chargeCredit(Request $request, User $user)
{
    
    if (!auth()->user()->hasRole('Employee')) {
        return redirect()->back()->with('error', 'You do not have permission to charge credit.');
    }

   
    $request->validate([
        'amount' => 'required|numeric|min:1',  
    ]);
     

    $user->credit += $request->input('amount');
    $user->save();

    return redirect()->route('profile', ['user' => $user->id])
                     ->with('success', 'Credit charged successfully!');
}

    public function resetCredit(Request $request, User $user){
        if (!auth()->user()->hasrole('Employee')) {
            return redirect()->back()->with('error', 'You do not have permission to reset.');
        } 
        
        $user->credit = 0 ;
        $user->save();
        return redirect()->route('list', ['user' => $user->id]);
    }


}
