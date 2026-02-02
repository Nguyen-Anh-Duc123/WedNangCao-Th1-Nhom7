<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    public function shop()
    {
        $cate_product = DB::table('tbl_category_product as c')
            ->leftJoin('tbl_product as p', function ($join) {
                $join->on('p.category_id', '=', 'c.category_id')
                    ->where('p.product_status', '0');
            })
            ->where('c.category_status', '0')
            ->groupBy('c.category_id', 'c.category_name', 'c.slug_category_product')
            ->select(
                'c.category_id',
                'c.category_name',
                'c.slug_category_product',
                DB::raw('count(p.product_id) as product_count')
            )
            ->orderBy('c.category_id', 'desc')
            ->get();

        $brand_product = DB::table('tbl_brand')
            ->where('brand_status', '0')
            ->orderBy('brand_id', 'desc')
            ->get();

        $all_product = DB::table('tbl_product')
            ->where('product_status', '0')
            ->orderBy('product_id', 'desc')
            ->get();

        return view('pages.shop')
            ->with('category', $cate_product)
            ->with('brand', $brand_product)
            ->with('all_product', $all_product);
    }

    public function contact()
    {
        $cate_product = DB::table('tbl_category_product')
            ->where('category_status', '0')
            ->orderBy('category_id', 'desc')
            ->get();

        $brand_product = DB::table('tbl_brand')
            ->where('brand_status', '0')
            ->orderBy('brand_id', 'desc')
            ->get();

        return view('pages.contact')
            ->with('category', $cate_product)
            ->with('brand', $brand_product);
    }
}
