<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;
use App\SubCategory;
use App\Brand;
use App\VehicleCompany;

class HomeController extends Controller {
    
    public function __construct()
    {
        $this->middleware('VerifyLoginStatus',['only'=>'index']);
    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request) {
        // get sub category data and make it featured category
        $featured_category = SubCategory::take(40)->get(array('name', 'id'));
        // get vehicle companies data
        $vehicles = VehicleCompany::get(array('name', 'id'));
        $brands = Brand::take(40)->get(array('name', 'id'));
        $view = View::make('index', compact('categories', 'featured_category','brands','vehicles'));
        if ($request->wantsJson()) {
            $sections = $view->renderSections();
            return $sections['content'];
        }
        return $view;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
//    public function store() {
//        
//    }
//
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
