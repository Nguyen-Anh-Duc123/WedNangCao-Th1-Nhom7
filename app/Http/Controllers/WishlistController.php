<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class WishlistController extends Controller
{
    public function index()
    {
        $cate_product = DB::table('tbl_category_product')
            ->where('category_status', '0')
            ->orderBy('category_id', 'desc')
            ->get();

        $brand_product = DB::table('tbl_brand')
            ->where('brand_status', '0')
            ->orderBy('brand_id', 'desc')
            ->get();

        $wishlist = Session::get('wishlist', []);

        return view('pages.wishlist.index')
            ->with('category', $cate_product)
            ->with('brand', $brand_product)
            ->with('wishlist', $wishlist);
    }

    public function add(Request $request)
    {
        $product_id = $request->product_id;
        if (!$product_id) {
            return Redirect::back();
        }

        $product = DB::table('tbl_product')->where('product_id', $product_id)->first();
        if (!$product) {
            return Redirect::back();
        }

        $wishlist = Session::get('wishlist', []);
        $wishlist[$product_id] = [
            'id' => $product->product_id,
            'name' => $product->product_name,
            'price' => $product->product_price,
            'image' => $product->product_image,
            'slug' => $product->product_slug,
        ];

        Session::put('wishlist', $wishlist);
        Session::put('message', 'Đã thêm sản phẩm vào mục yêu thích.');

        return Redirect::back();
    }

    public function remove($product_id)
    {
        $wishlist = Session::get('wishlist', []);
        if (isset($wishlist[$product_id])) {
            unset($wishlist[$product_id]);
            Session::put('wishlist', $wishlist);
        }

        return Redirect::back();
    }
}
