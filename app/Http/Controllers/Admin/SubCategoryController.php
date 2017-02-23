<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use View;
use Redirect;
use App\Category;
use App\SubCategory;
use App\VehicleCompany;
use Yajra\Datatables\Facades\Datatables;
use DB;

class SubCategoryController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request) {

        $category_id = $request->all('category_id');

        if ($request->ajax()) {

            $sub_cat_result = DB::table('sub_categories as sc')
                    ->join('categories as c', 'c.id', '=', 'sc.category_id')
                    ->where('sc.category_id', $category_id)
                    ->get(['sc.*', 'c.name as category_name']);

            return Datatables::of($sub_cat_result)->make(true);
        }
    }

    /**
     * create a new file
     *
     * @return Response
     */
    public function create() {
        $title = 'Categories | create';
        $categories = Category::orderBy('name')->pluck('name', 'id');
        $categories->prepend('Select Category', '');
        //$vehicles = VehicleCompany::pluck('name', 'id');
        //$vehicles->prepend('Select Vehicle Make', '');
        return View::make('admin.sub_categories.add', compact('title', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request) {
        $data = $request->all();
        $this->validate($request, [
            'category_id' => 'required',
//            'vehicle_company_id' => 'required',
            'name' => 'required|unique:sub_categories|max:50'
//            'category_picture' => 'required'
        ]);

        if ($request->file('category_picture')) {
            if ($request->hasFile('category_picture')) {
                $image = $request->file('category_picture');
                $type = $image->getClientMimeType();
                if ($type == 'image/png' || $type == 'image/jpg' || $type == 'image/jpeg') {
                    $filename = time() . '.' . $image->getClientOriginalExtension();
                    $path = base_path('public/category/');
                    $image->move($path, $filename);
                    $data['category_image'] = $filename;
                }
            }
        }

        SubCategory::create($data);
        return Redirect::back()
                        ->with('success-message', 'Sub category inserted successfully!');
    }

    /**
     * show function.
     *
     * @return Response
     */
    public function show($id) {
        $category_id = $id;
        $title = 'Sub-Categories';
        return View::make('admin.sub_categories.index', compact('title', 'category_id'));
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
