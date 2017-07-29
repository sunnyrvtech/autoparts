<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;
use App\Product;
use App\VehicleCompany;
use App\VehicleModel;
use App\Cart;
use App\ShippingMethod;
use App\ShippingRate;
use App\SubCategory;
use App\ShippingAddress;
use App\ProductSubCategory;
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
        if ($products) {
            return View::make('products.single', compact('title', 'products'));
        }
        return View::make('errors.404');
    }

    /**
     * Cart function.
     *
     * @return Response
     */
    public function Cart(Request $request) {
        if (Auth::check()) {
            $carts = Cart::where('user_id', Auth::id())->get(array('id', 'product_id', 'quantity', 'total_price'));
            $shipping_address = ShippingAddress::where('user_id', Auth::id())->first();
            if (empty($carts->toArray())) {
                $carts = array();
            }
        } else {
            if (Session::has('cartItem')) {
                $carts = json_decode(json_encode(Session::get('cartItem')));  // here json_encode and decode is used to covert simple array to object array
            } else {
                $carts = array();
            }
            $shipping_address = '';
        }
        $total_price_cart = '';
        $total_weight = '';
        if (!empty($carts)) {
            $cart_data = array();
            foreach ($carts as $key => $value) {
                $products = Product::where('id', $value->product_id)->first();
                $product_image = json_decode($products->product_details->product_images);
                $total_price_cart += $value->total_price;
                $total_weight += $value->quantity * $products->weight;

                $cart_data[$key] = array(
                    'product_id' => $products->id,
                    'cart_id' => Auth::check() ? $value->id : $products->id, //   if user not logged in then we have removed item in the session array based on product id otherwise from database
                    'product_name' => $products->product_name,
                    'product_image' => isset($product_image[0]) ? $product_image[0] : 'default.jpg',
                    'product_slug' => $products->product_slug,
                    'sku' => $products->sku,
                    'vehicle_company' => $products->get_vehicle_company->name,
                    'vehicle_model' => $products->get_vehicle_model->name,
                    'vehicle_year' => $products->vehicle_year_from . '-' . $products->vehicle_year_to,
                    'quantity' => $value->quantity,
                    'price' => $products->price,
                    'total_price' => $value->total_price,
                );
            }
        } else {
            $cart_data = array();
        }

        if ($request->get('shipping_method') == '') {
            $method_name = "Free shipping";
        } else {
            $method_name = $request->get('shipping_method');
        }
        // calculate total price based on shipping method and rates
        $shipping_methods = ShippingMethod::where('status', 1)->get();
        $shipping_price = 0;
        if (!empty($shipping_methods->toArray()) && $shipping_address != '' && $method_name != 'Free Delivery') {

            $shipping_rates = ShippingRate::where('country_id', $shipping_address->country_id)->where(function ($query) use ($total_weight) {
                        $query->where('low_weight', '>=', $total_weight)
                                ->where('low_weight', '<=', $total_weight)
                                ->orwhere('high_weight', '>=', $total_weight)
                                ->where('high_weight', '<=', $total_weight);
                    })->first(array('price'));
            if ($shipping_rates != '') {
                $shipping_price = $shipping_rates->price;
                $total_price_cart = $total_price_cart + $shipping_price;
            } else {
                $shipping_price = ShippingRate::where('country_id', $shipping_address->country_id)->max('price');
                $total_price_cart = $total_price_cart + $shipping_price;
            }
        }
        $other_cart_data = array(
            'shipping_price' => $shipping_price,
            'total_price_cart' => $total_price_cart,
            'method_name' => $method_name
        );

        $view = View::make('carts.index', compact('cart_data', 'shipping_address', 'shipping_methods', 'shipping_rates', 'other_cart_data'));
        if ($request->wantsJson()) {
            $sections = $view->renderSections();
            return $sections['content'];
        }
        return $view;
    }

    /**
     * Add to cart function.
     *
     * @return Response
     */
    public function addCart(Request $request) {
        $data = $request->all();
        //get product quantity and price based on product id
        $products = Product::select(array('id', 'price', 'quantity'))->find($data['product_id']);
        $data['quantity'] = isset($data['quantity']) && ((int) $data['quantity'] > 0) ? (int) $data['quantity'] : 1;

        if (Auth::check()) {   ///  if user logged in then we insert his cart details in the database
            $data['user_id'] = Auth::id();
            // this is used to check if user already insert same item in the cart
            $cart = Cart::Where('user_id', $data['user_id'])->Where('product_id', $data['product_id'])->first(array('id', 'quantity'));
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
     * update cart function.
     *
     * @return Response
     */
    public function updateCart(Request $request) {
        $data = $request->all();
        //get product quantity and price based on product id
        $products = Product::select(array('id', 'price', 'quantity'))->find($data['product_id']);
        $data['quantity'] = isset($data['quantity']) && ((int) $data['quantity'] > 0) ? (int) $data['quantity'] : 1;

        if ($data['quantity'] > $products->quantity) {  // this is used to check if product quantity less than the available quantity
            return response()->json(array('error' => 'Quantity should be less than available quantity'), 401);
        }
        if (Auth::check()) {   ///  if user logged in then we insert his cart details in the database
            $data['user_id'] = Auth::id();

            $data['total_price'] = $products->price * $data['quantity'];
            $cart = Cart::Where('user_id', $data['user_id'])->Where('product_id', $data['product_id'])->first(array('id'));

            if ($cart) {
                $cart->fill(array('quantity' => $data['quantity'], 'total_price' => $data['total_price']))->save();
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
                    $merged[$val['product_id']] = $val;
                }
                Session::put('cartItem', array_values($merged));
            } else {
                $cart_array[] = $data_array;
                Session::put('cartItem', $cart_array);
            }
            Session::save();
        }
        return response()->json(['success' => true, 'html' => $this->cart($request), 'messages' => "Quantity updated successfully!"]);
    }

    /**
     * delete cart function.
     *
     * @return Response
     */
    public function deleteCart(Request $request) {

        if (Auth::check()) {///  if user logged in then we delete item from cart table otherwise delete from session array
            $cart = Cart::find($request->get('id'));
            if (!$cart) {
                return response()->json(array('error' => 'Something went wrong .Please try again later!'), 401);
            } else {
                $cart->delete();
                //return response()->json(['success' => true, 'messages' => "Item deleted successfully !"]);
            }
        } else {

            if (Session::has('cartItem')) {
                $cart_array = Session::pull('cartItem');
                foreach ($cart_array as $key => $val) {
                    if ($val['product_id'] == $request->get('id')) {
                        unset($cart_array[$key]);
                    }
                }
                if (count($cart_array) > 0) {
                    Session::put('cartItem', array_values($cart_array));
                }
            }
        }
        return response()->json(['success' => true, 'html' => $this->cart($request), 'messages' => "Item deleted successfully!"]);
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
                    }])->where([['products.vehicle_year_from', '<=', $year], ['products.vehicle_year_to', '>=', $year]])->groupby('products.vehicle_make_id')->get(array('products.vehicle_make_id'));

        return $vehicle_companies;
    }

    /**
     * function to get product vehicle model based on make id.
     *
     * @return Response
     */
    public function getProductVehicleModelByMakeId(Request $request) {

        $make_id = $request->get('id');
        $year = $request->get('year');
        // get vehicle model data from product table and vehicle model table
        $vehicle_models = Product::with(['get_vehicle_model' => function ($q) {
                        $q->select(['vehicle_models.id', 'vehicle_models.name']);
                    }])->where([['products.vehicle_year_from', '<=', $year], ['products.vehicle_year_to', '>=', $year],['products.vehicle_make_id', $make_id]])->groupby('products.vehicle_model_id')->get(array('products.vehicle_model_id'));

        return $vehicle_models;
    }

    /**
     * function for search product.
     *
     * @return Response
     */
    public function searchProduct(Request $request) {

        $title = 'Products | Search';


        $keyword = $request->input('q') ? $request->input('q') : 'null';
        $cat_id = $request->input('cat');
        $year = $request->input('year');
        $make_id = $request->input('make_id');
        $model_id = $request->input('model_id');


        if ($keyword != null && !$year) {
            $product_sub_category_ids = ProductSubCategory::whereHas('getProducts', function($query) {
                        $query->Where('products.quantity', '>', 0);
                    })->Where('sub_category_id', $cat_id)->pluck('id')->toArray();


            $products = Product::with(['product_details', 'get_brands', 'get_vehicle_company', 'get_vehicle_model'])->whereHas('product_category.category', function($query) use($keyword) {
                                $query->where('categories.name', 'LIKE', '%' . $keyword . '%');
                            })->orWhereHas('get_brands', function ($query) use($keyword) {
                                $query->where('brands.name', 'LIKE', '%' . $keyword . '%');
                            })->orWhereHas('get_vehicle_company', function ($query) use($keyword) {
                                $query->where('vehicle_companies.name', 'LIKE', '%' . $keyword . '%');
                            })->orWhereHas('get_vehicle_model', function ($query) use($keyword) {
                                $query->where('vehicle_models.name', 'LIKE', '%' . $keyword . '%');
                            })->orWhere('products.product_name', 'LIKE', '%' . $keyword . '%')
                            ->Where('products.quantity', '>', 0)
                            ->where(function($query) use ($product_sub_category_ids) {
                                if ($product_sub_category_ids != null)
                                    $query->whereIn('products.id', $product_sub_category_ids);
                            })->paginate(20);
        } else {
            $whereCond = [['products.vehicle_year_from', '<=', $year], ['products.vehicle_year_to', '>=', $year], 'products.vehicle_make_id' => $make_id, 'products.vehicle_model_id' => $model_id];
            $products = Product::with(['product_details', 'get_brands', 'get_vehicle_company', 'get_vehicle_model'])->Where($whereCond)->paginate(20);
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
