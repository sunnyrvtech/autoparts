<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use View;
use Redirect;
use App\Brand;
use Session;
use Yajra\Datatables\Facades\Datatables;

class BrandController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request) {
        $title = 'Brands';
        if ($request->ajax()) {

            $brands = Brand::get();
            foreach ($brands as $key => $value) {
                $brands[$key]['action'] = '<a href="' . route('brands.show', $value->id) . '" data-toggle="tooltip" title="update" class="glyphicon glyphicon-edit"></a>&nbsp;&nbsp;<a href="' . route('brands.destroy', $value->id) . '" data-toggle="tooltip" title="delete" data-method="delete" class="glyphicon glyphicon-trash deleteRow"></a>';
            }
            return Datatables::of($brands)->make(true);
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
                    $path = base_path('public/brand_images/');
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
        $title = 'Brands | update';
        $brands = Brand::where('id', $id)->first();
        return View::make('admin.brands.edit', compact('title', 'brands'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id) {
        $data = $request->all();
        $this->validate($request, [
            'name' => 'required|max:100|unique:brands,name,' . $id
//            'brand_picture'=>'required'
        ]);
        if ($request->file('brand_picture')) {
            if ($request->hasFile('brand_picture')) {
                $image = $request->file('brand_picture');
                $type = $image->getClientMimeType();
                if ($type == 'image/png' || $type == 'image/jpg' || $type == 'image/jpeg') {
                    $filename = time() . '.' . $image->getClientOriginalExtension();
                    $path = base_path('public/brand_images/');
                    $image->move($path, $filename);
                    $data['brand_image'] = $filename;
                }
            }
        }

        $brands = Brand::findOrFail($id);
        $brands->fill($data)->save();
        return Redirect::back()
                        ->with('success-message', 'Record updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        $brands = Brand::find($id);
        if (!$brands) {
            Session::flash('error-message', 'Something went wrong.Please try again later!');
        } else {
            $brands->delete();
            Session::flash('success-message', 'Record deleted successfully!');
        }
        return 'true';
    }

}
