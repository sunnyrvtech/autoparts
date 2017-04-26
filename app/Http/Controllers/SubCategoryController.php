<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SubCategory;
use App\ProductSubCategory;
use View;

class SubCategoryController extends Controller {

    /**
     * function for getting sub sub category based on slug.
     *
     * @return Response
     */
    public function getSubSubcategory(Request $request,$slug) {
        $title = 'Products';
        $sub_categories = SubCategory::where('slug', $slug)->first();
        $products = ProductSubCategory::where('sub_category_id', $sub_categories->id)->paginate(15);


        $view = View::make('products.index', compact('title', 'products'));
        if ($request->wantsJson()) {
            $sections = $view->renderSections();
            return $sections['content'];
        }
        return $view;
    }

}
