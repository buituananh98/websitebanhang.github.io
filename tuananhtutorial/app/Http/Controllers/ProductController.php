<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();

class ProductController extends Controller
{
    public function add_product(){
        $cate_product = DB::table('tbl_category_product')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->orderby('brand_id','desc')->get();
        return view('admin.add_product')->with('cate_product',$cate_product)->with('brand_product',$brand_product); 
    }

    public function all_product(){

        $all_product = DB::table('tbl_product')->get();
        $manager_product = view('admin.all_product')->with('all_product',$all_product);
    	return view('admin_layout')->with('admin.all_product',$manager_product);
        
    }

    public function save_brand_product(Request $request){

        $this->validate($request,[
            'product_name' => 'required',
        ],[
            'product_name.required' => 'Tên sản phẩm Không được để trống',
        ]);


        $data = array();
        $data['product_name'] = $request->brand_product_name;
        $data['product_desc'] = $request->brand_product_desc;
        $data['product_status'] = $request->brand_product_status;
        $data['brand_status'] = $request->brand_product_status;
        $data['brand_status'] = $request->brand_product_status;


        DB::table('tbl_brand')->insert($data);
        Session::put('message','Thêm thương hiệu sản phẩm thành công');
        return Redirect::to('add-brand-product');
    }

    public function unactive_brand_product($brand_product_id){
        DB::table('tbl_brand')->where('brand_id',$brand_product_id)->update(['brand_status'=>1]);
        Session::put('message','Không kích hoạt thương hiệu sản phẩm thành công');
        return Redirect::to('all-brand-product');
    }

    public function active_brand_product($brand_product_id){
        DB::table('tbl_brand')->where('brand_id',$brand_product_id)->update(['brand_status'=>0]);
        Session::put('message','Kích hoạt thương hiệu sản phẩm thành công');
        return Redirect::to('all-brand-product');
    }

    public function edit_brand_product($brand_product_id){
        $edit_brand_product = DB::table('tbl_brand')->where('brand_id',$brand_product_id)->get();
        $manager_brand_product = view('admin.edit_brand_product')->with('edit_brand_product',$edit_brand_product);
        return view('admin_layout')->with('admin.edit_brand_product',$manager_brand_product);
    }
    public function update_brand_product(Request $request,$brand_product_id){
        $data = array();
        $data['brand_name'] = $request->brand_product_name;
        $data['brand_desc'] = $request->brand_product_desc;
        DB::table('tbl_brand')->where('brand_id',$brand_product_id)->update($data);
        Session::put('message','Cập nhập thương hiệu sản phẩm thành công');
        return Redirect::to('all-brand-product');
    }

    public function delete_brand_product($brand_product_id){
        DB::table('tbl_brand')->Where('brand_id',$brand_product_id)->delete();
        Session::put('message','Xóa thương hiệu sản phẩm thành công');
        return Redirect::to('all-brand-product');
    }	
}
