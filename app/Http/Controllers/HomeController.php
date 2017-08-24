<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;
use App\SubCategory;
use App\Brand;
use App\StaticPage;
use App\Product;
use App\State;
use App\ProductZone;
use Session;
use App\VehicleCompany;
use Mail;

class HomeController extends Controller {

    public function __construct() {
//       $this->middleware('VerifyLoginStatus', ['only' => 'index']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request) {
        // get sub category data and make it featured category
//        $featured_category = SubCategory::take(40)->get(array('name', 'id', 'slug'));
        // get vehicle companies data
        $vehicles = VehicleCompany::get(array('name', 'id'));
        $brands = Brand::take(40)->get(array('name', 'id'));

        $latest_product = Product::Where('quantity', '>', 0)->orderBy('updated_at', 'DESC')->take('20')->get();
//        echo "<pre>";
//        print_r($latest_product->toArray());
//        die;
        $view = View::make('index', compact('categories', 'featured_category', 'brands', 'vehicles', 'latest_product'));
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
    public function getAboutUs() {
        $about_content = StaticPage::where('slug', 'about-us')->first();
        return View::make('about-us', compact('about_content'));
    }

    public function getFaq() {
        $faq_content = StaticPage::where('slug', 'faq')->first();
        return View::make('faq', compact('faq_content'));
    }

    public function getContactUs() {
        return View::make('contact-us');
    }

    public function getlocalRegion(Request $request) {
        $address = $request->get('address');

        $states = State::Where('postal_code', 'like', trim($address))->first(array('id'));
        if ($states) {
            $regrex = '"([^"]*)' . $states->id . '([^"]*)"';
            $regions = ProductZone::whereRaw("state_id REGEXP '" . $regrex . "'")->first(array('id','state_id'));
            if ($regions) {
                ////$region = DB::select("SELECT * FROM product_zones WHERE state_id REGEXP"."'".$regrex."'");
                Session::put('local_region_data', $regions->toArray());
            }
        }
    }

    public function postContactUs(Request $request) {

        $data = $request->all();

        Mail::send('auth.emails.contact', $data, function($message) {
            $message->from('test4rvtech@gmail.com', " Welcome To Autolighthouse");
            $message->to('sunny_kumar@rvtechnologies.co.in')->subject('Autolighthouse inquiry email !!!');
        });
    }

}
