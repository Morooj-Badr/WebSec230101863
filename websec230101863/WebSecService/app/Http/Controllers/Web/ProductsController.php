<?php
namespace App\Http\Controllers\Web;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use DB;



use Illuminate\Support\Facades\Auth; 

use App\Http\Controllers\Controller;
use App\Models\Product;




class ProductsController extends Controller {

	use ValidatesRequests;

	public function __construct()
    {
        $this->middleware('auth:web')->except('list');
    }

	public function list(Request $request) {

		$query = Product::select("products.*");

		$query->when($request->keywords, 
		fn($q)=> $q->where("name", "like", "%$request->keywords%"));

		$query->when($request->min_price, 
		fn($q)=> $q->where("price", ">=", $request->min_price));
		
		$query->when($request->max_price, fn($q)=> 
		$q->where("price", "<=", $request->max_price));
		
		$query->when($request->order_by, 
		fn($q)=> $q->orderBy($request->order_by, $request->order_direction??"ASC"));

		$products = $query->get();

		return view('products.list', compact('products'));
	}

	public function edit(Request $request, Product $product = null) {

		if(!auth()->user()) return redirect('/');

		$product = $product??new Product();

		return view('products.edit', compact('product'));
	}

	public function save(Request $request, Product $product = null) {

		$this->validate($request, [
			'code' => ['required', 'string', 'max:32'],
			'name' => ['required', 'string', 'max:128'],
			'model' => ['required', 'string', 'max:256'],
			'description' => ['required', 'string', 'max:1024'],
			'price' => ['required', 'numeric'],
			'quantity' => ['required', 'integer', 'min:1'],  
		]);
	
		$product = $product ?? new Product();
		$product->fill($request->all());
		$product->save();
	
		return redirect()->route('products_list');
	}
	


	public function addToCart(Request $request, $productId)
	{
		$product = Product::find($productId);
		
		$cart = session()->get('cart', []);
	
		$quantity = $request->input('quantity', 1); 
		
		
		if (isset($cart[$productId])) {
			$cart[$productId]['quantity'] += $quantity; 
		} else {
			$cart[$productId] = [
				'name' => $product->name,
				'quantity' => $quantity,
				'price' => $product->price,
				'image' => $product->photo, 
			];
		}
	
		session()->put('cart', $cart);
	
		return redirect()->route('cart.index');
	}
	

	
	public function buy(Request $request, $productId)
{
    $product = Product::find($productId);
    $user = Auth::user();
    

    $quantityToBuy = $request->input('quantity', 1);  


    if ($user->credit >= $product->price * $quantityToBuy) {
  
        if ($product->quantity >= $quantityToBuy) {
           
            $user->credit -= $product->price * $quantityToBuy;
            $user->save();

           
            $product->quantity -= $quantityToBuy;
            $product->save();

            

            return redirect()->route('profile', ['user' => $user->id])
                ->with('success', 'Product bought successfully!');
        } else {
            return back()->with('error', 'Not enough stock available to complete the purchase.');
        }
    } else {
        return back()->with('error', 'Not enough credit to buy this product.');
    }
}






	public function delete(Request $request, Product $product) {

		if(!auth()->user()->hasPermissionTo('delete_products')) abort(401);

		$product->delete();

		return redirect()->route('products_list');
	}
} 