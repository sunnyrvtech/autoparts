<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use View;
use Redirect;
use App\Brand;
use Yajra\Datatables\Facades\Datatables;

class BrandController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request) {
        $title = 'Brands';
        if ($request->ajax()) {
            return Datatables::of(Brand::query())->make(true);
        }
        return View::make('admin.brands.index', compact('title'));
    }

    /**
     * create a new file
     *
     * @return Response
     */
    public function create() {
        $title = 'Brands';
        return View::make('admin.brands.add', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request) {
        $data = $request->all();
        $this->validate($request, [
            'name' => 'required|unique:brands|max:50'
//            'brand_picture'=>'required'
        ]);
        if ($request->file('brand_picture')) {
            if ($request->hasFile('brand_picture')) {
                $image = $request->file('brand_picture');
                $type = $image->getClientMimeType();
                if ($type == 'image/png' || $type == 'image/jpg' || $type == 'image/jpeg') {
                    $filename = time() . '.' . $image->getClientOriginalExtension();
                    $path = base_path('public/brands/');
                    $image->move($path, $filename);
                    $data['brand_image'] = $filename;
                }
            }
        }
        Brand::create($data);
        return Redirect::back()
                        ->with('success-message', 'Record inserted successfully!');
    }

    /**
     * show function.
     *
     * @return Response
     */
    public function show(Request $request, $id) {
        
    }

//    /**
//     * Update the specified resource in storage.
//     *
//     * @param  int  $id
//     * @return Response
//     */
//    public function update($id) {
//        
//    }
//
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
