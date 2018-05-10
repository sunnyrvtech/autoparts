<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\SubCategory;
//use App\ProductSubCategory;
use App\VehicleCompany;
use App\VehicleModel;

class SubCategoryController extends Controller {

    /**
     * function for getting sub sub category based on slug.
     *
     * @return Response
     */
    public function getListByCategorySlug(Request $request, $slug) {
        $title = 'Products';
        $sub_categories = SubCategory::where('slug', $slug)->first(array('id', 'name', 'slug'));
        if ($sub_categories) {
            $data['sub_categories'] = $sub_categories;
            $data['filter_title'] = $sub_categories->name;
            $data['bredcrum'] = '<span class="divider"> &gt; </span><span>' . $sub_categories->name . '</span>';
            $data['filter_data'] = Product::Where([['quantity', '>', 0], ['status', '=', 1], ['sub_category_id', '=', $sub_categories->id]])->groupBy('vehicle_make_id')->get(array('vehicle_make_id'));
        } else {
            $vehicle_company = VehicleCompany::where('name', 'like', $slug . '%')->first(array('id', 'name','slug'));
            if ($vehicle_company) {
                $data['filter_title'] = $vehicle_company->name;
                $data['bredcrum'] = '<span class="divider"> &gt; </span><span>' . $vehicle_company->name . '</span>';
                $data['vehicle_company'] = $vehicle_company;
                $data['filter_data'] = Product::with(['get_vehicle_company:id,name', 'get_vehicle_model:id,name'])->Where([['quantity', '>', 0], ['status', '=', 1], ['vehicle_make_id', '=', $vehicle_company->id]])->groupBy('vehicle_model_id')->get(array('vehicle_make_id', 'vehicle_model_id'));
            } else {
                return view('errors.404');
            }
        }
        return view('categories.category', $data);
    }

    public function getListByCategoryVehicleSlug(Request $request, $vehicle, $cat) {

        $sub_categories = SubCategory::where('slug', $cat)->first(array('id', 'name', 'slug'));
        $vehicle_company = VehicleCompany::where('slug', 'like', $vehicle . '%')->first(array('id', 'name','slug'));

        $data['vehicle_company'] = $vehicle_company;
        if ($sub_categories) {
            $data['filter_title'] = $vehicle_company->name . ' Parts:' . $sub_categories->name;
            $data['bredcrum'] = '<span class="divider"> &gt; </span><span><a href="' . url('/' . $vehicle_company->slug) . '">' . $vehicle_company->name . '</a></span><span class="divider"> &gt; </span><span>' . $sub_categories->name . '</span>';
            $data['sub_categories'] = $sub_categories;
            $data['filter_data'] = Product::Where([['quantity', '>', 0], ['status', '=', 1], ['vehicle_make_id', '=', $vehicle_company->id], ['sub_category_id', '=', $sub_categories->id]])->groupBy('vehicle_model_id')->get(array('vehicle_make_id', 'vehicle_model_id'));
        } else {
            $vehicle_model = VehicleModel::where('slug', 'like', $cat . '%')->first(array('id', 'name','slug'));
            $data['vehicle_model'] = $vehicle_model;
            $data['filter_title'] = $vehicle_company->name . ' ' . $vehicle_model->name . ' ' . 'Aftermarket Auto Parts';
            $data['bredcrum'] = '<span class="divider"> &gt; </span><span><a href="' . url('/' . $vehicle_company->slug) . '">' . $vehicle_company->name . '</a></span><span class="divider"> &gt; </span><span>' . $vehicle_model->name . '</span>';
            $data['filter_data'] = Product::Where([['quantity', '>', 0], ['status', '=', 1], ['vehicle_make_id', '=', $vehicle_company->id], ['vehicle_model_id', '=', $vehicle_model->id]])->groupBy('sub_category_id')->get(array('vehicle_make_id', 'vehicle_model_id', 'sub_category_id'));
        }
        return view('categories.category', $data);
    }

    public function getProductByCategoryVehicleModelSlug(Request $request, $vehicle, $model, $cat) {

        if (is_numeric($vehicle)) { ///   if the $vehicle slug is year then $model will be $vehicle and $cat will be $model
            $data['year'] = $vehicle;
            $vehicle_company = VehicleCompany::where('slug', 'like', $model . '%')->first(array('id', 'name','slug'));
            $vehicle_model = VehicleModel::where('slug', 'like', $cat . '%')->first(array('id', 'name','slug'));
            $data['vehicle_model'] = $vehicle_model;
            $data['filter_title'] = $data['year'].' '.$vehicle_company->name . ' ' . $vehicle_model->name . ' ' . 'Aftermarket Auto Parts';
            $data['bredcrum'] = '<span class="divider"> &gt; </span><span><a href="' . url('/' . $vehicle_company->slug) . '">' . $vehicle_company->name . '</a></span><span class="divider"> &gt; </span><span>' . $vehicle_model->name . '</span>';
            $data['filter_data'] = Product::Where([['products.vehicle_year_from', '<=', $data['year']], ['products.vehicle_year_to', '>=', $data['year']],['quantity', '>', 0], ['status', '=', 1],['vehicle_make_id', '=', $vehicle_company->id], ['vehicle_model_id', '=', $vehicle_model->id]])->groupBy('sub_category_id')->get(array('vehicle_make_id', 'vehicle_model_id', 'sub_category_id'));
            return view('categories.category', $data);
        }



        $sub_categories = SubCategory::where('slug', $cat)->first(array('id', 'name', 'slug'));
        $vehicle_model = VehicleModel::where('slug', 'like', $model . '%')->first(array('id', 'name','slug'));
        $vehicle_company = VehicleCompany::where('slug', 'like', $vehicle . '%')->first(array('id', 'name','slug'));
        $data['products'] = Product::with(['product_details', 'get_brands', 'get_vehicle_company', 'get_vehicle_model'])->where('sub_category_id', $sub_categories->id)->where([['vehicle_make_id', '=', $vehicle_company->id], ['vehicle_model_id', '=', $vehicle_model->id], ['sub_category_id', '=', $sub_categories->id]])->paginate(20);
        $data['all_categories'] = SubCategory::groupBy('name')->get();
        $data['filter_title'] = $vehicle_company->name . ' ' . $vehicle_model->name . ' Parts:' . $sub_categories->name;
        $data['bredcrum'] = '<span class="divider"> &gt; </span><span><a href="' . url('/' . $vehicle_company->slug) . '">' . $vehicle_company->name . '</a></span><span class="divider"> &gt; </span><span><a href="' . url('/' . $vehicle_company->slug . '/' . $vehicle_model->slug) . '">' . $vehicle_model->name . '</a></span><span class="divider"> &gt; </span><span>' . $sub_categories->name . '</span>';
        $view = view('products.index', $data);
        if ($request->wantsJson()) {
            $sections = $view->renderSections();
            return $sections['content'];
        }
        return $view;
    }

    public function getProductByYearCategoryVehicleModelSlug(Request $request, $year, $vehicle, $model, $cat) {

        $sub_categories = SubCategory::where('slug', $cat)->first(array('id', 'name', 'slug'));
        $vehicle_model = VehicleModel::where('slug', 'like', $model . '%')->first(array('id', 'name','slug'));
        $vehicle_company = VehicleCompany::where('slug', 'like', $vehicle . '%')->first(array('id', 'name','slug'));
        
        $data['year'] = $year;
        $data['vehicle_model'] = $vehicle_model;
        $data['vehicle_company'] = $vehicle_company;
        $data['products'] = Product::with(['product_details', 'get_brands', 'get_vehicle_company', 'get_vehicle_model'])->where([['vehicle_year_from', '<=', $year],['vehicle_year_to', '>=', $year],['vehicle_make_id', '=', $vehicle_company->id], ['vehicle_model_id', '=', $vehicle_model->id], ['sub_category_id', '=', $sub_categories->id]])->paginate(20);
        $data['all_categories'] = SubCategory::groupBy('name')->get();
        $data['filter_title'] = $year.' '.$vehicle_company->name . ' ' . $vehicle_model->name . ' Parts:' . $sub_categories->name;
        $data['bredcrum'] = '<span class="divider"> &gt; </span><span><a href="' . url('/' . $vehicle_company->name) . '">' . $vehicle_company->name . '</a></span><span class="divider"> &gt; </span><span><a href="' . url('/' . $vehicle_company->name . '/' . $vehicle_model->name) . '">' . $vehicle_model->name . '</a></span><span class="divider"> &gt; </span><span>' . $sub_categories->name . '</span>';
        $view = view('products.index', $data);
        if ($request->wantsJson()) {
            $sections = $view->renderSections();
            return $sections['content'];
        }
        return $view;
    }

}
