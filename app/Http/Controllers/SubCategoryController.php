<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SubCategory;
use App\ProductSubCategory;
use App\Brand;
use View;

class SubCategoryController extends Controller {

    /**
     * function for getting sub sub category based on slug.
     *
     * @return Response
     */
    public function getProductByCategorySlug(Request $request,$slug) {
        $title = 'Products';
        $sub_categories = SubCategory::where('slug', $slug)->first();
        $products = ProductSubCategory::with(['getProducts','getProducts.product_details','getProducts.get_brands','getProducts.get_vehicle_company','getProducts.get_vehicle_model'])->whereHas('getProducts', function($query) {
                        $query->where('products.quantity', '>',0);
        })->where('sub_category_id', $sub_categories->id)->paginate(20);
        $all_categories = SubCategory::groupBy('name')->get();
        $view = View::make('products.index', compact('title', 'products','all_categories'));
        if ($request->wantsJson()) {
            $sections = $view->renderSections();
            return $sections['content'];
        }
        return $view;
    }

}
