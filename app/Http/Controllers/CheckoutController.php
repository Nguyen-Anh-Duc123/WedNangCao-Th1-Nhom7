<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
session_start();

class CheckoutController extends Controller
{
    public function AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }

    public function view_order($orderId){
        $this->AuthLogin();
        $order_by_id = DB::table('tbl_order')
            ->join('tbl_customers','tbl_order.customer_id','=','tbl_customers.customer_id')
            ->join('tbl_shipping','tbl_order.shipping_id','=','tbl_shipping.shipping_id')
            ->join('tbl_payment','tbl_order.payment_id','=','tbl_payment.payment_id')
            ->select('tbl_order.*','tbl_customers.customer_name','tbl_customers.customer_phone','tbl_customers.customer_email','tbl_shipping.*','tbl_payment.payment_status','tbl_payment.payment_method')
            ->where('tbl_order.order_id', $orderId)
            ->first();

        if (!$order_by_id) {
            Session::put('message','Không tìm thấy đơn hàng.');
            return Redirect::to('/manage-order');
        }

        $order_details = DB::table('tbl_order_details')
            ->where('tbl_order_details.order_id', $orderId)
            ->get();

        $manager_order_by_id  = view('admin.view_order')->with('order_by_id',$order_by_id)->with('order_details',$order_details);
        return view('admin_layout')->with('admin.view_order', $manager_order_by_id);
    }

    public function login_checkout(){
        $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id','desc')->get();

        return view('pages.checkout.login_checkout')->with('category',$cate_product)->with('brand',$brand_product);
    }

    public function add_customer(Request $request){
        $data = array();
        $data['customer_name'] = $request->customer_name;
        $data['customer_phone'] = $request->customer_phone;
        $data['customer_email'] = $request->customer_email;
        $data['customer_password'] = md5($request->customer_password);

        $customer_id = DB::table('tbl_customers')->insertGetId($data);

        Session::put('customer_id',$customer_id);
        Session::put('customer_name',$request->customer_name);
        return Redirect::to('/checkout');
    }

    public function checkout(){
        $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id','desc')->get();

        return view('pages.checkout.show_checkout')->with('category',$cate_product)->with('brand',$brand_product);
    }

    public function save_checkout_customer(Request $request){
        $data = array();
        $data['shipping_name'] = $request->shipping_name;
        $data['shipping_phone'] = $request->shipping_phone;
        $data['shipping_email'] = $request->shipping_email ?? '';
        $data['shipping_notes'] = $request->shipping_notes;
        $data['shipping_address'] = $request->shipping_address;
        $data['created_at'] = now();
        $data['updated_at'] = now();

        $shipping_id = DB::table('tbl_shipping')->insertGetId($data);
        Session::put('shipping_id',$shipping_id);

        return Redirect::to('/checkout');
    }

    public function payment(){
        return Redirect::to('/checkout');
    }

    public function order_place(Request $request){
        $customer_id = Session::get('customer_id');
        if (!$customer_id) {
            Session::put('message','Vui lòng đăng nhập trước khi đặt hàng.');
            return Redirect::to('/login-checkout');
        }
        if (Cart::count() === 0) {
            Session::put('message','Giỏ hàng đang trống. Vui lòng thêm sản phẩm trước khi đặt hàng.');
            return Redirect::to('/show-cart');
        }
        if (!$request->shipping_name || !$request->shipping_phone || !$request->shipping_address) {
            Session::put('message','Vui lòng nhập đầy đủ thông tin giao hàng.');
            return Redirect::to('/checkout');
        }
        if (!$request->payment_option) {
            Session::put('message','Vui lòng chọn phương thức thanh toán.');
            return Redirect::to('/checkout');
        }

        try {
            DB::beginTransaction();

            $shipping_data = array();
            $shipping_data['shipping_name'] = $request->shipping_name;
            $shipping_data['shipping_phone'] = $request->shipping_phone;
            $shipping_data['shipping_email'] = '';
            $shipping_data['shipping_notes'] = $request->shipping_notes;
            $shipping_data['shipping_address'] = $request->shipping_address;
            $shipping_data['created_at'] = now();
            $shipping_data['updated_at'] = now();
            $shipping_id = DB::table('tbl_shipping')->insertGetId($shipping_data);

            $payment_data = array();
            $payment_data['payment_method'] = $request->payment_option;
            $is_cod = (string) $request->payment_option === '2';
            $payment_data['payment_status'] = $is_cod ? 0 : 1;
            $payment_data['created_at'] = now();
            $payment_data['updated_at'] = now();
            $payment_id = DB::table('tbl_payment')->insertGetId($payment_data);

            $order_data = array();
            $order_data['customer_id'] = $customer_id;
            $order_data['shipping_id'] = $shipping_id;
            $order_data['payment_id'] = $payment_id;
            $order_data['order_total'] = str_replace(',', '', Cart::total());
            $order_data['order_status'] = $is_cod ? 0 : 2;
            $order_data['created_at'] = now();
            $order_data['updated_at'] = now();
            $order_id = DB::table('tbl_order')->insertGetId($order_data);

            $content = Cart::content();
            foreach($content as $v_content){
                $order_d_data = array();
                $order_d_data['order_id'] = $order_id;
                $order_d_data['product_id'] = $v_content->id;
                $order_d_data['product_name'] = $v_content->name;
                $order_d_data['product_price'] = $v_content->price;
                $order_d_data['product_sales_quantity'] = $v_content->qty;
                $order_d_data['created_at'] = now();
                $order_d_data['updated_at'] = now();
                DB::table('tbl_order_details')->insert($order_d_data);
            }

            DB::commit();
            Cart::destroy();
            Session::put('order_message','Đặt hàng thành công. Đơn hàng đã được hoàn thành.');
            return Redirect::to('/checkout');
        } catch (\Exception $e) {
            DB::rollBack();
            Session::put('message','Đặt hàng không thành công. Vui lòng thử lại.');
            return Redirect::to('/checkout');
        }
    }

    public function logout_checkout(){
        Session::flush();
        return Redirect::to('/trang-chu');
    }

    public function login_customer(Request $request){
        $email = $request->email_account;
        $password = md5($request->password_account);
        $result = DB::table('tbl_customers')->where('customer_email',$email)->where('customer_password',$password)->first();

        if($result){
            Session::put('customer_id',$result->customer_id);
            return Redirect::to('/checkout');
        }else{
            $admin = DB::table('tbl_admin')->where('admin_email',$email)->where('admin_password',$password)->first();
            if ($admin) {
                Session::put('admin_name',$admin->admin_name);
                Session::put('admin_id',$admin->admin_id);
                return Redirect::to('/dashboard');
            }
            Session::put('message','Sai email hoặc mật khẩu.');
            return Redirect::to('/login-checkout');
        }
    }

    public function manage_order(){
        $this->AuthLogin();
        $all_order = DB::table('tbl_order')
            ->join('tbl_customers','tbl_order.customer_id','=','tbl_customers.customer_id')
            ->join('tbl_payment','tbl_order.payment_id','=','tbl_payment.payment_id')
            ->select('tbl_order.*','tbl_customers.customer_name','tbl_payment.payment_status')
            ->orderby('tbl_order.order_id','desc')->get();
        $manager_order  = view('admin.manage_order')->with('all_order',$all_order);
        return view('admin_layout')->with('admin.manage_order', $manager_order);
    }

    public function update_order_status(Request $request, $orderId){
        $this->AuthLogin();
        $status = trim($request->order_status);
        if ($status === '') {
            Session::put('message','Vui lòng chọn trạng thái.');
            return Redirect::to('/manage-order');
        }

        $order = DB::table('tbl_order')
            ->join('tbl_payment','tbl_order.payment_id','=','tbl_payment.payment_id')
            ->select('tbl_order.order_id','tbl_payment.payment_status')
            ->where('tbl_order.order_id',$orderId)
            ->first();

        if (!$order) {
            Session::put('message','Không tìm thấy đơn hàng.');
            return Redirect::to('/manage-order');
        }
        if (in_array((string) $order->payment_status, ['1', 'Đã thanh toán', 'Da thanh toan'])) {
            Session::put('message','Đơn hàng đã thanh toán nên không thể chỉnh trạng thái.');
            return Redirect::to('/manage-order');
        }

        $order_status = $status;
        $status_map = [
            'Đang xử lý' => 0,
            'Dang xu ly' => 0,
            'Đang giao hàng' => 1,
            'Dang giao hang' => 1,
            'Đã giao' => 2,
            'Da giao' => 2,
            'Đã hủy' => 3,
            'Da huy' => 3,
        ];
        if (isset($status_map[$status])) {
            $order_status = $status_map[$status];
        }

        DB::table('tbl_order')->where('order_id',$orderId)->update([
            'order_status' => $order_status,
        ]);
        Session::put('message','Đã cập nhật trạng thái đơn hàng.');
        return Redirect::to('/manage-order');
    }

    public function delete_order($orderId){
        $this->AuthLogin();
        $order = DB::table('tbl_order')->where('order_id',$orderId)->first();
        if (!$order) {
            Session::put('message','Không tìm thấy đơn hàng.');
            return Redirect::to('/manage-order');
        }

        DB::table('tbl_order_details')->where('order_id',$orderId)->delete();
        DB::table('tbl_order')->where('order_id',$orderId)->delete();

        if (!empty($order->payment_id)) {
            DB::table('tbl_payment')->where('payment_id',$order->payment_id)->delete();
        }
        if (!empty($order->shipping_id)) {
            DB::table('tbl_shipping')->where('shipping_id',$order->shipping_id)->delete();
        }

        Session::put('message','Đã xóa đơn hàng.');
        return Redirect::to('/manage-order');
    }

    public function update_payment_status(Request $request, $orderId){
        $this->AuthLogin();
        $status = trim($request->payment_status);
        if ($status === '') {
            Session::put('message','Vui lòng chọn trạng thái thanh toán.');
            return Redirect::to('/manage-order');
        }

        $order = DB::table('tbl_order')
            ->join('tbl_payment','tbl_order.payment_id','=','tbl_payment.payment_id')
            ->select('tbl_order.order_id','tbl_order.payment_id','tbl_payment.payment_status')
            ->where('tbl_order.order_id',$orderId)
            ->first();
        if (!$order) {
            Session::put('message','Không tìm thấy đơn hàng.');
            return Redirect::to('/manage-order');
        }
        if (in_array((string) $order->payment_status, ['1', 'Đã thanh toán', 'Da thanh toan'])) {
            Session::put('message','Đơn hàng đã thanh toán nên không thể chỉnh thanh toán.');
            return Redirect::to('/manage-order');
        }

        $payment_status = $status;
        if ($status === 'Đã thanh toán' || $status === 'Da thanh toan') {
            $payment_status = 1;
        } elseif ($status === 'Chưa thanh toán' || $status === 'Chua thanh toan') {
            $payment_status = 0;
        }

        DB::table('tbl_payment')->where('payment_id',$order->payment_id)->update([
            'payment_status' => $payment_status,
        ]);

        Session::put('message','Đã cập nhật trạng thái thanh toán.');
        return Redirect::to('/manage-order');
    }
}
