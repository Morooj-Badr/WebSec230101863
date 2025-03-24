<?php
namespace App\Http\Controllers\Web;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductsController extends Controller {

    use ValidatesRequests;

    public function __construct()
    {
        $this->middleware('auth:web')->except('list');
    }

    // ✅ List products with filtering and sorting
    public function list(Request $request) {
        $query = Product::query();

        // ✅ Apply search filters
        $query->when($request->keywords, fn($q) => 
            $q->where("name", "like", "%{$request->keywords}%"));

        $query->when($request->min_price, fn($q) => 
            $q->where("price", ">=", $request->min_price));

        $query->when($request->max_price, fn($q) => 
            $q->where("price", "<=", $request->max_price));

        // ✅ Secure sorting (only allow certain columns)
        $allowedSortFields = ['name', 'price'];
        if ($request->order_by && in_array($request->order_by, $allowedSortFields)) {
            $query->orderBy($request->order_by, $request->order_direction ?? "ASC");
        }

        $products = $query->get();

        return view('products.list', compact('products'));
    }

    // ✅ Show product edit form
    public function edit(Request $request, Product $product = null) {
        $this->authorize('edit_products'); // ✅ Ensure user has permission

        $product = $product ?? new Product();

        return view('products.edit', compact('product'));
    }

    // ✅ Save product (create or update)
    public function save(Request $request, Product $product = null) {
        $this->authorize($product ? 'edit_products' : 'add_products'); // ✅ Ensure correct permission

        $validatedData = $request->validate([
            'code' => 'required|string|max:32',
            'name' => 'required|string|max:128',
            'model' => 'required|string|max:256',
            'description' => 'required|string|max:1024',
            'price' => 'required|numeric|min:0',
        ]);

        $product = $product ?? new Product();
        $product->fill($validatedData);
        $product->save();

        return redirect()->route('products_list')->with('success', 'Product saved successfully.');
    }

    // ✅ Delete product
    public function delete(Request $request, Product $product) {
        if (!auth()->user()->hasPermissionTo('delete_products')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $product->delete();

        return redirect()->route('products_list')->with('success', 'Product deleted successfully.');
    }
}
