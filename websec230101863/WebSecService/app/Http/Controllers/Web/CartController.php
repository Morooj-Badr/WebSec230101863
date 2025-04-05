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
    
    // If cart is empty, redirect to cart with an error message
    if (empty($cart)) {
        return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
    }
    
    $total = 0;
    // Calculate the total amount of the cart
    foreach ($cart as $item) {
        $total += $item['price'] * $item['quantity'];
    }

    // Check if the user is authenticated
    if (auth()->check()) {
        $user = auth()->user();

        // Check if the user has enough credit for the total purchase amount
        if ($user->credit < $total) {
            return view('cart.insufficient_credit'); // Show insufficient credit page
        }

        // Proceed to checkout if credit is sufficient
        $user->credit -= $total;  // Deduct total amount from user credit
        $user->save();

        // Loop through each item in the cart and update the quantity in the database
        foreach ($cart as $productId => $item) {
            $product = Product::find($productId);
            
            // Check if product exists and has enough stock
            if ($product && $product->quantity >= $item['quantity']) {
                // Decrease the product quantity
                $product->quantity -= $item['quantity'];
                $product->save();
            } else {
                // Handle out of stock scenario
                return redirect()->route('cart.index')->with('error', 'Not enough stock for some products!');
            }
        }

        // Clear the cart after purchase
        session()->forget('cart');

        // Redirect to profile page with success message
        return redirect()->route('profile')->with('success', 'Checkout successful!');
    }

    return redirect()->route('login');
}

    public function remove($productId)
    {
        $cart = session()->get('cart');

        // Check if the item exists in the cart
        if (isset($cart[$productId])) {
            // Remove the item from the cart
            unset($cart[$productId]);
            
            // Update the session
            session()->put('cart', $cart);
        }

        // Redirect back to the cart page (cart.index)
        return redirect()->route('cart.index');
    }
}
