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

        $products = Product::create($data);

        if ($products) {
            $data['product_id'] = $products->id;
            ProductDetail::create($data);
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
        $products = Product::with('product_details')->where('id', $id)->first();
        $brands = Brand::pluck('name','id')->prepend('---Please Select---','');
        $vehicle_model = VehicleModel::pluck('name','id')->prepend('---Please Select---','');
        $vehicle_company = VehicleCompany::pluck('name','id')->prepend('---Please Select---','');
        return View::make('admin.products.edit', compact('title', 'products','brands','vehicle_model','vehicle_company'));
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

        $products->fill($data)->save();
        
        $product_details = ProductDetail::findOrFail($id);
        $product_details->fill($data)->save();
        
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
