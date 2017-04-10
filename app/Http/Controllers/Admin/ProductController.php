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
use App\SubSubCategory;
use App\ProductCategory;
use App\ProductSubCategory;
use App\ProductSubSubCategory;
use Redirect;
use Yajra\Datatables\Facades\Datatables;

class ProductController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request) {
        $title = 'Products';
        if ($request->ajax()) {
            return Datatables::of(Product::query())->make(true);
        }
        return View::make('admin.products.index', compact('title'));
    }

    /**
     * create a new file
     *
     * @return Response
     */
    public function create() {
        $title = 'Products | Add';
        return View::make('admin.products.add', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request) {
        $data = $request->all();
        $this->validate($request, [
            'product_name' => 'required|max:50',
            'price' => 'required|numeric',
            'product_long_description' => 'required|max:50',
            'part_number' => 'required|max:50',
            'quantity' => 'required|numeric',
            'status' => 'required',
        ]);

        //set null value in the empty string
        foreach ($data as $key => $value) {
            $data[$key] = empty($value) ? null : $value;
        }


        if ($request->file('product_images')) {
            if ($request->hasFile('product_images')) {
                $image = $request->file('product_images');
                $imageArray = array();
                $path = base_path('public/products/');
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

        $products = Product::create($data);

        if ($products) {
            $data['product_id'] = $products->id;
            //  insert other product details in product detail table
            ProductDetail::create($data);
            //insert category details in product category table
            if ($request->get('parent_category') != '') {
                $parent_category_array = array();
                foreach ($request->get('parent_category') as $cat_key => $cat_val) {
                    $parent_category_array[$cat_key] = array('product_id' => $products->id, 'category_id' => $cat_val);
                }
                ProductCategory::insert($parent_category_array);
            }
            //insert sub category details in product category table
            if ($request->get('sub_category') != '') {
                $sub_category_array = array();
                foreach ($request->get('sub_category') as $sub_cat_key => $sub_cat_val) {
                    $sub_category_array[$sub_cat_key] = array('product_id' => $products->id, 'sub_category_id' => $sub_cat_val);
                }
                ProductSubCategory::insert($sub_category_array);
            }
            //insert sub sub category details in product category table
            if ($request->get('sub_sub_category') != '') {
                $sub_sub_category_array = array();
                foreach ($request->get('sub_sub_category') as $sub_sub_cat_key => $sub_sub_cat_val) {
                    $sub_sub_category_array[$sub_sub_cat_key] = array('product_id' => $products->id, 'sub_sub_category_id' => $sub_sub_cat_val);
                }
                ProductSubSubCategory::insert($sub_sub_category_array);
            }
        }

        return Redirect::back()
                        ->with('success-message', 'Product inserted successfully!');
    }

    /**
     * show function.
     *
     * @return Response
     */
    public function show($id) {
        $title = 'Products | update';
        $products = Product::where('id', $id)->first();
        $product_categories = array();
        foreach ($products->product_categories as $cat_key => $value) {
            $product_categories[$cat_key] = $value->category_id;
        }
        $product_sub_categories = array();
        foreach ($products->product_sub_categories as $sub_cat_key => $value) {
            $product_sub_categories[$sub_cat_key] = $value->sub_category_id;
        }
        $product_sub_sub_categories = array();
        foreach ($products->product_sub_sub_categories as $sub_sub_cat_key => $value) {
            $product_sub_sub_categories[$sub_sub_cat_key] = $value->sub_sub_category_id;
        }
        $brands = Brand::pluck('name', 'id')->prepend('---Please Select---', '');
        $vehicle_model = VehicleModel::pluck('name', 'id')->prepend('---Please Select---', '');
        $vehicle_company = VehicleCompany::pluck('name', 'id')->prepend('---Please Select---', '');
        return View::make('admin.products.edit', compact('title', 'products', 'brands', 'vehicle_model', 'vehicle_company', 'product_categories', 'product_sub_categories', 'product_sub_sub_categories'));
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
            'product_name' => 'required|max:50',
            'price' => 'required|numeric',
            'product_long_description' => 'required|max:50',
            'part_number' => 'required|max:50',
            'quantity' => 'required|numeric',
            'status' => 'required',
        ]);


        //set null value in the empty string
        foreach ($data as $key => $value) {
            $data[$key] = empty($value) ? null : $value;
        }

        $existing_product_images = ProductDetail::where('id', $id)->first(array('product_images'));
        $existing_product_image_array = json_decode($existing_product_images->product_images, true);
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
                    @unlink(base_path('public/products/') . $exist_val);
                }
            }
        }

        if ($request->file('product_images')) {
            if ($request->hasFile('product_images')) {
                $image = $request->file('product_images');
                $imageArray = array();
                $path = base_path('public/products/');
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
        $products->fill($data)->save();

        $product_details = ProductDetail::findOrFail($id);
        $product_details->fill($data)->save();

        ProductCategory::where('product_id', $products->id)->delete();
        ProductSubCategory::where('product_id', $products->id)->delete();
        ProductSubSubCategory::where('product_id', $products->id)->delete();
        //insert category details in product category table
        if ($request->get('parent_category') != '') {
            $parent_category_array = array();
            foreach ($request->get('parent_category') as $cat_key => $cat_val) {
                $parent_category_array[$cat_key] = array('product_id' => $products->id, 'category_id' => $cat_val);
            }
            ProductCategory::insert($parent_category_array);
        }
        //insert sub category details in product category table
        if ($request->get('sub_category') != '') {
            $sub_category_array = array();
            foreach ($request->get('sub_category') as $sub_cat_key => $sub_cat_val) {
                $sub_category_array[$sub_cat_key] = array('product_id' => $products->id, 'sub_category_id' => $sub_cat_val);
            }
            ProductSubCategory::insert($sub_category_array);
        }
        //insert sub sub category details in product category table
        if ($request->get('sub_sub_category') != '') {
            $sub_sub_category_array = array();
            foreach ($request->get('sub_sub_category') as $sub_sub_cat_key => $sub_sub_cat_val) {
                $sub_sub_category_array[$sub_sub_cat_key] = array('product_id' => $products->id, 'sub_sub_category_id' => $sub_sub_cat_val);
            }
            ProductSubSubCategory::insert($sub_sub_category_array);
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
//    public function destroy($id) {
//        
//    }
}
