<?php



namespace App\Http\Controllers;

use Stripe;
use App\Models\Cart;

use App\Models\Order;

use App\Models\Billing;
use App\Models\Shipping;
use App\Mail\InvoiceMail;
use App\Models\Inventory;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\Stripe as ModelsStripe;
use Illuminate\Support\Facades\Session;



class StripePaymentController extends Controller

{

    /**

     * success response method.

     *

     * @return \Illuminate\Http\Response

     */

    public function stripe()

    {
        // print_r(session('data'));
        // return session('data');
        $data =  session('data');
        $total = $data['total'] + $data['charge'];
        if ($data['ship_to_different'] == 0) {
            $stripe_id = ModelsStripe::insertGetId([
                'fname' => $data['fname'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'total' => $data['total'],
                'address' => $data['address'],
                'lname' => $data['lname'],
                'country' => $data['country'],
                'city' => $data['city'],
                'zip' => $data['zip'],
                'company' => $data['company'],
                'ship_fname' => $data['fname'],
                'notes' => $data['notes'],
                'ship_lname' => $data['lname'],
                'ship_country' => $data['country'],
                'ship_city' => $data['city'],
                'ship_zip' => $data['zip'],
                'ship_company' => $data['company'],
                'ship_email' => $data['email'],
                'ship_phone' => $data['phone'],
                'ship_address' => $data['address'],
                'charge' => $data['charge'],
                'payment_method' => $data['payment_method'],
                'discount' => $data['discount'],
                'ship_chack' => $data['ship_to_different'],
                'customer_id' => $data['customer_id'],
            ]);

            return view('stripe', [
                'stripe_id' => $stripe_id,
                'data' => $data,
                'total' => $total,
            ]);
        } else {
            $stripe_id = ModelsStripe::insertGetId([
                'fname' => $data['fname'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'total' => $data['total'],
                'address' => $data['address'],
                'lname' => $data['lname'],
                'country' => $data['country'],
                'city' => $data['city'],
                'zip' => $data['zip'],
                'company' => $data['company'],
                'ship_fname' => $data['ship_fname'],
                'notes' => $data['notes'],
                'ship_lname' => $data['ship_lname'],
                'ship_country' => $data['ship_country'],
                'ship_city' => $data['ship_city'],
                'ship_zip' => $data['ship_zip'],
                'ship_company' => $data['ship_company'],
                'ship_email' => $data['ship_email'],
                'ship_phone' => $data['ship_phone'],
                'ship_address' => $data['ship_address'],
                'charge' => $data['charge'],
                'payment_method' => $data['payment_method'],
                'discount' => $data['discount'],
                'ship_chack' => $data['ship_to_different'],
                'customer_id' => $data['customer_id'],
            ]);

            return view('stripe', [
                'stripe_id' => $stripe_id,
                'data' => $data,
                'total' => $total,
            ]);
        }
    }



    /**

     * success response method.

     *

     * @return \Illuminate\Http\Response

     */

    public function stripePost(Request $request)

    {

        // echo $request->stripe_id;
        // die();
        $data = ModelsStripe::find($request->stripe_id);
        // return $data;

        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $total = $data->total + $data->charge;
        Stripe\Charge::create([

            // "amount" => $total,
            "amount" => 100 * $total,

            "currency" => "BDT",

            "source" => $request->stripeToken,  

            "description" => "Test payment from itsolutionstuff.com."

        ]);

        Session::flash('success', 'Payment successful!');
        $order_id = '#' . uniqid() . time();
        Order::insert([
            'order_id' => $order_id,
            'customer_id' => $data->customer_id,
            'total' => $data->total + $data->charge,
            'sub_total' => $data->total,
            'discoutn' => $data->discount,
            'charge' => $data->charge,
            'payment_method' => $data->payment_method,
            'order_date' => Carbon::now()->format('Y-m-d'),
            'created_at' => Carbon::now(),
        ]);
        Billing::insert([
            'order_id' => $order_id,
            'customer_id' => $data->customer_id,
            'fname' => $data->fname,
            'lname' => $data->lname,
            'country_id' => $data->country,
            'city_id' => $data->city,
            'zip' => $data->zip,
            'company' => $data->company,
            'email' => $data->email,
            'phone' => $data->phone,
            'adress' => $data->address,
            'notes' => $data->notes,
            'created_at' => Carbon::now(),
        ]);
        if ($data->ship_to_different == 1) {
            Shipping::insert([
                'order_id' => $order_id,
                'ship_fname' => $data->ship_fname,
                'ship_lname' => $data->ship_lname,
                'ship_country_id' => $data->ship_country,
                'ship_city_id' => $data->ship_city,
                'ship_zip' => $data->ship_zip,
                'ship_company' => $data->ship_company,
                'ship_email' => $data->ship_email,
                'ship_phone' => $data->ship_phone,
                'ship_adress' => $data->ship_address,
                'created_at' => Carbon::now(),
            ]);
        } else {
            Shipping::insert([
                'order_id' => $order_id,
                'ship_fname' => $data->fname,
                'ship_lname' => $data->lname,
                'ship_country_id' => $data->country,
                'ship_city_id' => $data->city,
                'ship_zip' => $data->zip,
                'ship_company' => $data->company,
                'ship_email' => $data->email,
                'ship_phone' => $data->phone,
                'ship_adress' => $data->address,
                'created_at' => Carbon::now(),
            ]);
        }
        $carts = Cart::where('customer_id', $data->customer_id)->get();
        foreach ($carts as $cart) {
            OrderProduct::insert([
                'order_id' => $order_id,
                'customer_id' => $data->customer_id,
                'product_id' => $cart->product_id,
                'price' => $cart->rel_to_product->after_discount,
                'color_id' => $cart->color_id,
                'size_id' => $cart->size_id,
                'quantity' => $cart->quantity,
                'created_at' => Carbon::now(),
            ]);
            Cart::find($cart->id)->delete();
            Inventory::where('product_id', $cart->product_id)->where('color_id', $cart->color_id)->where('size_id', $cart->size_id)->decrement('quentity', $cart->quantity);
        }
        Mail::to($data->email)->send(new InvoiceMail($order_id));
        return redirect()->route('order.success')->with('success', $order_id);

        // $order_id = '#' . uniqid() . time();
        // Order::insert([
        //     'order_id' => $order_id,
        //     'customer_id' => Auth::guard('customer')->id(),
        //     'total' => $request->total + $request->charge,
        //     'sub_total' => $request->total - $request->discount,
        //     'discoutn' => $request->discount,
        //     'charge' => $request->charge,
        //     'payment_method' => $request->payment_method,
        //     'created_at' => Carbon::now(),
        // ]);
        // Billing::insert([
        //     'order_id' => $order_id,
        //     'customer_id' => Auth::guard('customer')->id(),
        //     'fname' => $request->fname,
        //     'lname' => $request->lname,
        //     'country_id' => $request->country,
        //     'city_id' => $request->city,
        //     'zip' => $request->zip,
        //     'company' => $request->company,
        //     'email' => $request->email,
        //     'phone' => $request->phone,
        //     'adress' => $request->address,
        //     'notes' => $request->notes,
        //     'created_at' => Carbon::now(),
        // ]);
        // if ($request->ship_to_different == 1) {
        //     Shipping::insert([
        //         'order_id' => $order_id,
        //         'ship_fname' => $request->ship_fname,
        //         'ship_lname' => $request->ship_lname,
        //         'ship_country_id' => $request->ship_country,
        //         'ship_city_id' => $request->ship_city,
        //         'ship_zip' => $request->ship_zip,
        //         'ship_company' => $request->ship_company,
        //         'ship_email' => $request->ship_email,
        //         'ship_phone' => $request->ship_phone,
        //         'ship_adress' => $request->ship_address,
        //         'created_at' => Carbon::now(),
        //     ]);
        // } else {
        //     Shipping::insert([
        //         'order_id' => $order_id,
        //         'ship_fname' => $request->fname,
        //         'ship_lname' => $request->lname,
        //         'ship_country_id' => $request->country,
        //         'ship_city_id' => $request->city,
        //         'ship_zip' => $request->zip,
        //         'ship_company' => $request->company,
        //         'ship_email' => $request->email,
        //         'ship_phone' => $request->phone,
        //         'ship_adress' => $request->address,
        //         'created_at' => Carbon::now(),
        //     ]);
        // }
        // $carts = Cart::where('customer_id', Auth::guard('customer')->id())->get();
        // foreach ($carts as $cart) {
        //     OrderProduct::insert([
        //         'order_id' => $order_id,
        //         'customer_id' => Auth::guard('customer')->id(),
        //         'product_id' => $cart->product_id,
        //         'price' => $cart->rel_to_product->after_discount,
        //         'color_id' => $cart->color_id,
        //         'size_id' => $cart->size_id,
        //         'quantity' => $cart->quantity,
        //         'created_at' => Carbon::now(),
        //     ]);
        //     Cart::find($cart->id)->delete();
        //     Inventory::where('product_id', $cart->product_id)->where('color_id', $cart->color_id)->where('size_id', $cart->size_id)->decrement('quentity', $cart->quantity);
        // }
        // Mail::to($request->email)->send(new InvoiceMail($order_id));
        // return redirect()->route('order.success')->with('success', $order_id);
    }
}
