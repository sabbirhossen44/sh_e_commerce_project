<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\OrderCancel;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class OrdersController extends Controller
{
    public function orders()
    {
        $orders = Order::latest()->get();
        return view('admin.orders.order', [
            'orders' => $orders,
        ]);
    }
    public function order_status_update(Request $request, $id)
    {

        if ($request->status == 5) {
            Order::find($id)->update([
                'status' => 5,
                'updated_at' => Carbon::now(),
            ]);
            $orders_id = Order::find($id)->order_id;
            foreach (OrderProduct::where('order_id', $orders_id)->get() as $order_product) {
                Inventory::where('product_id', $order_product->product_id)->where('color_id', $order_product->color_id)->where('size_id', $order_product->size_id)->increment('quentity', $order_product->quantity);
            }
        } else {
            Order::find($id)->update([
                'status' => $request->status,
                'updated_at' => Carbon::now(),
            ]);
        }
        return back()->with('success', 'Order status updated successfully!');
    }
    public function cancel_order($id)
    {
        $order = Order::find($id);
        return view('frontend.customer.cancel_order', [
            'order' => $order,
        ]);
    }
    public function cancel_order_request(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required',
            'image' => 'nullable|image',
        ]);
        if ($request->hasFile('image') == '') {
            OrderCancel::insert([
                'order_id' => $id,
                'reason' => $request->reason,
                'created_at' => Carbon::now(),
            ]);
        } else {
            $image = $request->file('image');
            $file_name = time() . random_int(5000, 500000) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/cancelorder/'), $file_name);
            OrderCancel::insert([
                'order_id' => $id,
                'reason' => $request->reason,
                'image' => $file_name,
                'created_at' => Carbon::now(),
            ]);
        }
        return redirect()->route('my.orders')->with('send_request', 'Order Cancel Request Send Successfully!');
    }
    public function order_cancel_list()
    {
        $cancel_orders = OrderCancel::latest()->get();
        return view('admin.orders.cancel_order_list', [
            'cancel_orders' => $cancel_orders,
        ]);
    }
    public function cancel_details_view($id)
    {
        $cancel_details = OrderCancel::find($id);
        return view('admin.orders.cancel_details', [
            'cancel_details' => $cancel_details,
        ]);
    }
    public function order_cancel_accept($id)
    {
        $details = OrderCancel::find($id);
        if (!empty($details->image)) {
            $file_path = public_path('uploads/cancelorder/' . $details->image);
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }
        Order::find($details->order_id)->update([
            'status' => 5,
            'updated_at' => Carbon::now(),
        ]);
        $order_id = Order::find($details->order_id);
        foreach (OrderProduct::where('order_id', $order_id->order_id)->get() as $order_product) {
            Inventory::where('product_id', $order_product->product_id)->where('color_id', $order_product->color_id)->where('size_id', $order_product->size_id)->increment('quentity', $order_product->quantity);
        }
        $details->delete();
        return redirect()->route('order.cancel.lists')->with('success', 'Order Cancel Request Accepted!');
    }
    public function review_store(Request $request, $id)
    {
        $request->validate([
            // 'stars' => 'required',
            'review' => 'required',
            'name' => 'required',
            'email' => 'required',
        ]);
        OrderProduct::where('customer_id', Auth::guard('customer')->id())->where('product_id', $id)->first()->update([
            'review' => $request->review,
            'star' => $request->stars,
            'updated_at' => Carbon::now(),
        ]);
        return back()->with('Review_text', 'Review submitted successfully!');
    }
}
