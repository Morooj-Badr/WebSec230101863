<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Purchase;

class PurchasesController extends Controller
{
    public function buy($id)
    {
        $user = Auth::user();

        // ✅ Only customers with role ID 3 can buy
        if (!$user->hasRole('Customer') || $user->roles->first()->id != 3) {
            abort(403, 'Unauthorized action.');
        }

        // ✅ Find the product
        $product = Product::findOrFail($id);

        // ✅ Check if the product is in stock
        if ($product->stock <= 0) {
            return redirect()->back()->with('error', 'This product is out of stock.');
        }

        // ✅ Create a purchase record
        Purchase::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        // ✅ Reduce stock count
        $product->stock -= 1;
        $product->save();

        return redirect()->route('orders_list')->with('success', 'Purchase successful!');
    }
}
