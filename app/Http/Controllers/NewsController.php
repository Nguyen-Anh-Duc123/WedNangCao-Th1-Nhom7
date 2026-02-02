<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class NewsController extends Controller
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

        $news = collect();
        if (Schema::hasTable('tbl_news')) {
            $news = DB::table('tbl_news')
                ->where('news_status', 1)
                ->orderBy('news_id', 'desc')
                ->get();
        }

        return view('pages.news.index')
            ->with('category', $cate_product)
            ->with('brand', $brand_product)
            ->with('news', $news);
    }

    public function show($news_slug)
    {
        $cate_product = DB::table('tbl_category_product')
            ->where('category_status', '0')
            ->orderBy('category_id', 'desc')
            ->get();

        $brand_product = DB::table('tbl_brand')
            ->where('brand_status', '0')
            ->orderBy('brand_id', 'desc')
            ->get();

        $news_item = null;
        if (Schema::hasTable('tbl_news')) {
            $news_item = DB::table('tbl_news')
                ->where('news_slug', $news_slug)
                ->where('news_status', 1)
                ->first();
        }

        return view('pages.news.show')
            ->with('category', $cate_product)
            ->with('brand', $brand_product)
            ->with('news_item', $news_item);
    }
}
