<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;
use App\Product;
use App\VehicleCompany;
use App\VehicleModel;
use App\Cart;
use App\SubCategory;
use Session;
use Auth;
use Carbon\Carbon;

class ProductController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request) {
        return View::make('products.index');
    }

    /**
     * Single product detail function.
     *
     * @return Response
     */
    public function singleProduct(Request $request, $slug) {
        $title = 'Products';
        $products = Product::where('product_slug', $slug)->first();
        return View::make('products.single', compact('title', 'products'));
    }

    /**
     * Cart function.
     *
     * @return Response
     */
    public function Cart() {
        if (Auth::check()) {
            $carts = Cart::where('user_id', Auth::id())->get(array('product_id', 'quantity', 'total_price'));
            if (empty($carts->toArray())) {
                $carts = array();
            }
        } else {
            if (Session::has('cartItem')) {
                $carts = json_decode(json_encode(Session::get('cartItem')));
            } else {
                $carts = array();
            }
        }
        if (!empty($carts)) {
            $cart_data = array();
            foreach ($carts as $key => $value) {
                $products = Product::where('id', $value->product_id)->first();
                $product_image = json_decode($products->product_details->product_images);

                $cart_data[$key] = array(
                    'product_name' => $products->product_name,
                    'product_image' => isset($product_image[0]) ? $product_image[0] : 'default.jpg',
                    'product_slug' => $products->product_slug,
                    'part_number' => $products->part_number,
                    'vehicle_company' => $products->get_vehicle_company->name,
                    'vehicle_model' => $products->get_vehicle_model->name,
                    'vehicle_year' => $products->vehicle_year,
                    'quantity' => $value->quantity,
                    'price' => $products->price,
                    'total_price' => $value->total_price,
                );
            }
        } else {
            $cart_data = array();
        }
        return View::make('carts.index', compact('cart_data'));
    }

    /**
     * Cart function.
     *
     * @return Response
     */
    public function addCart(Request $request) {
        $data = $request->all();
        //get product quantity and price based on product id
        $products = Product::select(array('id', 'price', 'quantity'))->find($data['product_id']);
        $data['quantity'] = isset($data['quantity']) ? (int) $data['quantity'] : 1;

        if (Auth::check()) {   ///  if user logged in then we insert his cart details in the database
            $data['user_id'] = Auth::id();
            // this is used to check if user already insert same item in the cart
            $cart = Cart::Where('user_id', $data['user_id'])->where('product_id', $data['product_id'])->first(array('id', 'quantity'));
            if ($cart) {
                $data['quantity'] = $cart->quantity + $data['quantity'];  // if item already exist then we update same product quantity with current quantity 
            }
            $data['total_price'] = $products->price * $data['quantity'];

            if ($data['quantity'] > $products->quantity) {  // this is used to check if product quantity less than the available quantity
                return response()->json(array('error' => 'Quantity should be less than available quantity'), 401);
            }
            if ($cart) {
                $cart->fill(array('quantity' => $data['quantity'], 'total_price' => $data['total_price']))->save();
            } else {
                Cart::create($data);
            }
        } else {
            $data_array = array(
                'product_id' => $data['product_id'],
                'quantity' => $data['quantity'],
                'total_price' => $products->price * $data['quantity'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            );

            if (Session::has('cartItem')) {
                $cart_array = Session::get('cartItem');
                $cart_array[] = $data_array;

                $merged = array();
                foreach ($cart_array as $key => $val) {   // this is used to check if same item is already exist in the session array
                    if (isset($merged[$val['product_id']])) {
                        $merged[$val['product_id']]['quantity'] += $val['quantity'];
                        if ($merged[$val['product_id']]['quantity'] > $products->quantity) {  // this is used to check if product quantity less than the available quantity
                            return response()->json(array('error' => 'Quantity should be less than available quantity'), 401);
                        }
                    } else {
                        $merged[$val['product_id']] = $val;
                    }
                }

                Session::put('cartItem', array_values($merged));
            } else {
                $cart_array[] = $data_array;
                Session::put('cartItem', $cart_array);
            }
            Session::save();
        }
        return response()->json(['success' => true, 'messages' => "Item Added to cart successfully!"]);
    }

    /**
     * function to get product vehicle data based on year.
     *
     * @return Response
     */
    public function getProductVehicleCompanyByYear(Request $request) {

        $year = $request->get('id');
        // get vehicle company data from product table and vehicle company table
        $vehicle_companies = Product::with(['get_vehicle_company' => function ($q) {
                        $q->select(['vehicle_companies.id', 'vehicle_companies.name']);
                    }])->where('products.vehicle_year', $year)->groupby('products.vehicle_make_id')->get(array('products.vehicle_make_id'));

        return $vehicle_companies;
    }

    /**
     * function to get product vehicle model based on make id.
     *
     * @return Response
     */
    public function getProductVehicleModelByMakeId(Request $request) {

        $make_id = $request->get('id');
        // get vehicle model data from product table and vehicle model table
        $vehicle_models = Product::with(['get_vehicle_model' => function ($q) {
                        $q->select(['vehicle_models.id', 'vehicle_models.name']);
                    }])->where('products.vehicle_make_id', $make_id)->groupby('products.vehicle_model_id')->get(array('products.vehicle_model_id'));

        return $vehicle_models;
    }

    /**
     * function for search product.
     *
     * @return Response
     */
    public function searchProduct(Request $request) {

        $title = 'Products | Search';


        $keyword = $request->input('q');

        if ($keyword != null) {
            $products = Product::whereHas('product_category.category', function($query) use($keyword) {
                        $query->where('categories.name', 'LIKE', '%' . $keyword . '%');
                    })->orWhereHas('get_brands', function ($query) use($keyword) {
                        $query->where('brands.name', 'LIKE', '%' . $keyword . '%');
                    })->orWhereHas('get_vehicle_company', function ($query) use($keyword) {
                        $query->where('vehicle_companies.name', 'LIKE', '%' . $keyword . '%');
                    })->orWhereHas('get_vehicle_model', function ($query) use($keyword) {
                        $query->where('vehicle_models.name', 'LIKE', '%' . $keyword . '%');
                    })->orWhere('products.product_name', 'LIKE', '%' . $keyword . '%')
                    ->paginate(15);
        } else {
            $whereCond = ['products.vehicle_year' => $request->input('year'), 'products.vehicle_make_id' => $request->input('make_id'), 'products.vehicle_model_id' => $request->input('model_id')];
            $products = Product::Where($whereCond)->paginate(15);
        }

        $all_categories = SubCategory::groupBy('name')->get();

        $view = View::make('products.search', compact('title', 'products', 'all_categories'));
        if ($request->wantsJson()) {
            $sections = $view->renderSections();
            return $sections['content'];
        }
        return $view;
    }

}
