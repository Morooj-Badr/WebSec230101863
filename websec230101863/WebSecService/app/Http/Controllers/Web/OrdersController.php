<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrdersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    // ✅ List user orders
    public function list()
    {
        $orders = Order::where('user_id', Auth::id())->get();
        return view('orders.list', compact('orders'));
    }

    // ✅ Handle product purchase
    public function purchase(Request $request, Product $product)
    {
        $user = Auth::user();

        // ✅ Ensure only customers can buy
        if (!method_exists($user, 'hasRole') || !$user->hasRole('customer')) {
            return back()->withErrors("Only customers can purchase products.");
        }

        // ✅ Check if the product is in stock
        if (!$product->hasStock()) {
            return back()->withErrors("Product is out of stock.");
        }

        // ✅ Check if user has enough credit
        if ($user->credit < $product->price) {
            return back()->withErrors("Insufficient credit.");
        }

        DB::beginTransaction();
        try {
            // Deduct user credit
            $user->decrement('credit', $product->price);

            // Reduce product stock
            $product->decrement('stock', 1);

            // Create order
            Order::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'quantity' => 1,
                'total_price' => $product->price,
                'status' => 'completed',
            ]);

            DB::commit();
            return redirect()->route('orders_list')->with('success', 'Purchase successful.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Purchase failed: ' . $e->getMessage()); // ✅ Log the error
            return back()->withErrors("Purchase failed. Try again.");
        }
    }
}
