<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cart;
use App\Order;
use App\Product;
use App\User;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{





public function index() {


$products = Product::orderBy('name', 'asc')->paginate(10);  

return view('products.index',compact('cart'))->with('products',$products);

}



public function store(Request $request){

        
if(($request->has('product_id'))) {

  $product = Product::find($request->get('product_id'));
        

        $cart = new Cart([
            'product_id' => $product->id,
            'qty' => $request->get('qty', 1),
            'price' => $product->price,
        ]);

    Auth::user()->cart()->save($cart);

    return redirect('/checkout');

   }

else {

         return redirect('/home');  
      
}


    }

  
    
    
    public function remove($id)
    {
        Auth::user()->cart()
          ->where('id', $id)->firstOrFail()->delete();
        return redirect('/home');
    }






}
