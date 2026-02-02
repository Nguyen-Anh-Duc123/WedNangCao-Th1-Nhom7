<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
session_start();

class AdminController extends Controller
{
    public function AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }
    public function index(){
        $admin_id = Session::get('admin_id');
        if ($admin_id) {
            return Redirect::to('/dashboard');
        }
        return view('admin_login');
    }
    public function show_dashboard(){
        $this->AuthLogin();
        $now = Carbon::now();
        $month_start = $now->copy()->startOfMonth();
        $month_end = $now->copy()->endOfMonth();

        $monthly_revenue = DB::table('tbl_order')
            ->join('tbl_payment','tbl_order.payment_id','=','tbl_payment.payment_id')
            ->whereIn('tbl_order.order_status', ['Đã giao', 'Da giao'])
            ->whereIn('tbl_payment.payment_status', ['Đã thanh toán', 'Da thanh toan'])
            ->whereBetween('tbl_order.created_at', [$month_start, $month_end])
            ->sum('tbl_order.order_total');
        $monthly_orders = DB::table('tbl_order')
            ->whereBetween('created_at', [$month_start, $month_end])
            ->count();
        $total_users = DB::table('tbl_customers')->count();
        $brand_count = DB::table('tbl_brand')->count();

        $chart_data = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = $now->copy()->subMonths($i);
            $start = $month->copy()->startOfMonth();
            $end = $month->copy()->endOfMonth();
            $revenue = DB::table('tbl_order')
                ->join('tbl_payment','tbl_order.payment_id','=','tbl_payment.payment_id')
                ->whereIn('tbl_order.order_status', ['Đã giao', 'Da giao'])
                ->whereIn('tbl_payment.payment_status', ['Đã thanh toán', 'Da thanh toan'])
                ->whereBetween('tbl_order.created_at', [$start, $end])
                ->sum('tbl_order.order_total');
            $orders = DB::table('tbl_order')
                ->whereBetween('created_at', [$start, $end])
                ->count();
            $chart_data[] = [
                'period' => $month->format('Y-m-01'),
                'orders' => (int) $orders,
                'revenue' => round(((float) $revenue) / 1000000, 2),
            ];
        }

        return view('admin.dashboard', [
            'monthly_revenue' => $monthly_revenue,
            'monthly_orders' => $monthly_orders,
            'total_users' => $total_users,
            'brand_count' => $brand_count,
            'chart_data' => $chart_data,
        ]);
    }
    public function dashboard(Request $request){
        $admin_email = $request->admin_email;
        $admin_password = md5($request->admin_password);

        $result = DB::table('tbl_admin')->where('admin_email',$admin_email)->where('admin_password',$admin_password)->first();
        if($result){
            Session::put('admin_name',$result->admin_name);
            Session::put('admin_id',$result->admin_id);
            return Redirect::to('/dashboard');
        }else{
            Session::put('message','Mật khẩu hoặc tài khoản bị sai. Làm ơn nhập lại.');
            return Redirect::to('/admin');
        }

    }
    public function logout(){
        $this->AuthLogin();
        Session::put('admin_name',null);
        Session::put('admin_id',null);
        return Redirect::to('/trang-chu');
    }
}
