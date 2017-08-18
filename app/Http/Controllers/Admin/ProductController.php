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
use App\ProductZone;
use App\ProductPriceZone;
use App\Category;
use App\SubCategory;
use App\SubSubCategory;
use App\ProductCategory;
use App\ProductSubCategory;
use App\ProductSubSubCategory;
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
        if ($request->ajax()) {
           // $skip = $request->get('start') != null ? $request->get('start') : 0;
           // $take = $request->get('length') != null ? $request->get('length') : 10;
            //$products = Product::skip($skip)->take($take)->get();
            $products = Product::all();
//            $count = Product::get()->count();
            foreach ($products as $key => $value) {
                $products[$key]['action'] = '<a href="' . route('products.show', $value->id) . '" data-toggle="tooltip" title="update" class="glyphicon glyphicon-edit"></a>&nbsp;&nbsp;<a href="' . route('products.destroy', $value->id) . '" data-toggle="tooltip" title="delete" data-method="delete" class="glyphicon glyphicon-trash deleteRow"></a>';
            }
            return Datatables::of($products)->make(true);
//            return Datatables::of($products)->setTotalRecords($count)->make(true);
//            return Datatables::of($products)->with(['recordsTotal' => $count, 'recordsFiltered' => $count, 'start' => 20])->make(true);
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
        $brands = Brand::pluck('name', 'id')->prepend('---Please Select---', '');
        $vehicle_model = VehicleModel::pluck('name', 'id')->prepend('---Please Select---', '');
        $vehicle_company = VehicleCompany::pluck('name', 'id')->prepend('---Please Select---', '');
        $product_zones = ProductZone::pluck('zone_name', 'id')->prepend('---Please Select---', '');
        return View::make('admin.products.add', compact('title', 'brands', 'vehicle_model', 'vehicle_company', 'product_zones'));
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
            'product_long_description' => 'required',
            'sku' => 'required|max:50|unique:products',
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

        $products = Product::create($data);

        if ($products) {
            $data['product_id'] = $products->id;
            //  insert other product details in product detail table
            ProductDetail::create($data);

            //insert price based on zones
            if ($request->get('zone_id')[0] != null) {
                $zone_ids = array_unique($data['zone_id']);
                foreach ($zone_ids as $ky => $val) {
                    $region_array = array('product_id' => $products->id, 'zone_id' => $val, 'product_price' => $data['product_price'][$ky]);
                    ProductPriceZone::create($region_array);
                }
            }

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
//            if ($request->get('sub_sub_category') != '') {
//                $sub_sub_category_array = array();
//                foreach ($request->get('sub_sub_category') as $sub_sub_cat_key => $sub_sub_cat_val) {
//                    $sub_sub_category_array[$sub_sub_cat_key] = array('product_id' => $products->id, 'sub_sub_category_id' => $sub_sub_cat_val);
//                }
//                ProductSubSubCategory::insert($sub_sub_category_array);
//            }
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
        $product_categories = array();
        foreach ($products->product_categories as $cat_key => $value) {
            $product_categories[$cat_key] = $value->category_id;
        }
        $product_sub_categories = array();
        foreach ($products->product_sub_categories as $sub_cat_key => $value) {
            $product_sub_categories[$sub_cat_key] = $value->sub_category_id;
        }
//        $product_sub_sub_categories = array();
//        foreach ($products->product_sub_sub_categories as $sub_sub_cat_key => $value) {
//            $product_sub_sub_categories[$sub_sub_cat_key] = $value->sub_sub_category_id;
//        }
        $brands = Brand::pluck('name', 'id')->prepend('---Please Select---', '');
        $vehicle_model = VehicleModel::pluck('name', 'id')->prepend('---Please Select---', '');
        $vehicle_company = VehicleCompany::pluck('name', 'id')->prepend('---Please Select---', '');
        $product_zones = ProductZone::pluck('zone_name', 'id')->prepend('---Please Select---', '');
        return View::make('admin.products.edit', compact('title', 'products', 'brands', 'vehicle_model', 'vehicle_company', 'product_categories', 'product_sub_categories', 'product_zones'));
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
            'product_long_description' => 'required',
            'sku' => 'required|max:50|unique:products,sku,'.$id,
            'quantity' => 'required|numeric',
            'status' => 'required',
        ]);


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
                $imageArray = array();
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
        $products->fill($data)->save();
        //saved other product details 
        $product_details = ProductDetail::where('product_id', $products->id);
        if ($product_details->count()) {
            $product_details = $product_details->first();
            $product_details->fill($data)->save();
        }
        ProductCategory::where('product_id', $products->id)->delete();
        ProductSubCategory::where('product_id', $products->id)->delete();


        //update price based on zones
        if ($request->get('zone_id')[0] != null) {
            
            $old_price_data = ProductPriceZone::where('product_id', $products->id)->pluck('zone_id')->toArray();

            // this is used to check if old region is deleted while update
            $check_del_zone_price = array_diff($old_price_data, $request->get('zone_id'));
            if ($check_del_zone_price) {
                ProductPriceZone::whereIn('zone_id', $check_del_zone_price)->delete();
            }
            foreach ($data['zone_id'] as $ky => $val) {
                $product_price_zone = ProductPriceZone::where([['product_id', '=', $products->id], ['zone_id', '=', $val]]);
                if ($product_price_zone->count()) {
                    $product_price_zone = $product_price_zone->first();
                    $product_price_zone->fill(array('product_price' => $data['product_price'][$ky]))->save();
                } else {
                    $region_array = array('product_id' => $products->id, 'zone_id' => $val, 'product_price' => $data['product_price'][$ky]);
                    ProductPriceZone::create($region_array);
                }
            }
        }

//        ProductSubSubCategory::where('product_id', $products->id)->delete();
        //update category details in product category table
        if ($request->get('parent_category') != '') {
            $parent_category_array = array();
            foreach ($request->get('parent_category') as $cat_key => $cat_val) {
                $parent_category_array[$cat_key] = array('product_id' => $products->id, 'category_id' => $cat_val);
            }
            ProductCategory::insert($parent_category_array);
        }
        //update sub category details in product category table
        if ($request->get('sub_category') != '') {
            $sub_category_array = array();
            foreach ($request->get('sub_category') as $sub_cat_key => $sub_cat_val) {
                $sub_category_array[$sub_cat_key] = array('product_id' => $products->id, 'sub_category_id' => $sub_cat_val);
            }
            ProductSubCategory::insert($sub_category_array);
        }
        //insert sub sub category details in product category table
//        if ($request->get('sub_sub_category') != '') {
//            $sub_sub_category_array = array();
//            foreach ($request->get('sub_sub_category') as $sub_sub_cat_key => $sub_sub_cat_val) {
//                $sub_sub_category_array[$sub_sub_cat_key] = array('product_id' => $products->id, 'sub_sub_category_id' => $sub_sub_cat_val);
//            }
//            ProductSubSubCategory::insert($sub_sub_category_array);
//        }

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
