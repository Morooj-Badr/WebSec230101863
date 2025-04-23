<?php
namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\Product;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }

    public function checkout(Request $request)
{
    $cart = session()->get('cart', []);
    
    if (empty($cart)) {
        return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
    }
    
    $total = 0;
   
    foreach ($cart as $item) {
        $total += $item['price'] * $item['quantity'];
    }

    
    if (auth()->check()) {
        $user = auth()->user();

       
        if ($user->credit < $total) {
            return view('cart.insufficient_credit'); 
        }

        
        $user->credit -= $total;  
        $user->save();

       
        foreach ($cart as $productId => $item) {
            $product = Product::find($productId);
            
            
            if ($product && $product->quantity >= $item['quantity']) {
                
                $product->quantity -= $item['quantity'];
                $product->save();
            } else {
                
                return redirect()->route('cart.index')->with('error', 'Not enough stock for some products!');
            }
        }

       
        session()->forget('cart');

        
        return redirect()->route('profile')->with('success', 'Checkout successful!');
    }

    return redirect()->route('login');
}

    public function remove($productId)
    {
        $cart = session()->get('cart');

       
        if (isset($cart[$productId])) {
           
            unset($cart[$productId]);
            
            
            session()->put('cart', $cart);
        }

       
        return redirect()->route('cart.index');
    }
}
