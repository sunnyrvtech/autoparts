<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use View;
use App\Product;
use App\ProductDetail;
use App\Brand;
use App\VehicleModel;
use App\VehicleCompany;
use App\Category;
use App\SubCategory;
use Redirect;
use Session;
use Carbon\Carbon;
use Yajra\Datatables\Facades\Datatables;

class ProductController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request) {
        $title = 'Products';
        $sku = $request->get('sku');
        $products = Product::Where(function($query) use ($sku) {
                    if ($sku != null) {
                        $query->Where('sku', 'like', trim($sku));
                    }
                })->paginate(20);
        return View::make('admin.products.index', compact('title', 'products'));
    }

    /**
     * create a new file
     *
     * @return Response
     */
    public function create() {
        $title = 'Products | Add';
        $brands = Brand::pluck('name', 'id')->prepend('---Please Select---', '');
        $vehicle_model = VehicleModel::pluck('name', 'id')->prepend('---Please Select---', '');
        $vehicle_company = VehicleCompany::pluck('name', 'id')->prepend('---Please Select---', '');
//        $product_zones = ProductZone::pluck('zone_name', 'id')->prepend('---Please Select---', '');
        return View::make('admin.products.add', compact('title', 'brands', 'vehicle_model', 'vehicle_company'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request) {
        $data = $request->all();
        $this->validate($request, [
            'product_name' => 'required|max:200',
            'price' => 'required|numeric',
//            'product_long_description' => 'required',
            'sku' => 'required|max:50|unique:products',
            'quantity' => 'required|numeric',
            'status' => 'required',
        ]);

        $search_keyword = $data['product_name'];
        if($request->get('parse_link') != null){
            $search_keyword = $search_keyword.' '.$data['parse_link'];
        }
        if($request->get('oem_number') != null){
            $search_keyword = $search_keyword.' '.$data['oem_number'];
        }
        if($request->get('parent_category') != null){
           $search_keyword = $search_keyword.' '.Category::Where('id',$request->get('parent_category'))->first(array('name'))->name;
        }
        if($request->get('sub_category') != null){
           $search_keyword = $search_keyword.' '.SubCategory::Where('id',$request->get('sub_category'))->first(array('name'))->name;
        }
        if($request->get('vehicle_model_id') != null){
           $search_keyword = $search_keyword.' '.VehicleModel::Where('id',$request->get('vehicle_model_id'))->first(array('name'))->name;
        }
        if($request->get('vehicle_make_id') != null){
           $search_keyword = $search_keyword.' '.VehicleCompany::Where('id',$request->get('vehicle_make_id'))->first(array('name'))->name;
        }
        if($request->get('meta_keyword') != null){
           $search_keyword = $search_keyword.' '.str_replace("," , " " , $data['meta_keyword']);
        }
        if($request->get('google_category') != null){
           $data['google_category'] = htmlentities($request->get('google_category'));
        }

        $data['keyword_search'] = substr($search_keyword, 0, 255);

        //set null value in the empty string
        foreach ($data as $key => $value) {
            $data[$key] = empty($value) ? null : $value;
        }
        if ($request->file('product_images')) {
            if ($request->hasFile('product_images')) {
                $image = $request->file('product_images');
                $imageArray = array();
                $path = base_path('public/product_images/');
                foreach ($image as $key => $image_val) {
                    $type = $image_val->getClientMimeType();
                    if ($type == 'image/png' || $type == 'image/jpg' || $type == 'image/jpeg') {
                        $filename = str_random(15) . '.' . $image_val->getClientOriginalExtension();
                        $image_val->move($path, $filename);
                        $imageArray[$key] = $filename;
                    }
                }
                $data['product_images'] = json_encode($imageArray);
            }
        }

        $data['category_id'] = $request->get('parent_category');
        $data['sub_category_id'] = $request->get('sub_category');
        $products = Product::create($data);

        if ($products) {
            $data['product_id'] = $products->id;
            //  insert other product details in product detail table
            ProductDetail::create($data);
        }
        return redirect()->route('products.index')->with('success-message', 'Product inserted successfully!');
    }

    /**
     * show function.
     *
     * @return Response
     */
    public function show($id) {
        $title = 'Products | update';
        $products = Product::where('id', $id)->first();
        $brands = Brand::pluck('name', 'id')->prepend('---Please Select---', '');
        $vehicle_model = VehicleModel::pluck('name', 'id')->prepend('---Please Select---', '');
        $vehicle_company = VehicleCompany::pluck('name', 'id')->prepend('---Please Select---', '');
//        $product_zones = ProductZone::pluck('zone_name', 'id')->prepend('---Please Select---', '');
        return View::make('admin.products.edit', compact('title', 'products', 'brands', 'vehicle_model', 'vehicle_company'));
    }

//    /**
//     * Update the specified resource in storage.
//     *
//     * @param  int  $id
//     * @return Response
//     */
    public function update(Request $request, $id) {

        $products = Product::findOrFail($id);
        $data = $request->all();

        $this->validate($request, [
            'product_name' => 'required|max:200',
            'price' => 'required|numeric',
//            'product_long_description' => 'required',
            'sku' => 'required|max:50|unique:products,sku,' . $id,
            'quantity' => 'required|numeric',
            'status' => 'required',
        ]);
        $search_keyword = $data['product_name'];
        if($request->get('parse_link') != null){
            $search_keyword = $search_keyword.' '.$data['parse_link'];
        }
        if($request->get('oem_number') != null){
            $search_keyword = $search_keyword.' '.$data['oem_number'];
        }
        if($request->get('parent_category') != null){
           $search_keyword = $search_keyword.' '.Category::Where('id',$request->get('parent_category'))->first(array('name'))->name;
        }
        if($request->get('sub_category') != null){
           $search_keyword = $search_keyword.' '.SubCategory::Where('id',$request->get('sub_category'))->first(array('name'))->name;
        }
        if($request->get('vehicle_model_id') != null){
           $search_keyword = $search_keyword.' '.VehicleModel::Where('id',$request->get('vehicle_model_id'))->first(array('name'))->name;
        }
        if($request->get('vehicle_make_id') != null){
           $search_keyword = $search_keyword.' '.VehicleCompany::Where('id',$request->get('vehicle_make_id'))->first(array('name'))->name;
        }
        if($request->get('meta_keyword') != null){
           $search_keyword = $search_keyword.' '.str_replace("," , " " , $data['meta_keyword']);
        }
        if($request->get('google_category') != null){
           $data['google_category'] = htmlentities($request->get('google_category'));
        }

        $data['keyword_search'] = substr($search_keyword, 0, 255);

        //set null value in the empty string
        foreach ($data as $key => $value) {
            $data[$key] = empty($value) ? null : $value;
        }

        $data['status'] = $data['status'] != null ? 1 : 0;
        $existing_product_images = ProductDetail::where('product_id', $id)->first(array('product_images'));
        $existing_product_image_array = json_decode(@$existing_product_images->product_images, true);
        $old_image_data = $request->get('old_product_image');
        if ($old_image_data == '') {
            $old_image_data = array();
            $imageArray = $old_image_data;
        } else {
            $imageArray = $old_image_data;
        }

        if ($existing_product_image_array != '') {
            foreach ($existing_product_image_array as $exist_val) {
                if (!in_array($exist_val, $old_image_data)) {
                    @unlink(base_path('public/product_images/') . $exist_val);
                }
            }
        }
        if ($request->file('product_images')) {
            if ($request->hasFile('product_images')) {
                $image = $request->file('product_images');
                $path = base_path('public/product_images/');
                foreach ($image as $key => $image_val) {
                    $count_key = $key + count($old_image_data);
                    $type = $image_val->getClientMimeType();
                    if ($type == 'image/png' || $type == 'image/jpg' || $type == 'image/jpeg') {
                        $filename = str_random(15) . '.' . $image_val->getClientOriginalExtension();
                        $image_val->move($path, $filename);
                        $imageArray[$count_key] = $filename;
                    }
                }
            }
        }
        if (empty($imageArray)) {
            $data['product_images'] = null;
        } else {
            $data['product_images'] = json_encode($imageArray);
        }
        $data['category_id'] = $request->get('parent_category');
        $data['sub_category_id'] = $request->get('sub_category');

        $products->fill($data)->save();
        //saved other product details
        $product_details = ProductDetail::where('product_id', $products->id);
        if ($product_details->count()) {
            $product_details = $product_details->first();
            $product_details->fill($data)->save();
        }
        return Redirect::back()
                        ->with('success-message', 'Product updated successfully!');
    }

//    /**
//     * Remove the specified resource from storage.
//     *
//     * @param  int  $id
//     * @return Response
//     */
    public function destroy($id) {
        $products = Product::find($id);

        if (!$products) {
            Session::flash('error-message', 'Something went wrong .Please try again later!');
        } else {
            $products->delete();
            Session::flash('success-message', 'Product deleted successfully !');
        }
        return 'true';
    }

}
