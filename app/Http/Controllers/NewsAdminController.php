<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class NewsAdminController extends Controller
{
    public function AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }

    public function add_news(){
        $this->AuthLogin();
        return view('admin.add_news');
    }

    public function all_news(){
        $this->AuthLogin();
        $all_news = DB::table('tbl_news')->orderBy('news_id','desc')->get();
        $manager_news = view('admin.all_news')->with('all_news', $all_news);
        return view('admin_layout')->with('admin.all_news', $manager_news);
    }

    public function save_news(Request $request){
        $this->AuthLogin();
        $data = array();
        $data['news_title'] = $request->news_title;
        $data['news_slug'] = $request->news_slug;
        $data['news_category'] = $request->news_category;
        $data['news_summary'] = $request->news_summary;
        $data['news_content'] = $request->news_content;
        $data['news_status'] = $request->news_status;

        $get_image = $request->file('news_image');
        if ($get_image && $get_image->isValid()) {
            $uploadPath = public_path('uploads/news');
            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }
            $new_image = time().'_'.uniqid().'.'.$get_image->getClientOriginalExtension();
            $get_image->move($uploadPath, $new_image);
            $data['news_image'] = $new_image;
        } else {
            $data['news_image'] = '';
        }

        DB::table('tbl_news')->insert($data);
        Session::put('message','Thêm tin tức thành công');
        return Redirect::to('add-news');
    }

    public function edit_news($news_id){
        $this->AuthLogin();
        $edit_news = DB::table('tbl_news')->where('news_id',$news_id)->get();
        $manager_news = view('admin.edit_news')->with('edit_news', $edit_news);
        return view('admin_layout')->with('admin.edit_news', $manager_news);
    }

    public function update_news(Request $request, $news_id){
        $this->AuthLogin();
        $data = array();
        $data['news_title'] = $request->news_title;
        $data['news_slug'] = $request->news_slug;
        $data['news_category'] = $request->news_category;
        $data['news_summary'] = $request->news_summary;
        $data['news_content'] = $request->news_content;
        $data['news_status'] = $request->news_status;

        $get_image = $request->file('news_image');
        if ($get_image && $get_image->isValid()) {
            $uploadPath = public_path('uploads/news');
            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }
            $new_image = time().'_'.uniqid().'.'.$get_image->getClientOriginalExtension();
            $get_image->move($uploadPath, $new_image);
            $data['news_image'] = $new_image;
        }

        DB::table('tbl_news')->where('news_id',$news_id)->update($data);
        Session::put('message','Cập nhật tin tức thành công');
        return Redirect::to('all-news');
    }

    public function delete_news($news_id){
        $this->AuthLogin();
        DB::table('tbl_news')->where('news_id',$news_id)->delete();
        Session::put('message','Xóa tin tức thành công');
        return Redirect::to('all-news');
    }

    public function unactive_news($news_id){
        $this->AuthLogin();
        DB::table('tbl_news')->where('news_id',$news_id)->update(['news_status'=>0]);
        Session::put('message','Ẩn tin tức thành công');
        return Redirect::to('all-news');
    }

    public function active_news($news_id){
        $this->AuthLogin();
        DB::table('tbl_news')->where('news_id',$news_id)->update(['news_status'=>1]);
        Session::put('message','Hiển thị tin tức thành công');
        return Redirect::to('all-news');
    }
}
