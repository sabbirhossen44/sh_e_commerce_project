<?php

namespace App\Http\Controllers;

use App\Models\Sslorder;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Subscribe;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function dashboard(){
        $orders = Order::whereDate('order_date', '>' , Carbon::now()->subDays(30))->where('status', '!=', 5)
        ->groupBy('order_date')
        ->selectRaw('count(*) as total, order_date')
        ->get();
        
        $total_order= '';
        $order_date= '';
        foreach ($orders as $order) {
            $total_order .= $order->total. ',';
            $order_date .= Carbon::parse($order->order_date)->format('M-d') .',';
        }
        $total_order_info = explode(',',$total_order);
        $order_date_info = explode(',',$order_date);
        array_pop($total_order_info);
        array_pop($order_date_info);


        // sales
        $sales = Order::whereDate('order_date', '>' , Carbon::now()->subDays(30))->where('status', '!=', 5)
        ->groupBy('order_date')
        ->selectRaw('sum(total) as sum, order_date')
        ->get();
        // return $sales;
        
        $total_sales= '';
        $sales_date= '';
        foreach ($sales as $sale) {
            $total_sales .= $sale->sum. ',';
            $sales_date .= Carbon::parse($sale->order_date)->format('M-d') .',';
        }
        $total_sales_info = explode(',',$total_sales);
        $sales_date_info = explode(',',$sales_date);
        array_pop($total_sales_info);
        array_pop($sales_date_info);
        return view('dashboard',[
            'total_order_info' => $total_order_info,
            'order_date_info' => $order_date_info,
            'total_sales_info' => $total_sales_info,
            'sales_date_info' => $sales_date_info,
        ]);
    }
    public function user_list(){
        $users = User::where('id', '!=', Auth::id())->get();
        // return $abc;
        return view('admin.user.user_list', compact('users'));
    }
    public function user_delete($user_id){
        $user = User::find($user_id);
        $user->delete();
        return back()->with('user_delete', 'User deleted successfully');
    }
    public function user_add(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);
        User::insert([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        return back()->with('user_add', 'User added successfully');
    }
    public function Subscriber_list(){
        $subscribers = Subscribe::all();
        return view('admin.subscribe.index',[
            'subscribers' => $subscribers,
        ]);
    }
    
}
