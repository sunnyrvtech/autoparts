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

    public function getSubSubcategory($slug) {

        $sub_categories = SubCategory::where('slug', $slug)->first();
        ProductSubCategory::where('subcategory_id',$sub_categories->id)->get();
//        if(!empty($sub_categories->sub_sub_categories->toArray())){
//            return View::make('categories.category', compact('sub_categories'));
//        }
        return 'hello';
       
    }

}
