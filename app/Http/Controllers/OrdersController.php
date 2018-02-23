<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cart;
use App\Order;
use App\Product;
use App\User;
use Illuminate\Support\Facades\Auth;
   


class OrdersController extends Controller
{
    


  public function __construct()
    {
        $this->middleware('auth');
    }




 public function checkout () {


   $cart = Auth::user()->cart;

   return view('orders.checkout',compact('cart'));

 }



 public function fail () {


   return view('orders.fail');

 }


 public function success () {


   return view('orders.success');

 }




   public function orders () {

   $uid = Auth::user()->id;
  
   $orders = Order::where('user_id','=',$uid)->get(); 

   return view('orders.orders')->with("orders", $orders);



 }




  public function complete(Request $request) {
 

     if(($request->has('product_id'))) {

        $user = Auth::user();

        $uid=$request->get('user_id');
    
       
        $total = $user->cart->sum(function($item){
            return $item->product->priceToCents();
        });

        $charge = $user->charge($total, [
            'source' => $request->get('stripe_token'),
            'receipt_email' => $user->email,
            'metadata' => [
                'name' => $user->name,
            ],
        ]);


         $product_id= $request->get('product_id');

         $product_price = $request->get('product_price');

         $product_quantity = $request->get('product_quantity');

         $order_id = mt_rand(5, 1000000);

        $order = new Order();
        $order->user_id = $uid;
        $order->product_id =$product_id;
        $order->order_number =$order_id;
        $order->user_email = $user->email;
        $order->user_email = $user->name;;
        $order->address = $request->input('address');
        $order->payment_status ="finished";
        $order->created_at = date("Y-m-d H:i:s");
        $order->save();

  

    $cart = Cart::where( 'user_id', '=', $uid )->first();
    $done=1;
    $order_id = $cart->order_id;
    $done=$cart->complete;
    $done=$cart->qty;
    $cart->save();


 return redirect('/success');

}

else {

 return redirect('/fail');  
      

}


}

}

