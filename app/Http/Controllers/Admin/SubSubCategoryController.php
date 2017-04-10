<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use View;
use Redirect;
use App\Category;
use App\SubCategory;
use App\SubSubCategory;
use App\VehicleCompany;
use DB;
use Session;
use Yajra\Datatables\Facades\Datatables;

class SubSubCategoryController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request) {
        $subcategory_id = $request->get('subcategory_id');
        if ($request->ajax()) {
            $subsub_cat_result = DB::table('sub_sub_categories as ssc')
                    ->join('sub_categories as sc', 'sc.id', '=', 'ssc.sub_category_id')
                    ->join('vehicle_companies as vc', 'vc.id', '=', 'ssc.vehicle_company_id')
                    ->where('ssc.sub_category_id', $subcategory_id)
                    ->get(['ssc.*', 'sc.name as category_name', 'vc.name']);
            foreach ($subsub_cat_result as $key => $value) {
                $subsub_cat_result[$key]->action = '<a href="' . route('subsubcategories.show', $value->id) . '" data-toggle="tooltip" title="update" class="glyphicon glyphicon-edit"></a>&nbsp;&nbsp;<a href="' . route('subsubcategories.destroy', $value->id) . '" data-toggle="tooltip" title="delete" data-method="delete" class="glyphicon glyphicon-trash deleteRow"></a>';
                $subsub_cat_result[$key]->sub_category_name = $value->category_name . ' ' . $value->name;
            }
            return Datatables::of($subsub_cat_result)->make(true);
        }
    }

    /**
     * create a new file
     *
     * @return Response
     */
    public function create() {
        $title = 'SubSub-Categories | create';
        $sub_categories = SubCategory::orderBy('name')->pluck('name', 'id');
        $sub_categories->prepend('Select Sub Category', '');
        $vehicle_companies = VehicleCompany::orderBy('name')->pluck('name', 'id');
        $vehicle_companies->prepend('Select Vehicle Name', '');
        return View::make('admin.subsub_categories.add', compact('title', 'sub_categories', 'vehicle_companies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request) {
        $data = $request->all();
        $this->validate($request, [
            'sub_category_id' => 'required',
            'vehicle_company_id' => 'required'
        ]);

        SubSubCategory::create($data);
        return Redirect::back()
                        ->with('success-message', 'Sub Sub Category created successfully!');
    }

    /**
     * show sub category function.
     *
     * @return Response
     */
    public function showSubSubCategory($id) {
        $subcategory_id = $id;
        $title = 'SubSub-Categories | show';
        return View::make('admin.subsub_categories.index', compact('title', 'subcategory_id'));
    }

    /**
     * show function.
     *
     * @return Response
     */
    public function show(Request $request, $id) {
        $title = 'SubSub-Categories | update';
        $sub_categories = SubCategory::orderBy('name')->pluck('name', 'id');
        $sub_categories->prepend('Select Sub Category', '');
        $vehicle_companies = VehicleCompany::orderBy('name')->pluck('name', 'id');
        $vehicle_companies->prepend('Select Vehicle Name', '');
        $subsub_categories = SubSubCategory::where('id', $id)->first();
        return View::make('admin.subsub_categories.edit', compact('title', 'subsub_categories', 'sub_categories', 'vehicle_companies'));
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
            'sub_category_id' => 'required',
            'vehicle_company_id' => 'required'
        ]);

        $subsub_categories = SubSubCategory::find($id);

        if (!$subsub_categories) {
            return Redirect::back()
                            ->with('success-message', 'Something went wrong.Please try again later!');
        } else {
            $subsub_categories->fill($data)->save();
            return Redirect::back()
                            ->with('success-message', 'Sub sub category updated successfully!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        $subsub_categories = SubSubCategory::find($id);

        if (!$subsub_categories) {
            Session::flash('error-message', 'Something wrong .Please try again later!');
        } else {
            $subsub_categories->delete();
            Session::flash('success-message', 'Category deleted successfully !');
        }
        return 'true';
    }

}
