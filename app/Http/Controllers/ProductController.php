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
use App\CoupanCode;
use App\CoupanUsage;
use App\TaxRate;
use App\ShippingAddress;
use App\BillingAddress;
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
        $products = Product::where([['product_slug', '=', $slug], ['status', '=', 1]])->first();
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
        $offer_code = $request->get('offer_code');
        if (Auth::check()) {
            $carts = Cart::where('user_id', Auth::id())->get(array('id', 'product_id', 'quantity', 'total_price'));
            $shipping_address = ShippingAddress::where('user_id', Auth::id())->first();
            $billing_address = BillingAddress::where('user_id', Auth::id())->first();

            //get tax price
            $regrex = '"([^"]*)' . $shipping_address->state_id . '([^"]*)"';
            $tax_price = TaxRate::Where('country_id', $shipping_address->country_id)->whereRaw("state_id REGEXP '" . $regrex . "'")->first(array('price'));

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
            $billing_address = '';
            $tax_price = '';
        }

        $total_price_cart = 0;
        $total_weight = 0;
       // $discount = 0;
        if (!empty($carts)) {
            $cart_data = array();
            $sku_array = array();
            foreach ($carts as $key => $value) {
                $products = Product::where('id', $value->product_id)->first();
                $sku_array[$key] = $products->sku;
                if ($products->status == 0 || $products->quantity == 0) {
                    Cart::Where('product_id', $value->product_id)->delete();
                    unset($value);
                    continue;
                }
                $product_image = json_decode($products->product_details->product_images);
                $total_weight += $value->quantity * $products->weight;
                //$discount += $products->discount;
                $cart_data[$key] = array(
                    'product_id' => $products->id,
                    'cart_id' => Auth::check() ? $value->id : $products->id, //   if user not logged in then we have removed item in the session array based on product id otherwise from database
                    'product_name' => $products->product_name,
                    'product_long_description' => $products->product_long_description,
                    'product_image' => isset($product_image[0]) ? $product_image[0] : 'default.jpg',
                    'product_slug' => $products->product_slug,
                    'sku' => $products->sku,
                    'vehicle_company' => $products->get_vehicle_company->name,
                    'vehicle_model' => $products->get_vehicle_model->name,
                    'vehicle_year' => $products->vehicle_year_from . '-' . $products->vehicle_year_to,
                    'quantity' => $value->quantity,
                    'price' => $products->price,
//                    'discount' => $products->discount,
//                    'total_price' => $value->total_price,
                );
            }
        } else {
            $cart_data = array();
        }
        
        
         $coupon_discount = null;
         $discount_status = false;
        // this code is used to verify coupan code and allow discount 
        if ($offer_code != null) {
            $coupan_code = CoupanCode::Where(['code' => $offer_code, 'status' => 1])->first();
            // this is used to check if the request is ajax json
            if ($request->wantsJson()) {
                if ($coupan_code) {
                    $check_usage = CoupanUsage::Where([['coupan_id', '=', $coupan_code->id], ['user_id', '=', Auth::id()], ['usage', '>=', $coupan_code->usage]])->first();
                    $current_date = strtotime(Carbon::now());
                    if (strtotime($coupan_code->expiration_date) < $current_date) {
                        return response()->json(array('error' => 'Sorry,this coupan code has been expired!'), 401);
                    } else if ($check_usage) {
                        return response()->json(array('error' => 'Sorry,You have exceed the coupan code usage limit!'), 401);
                    }else if ($coupan_code->coupon_type == 'per_product' && ($coupan_code->product_sku == null || empty(array_intersect($sku_array,json_decode($coupan_code->product_sku))))) {
                        return response()->json(array('error' => 'Sorry discount not available for these products!'), 401);
                    }
                    $discount_status = true;
                    $coupon_discount = $coupan_code->discount;
                } else {
                    return response()->json(array('error' => 'Sorry,please check your coupan code or try again later!'), 401);
                }
            } 
        } 

        if ($request->get('shipping_method') == '') {
            $method_name = "Free shipping";
        } else {
            $method_name = $request->get('shipping_method');
        }
        // calculate total price based on shipping method and rates
        $shipping_methods = ShippingMethod::where('status', 1)->get();
        $shipping_price = 0;
        if (!empty($shipping_methods->toArray()) && $shipping_address != '' && $method_name != 'Free shipping') {

            $shipping_rates = ShippingRate::where('country_id', $shipping_address->country_id)->where(function ($query) use ($total_weight) {
                        $query->where('low_weight', '>=', $total_weight)
                                ->where('low_weight', '<=', $total_weight)
                                ->orwhere('high_weight', '>=', $total_weight)
                                ->where('high_weight', '<=', $total_weight);
                    })->first(array('price'));
            if ($shipping_rates != '') {
                $shipping_price = $shipping_rates->price;
            } else {
                $shipping_price = ShippingRate::where('country_id', $shipping_address->country_id)->max('price');
                if (!$shipping_price)
                    $shipping_price = 0;
            }
        }


        $other_cart_data = array(
            'shipping_price' => $shipping_price,
            'tax_price' => $tax_price ? $tax_price->price : 0,
            'shipping_method' => $method_name,
            'discount_status' => $discount_status,
            'discount_code' => $offer_code,
            'coupon_discount' => $coupon_discount
        );
        
        if($discount_status){
            if($coupan_code->coupon_type == 'per_product'){
                  $check_discount_array = array_intersect($sku_array,json_decode($coupan_code->product_sku));
                  foreach($check_discount_array as $k=>$val){
                      $cart_data[$k]['coupon_discount'] = $coupon_discount;
                  }
            }
            $other_cart_data['coupon_type'] = $coupan_code->coupon_type;
        }
        
        
        $data['cart_data'] = $cart_data;
        $data['other_cart_data'] = $other_cart_data;
        
        Session::put('cart_data',$data);
        $data['shipping_address'] = $shipping_address;
        $data['shipping_methods'] = $shipping_methods;
        $data['billing_address'] = $billing_address;
        
      
        $view = View::make('carts.index', $data);
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
                        $merged[$val['product_id']]['total_price'] = $products->price * $merged[$val['product_id']]['quantity'];
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
                    }])->where([['products.vehicle_year_from', '<=', $year], ['products.vehicle_year_to', '>=', $year], ['products.vehicle_make_id', $make_id]])->groupby('products.vehicle_model_id')->get(array('products.vehicle_model_id'));

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
        $cat_name = $request->input('cat');
        $year = $request->input('year');
        $make_id = $request->input('make_id');
        $model_id = $request->input('model_id');


        if (($keyword != null || $cat_name != null) && !$year) {
//            $product_sub_category_ids = Product::whereHas('product_sub_categories.get_sub_categories', function($query) use ($cat_name) {
//                        $query->Where('sub_categories.name', 'LIKE', '%' . $cat_name . '%');
//                    })->Where([['products.quantity', '>', 0], ['status', '=', 1]])->pluck('id')->toArray();
//                    
//                    
//            dd($product_sub_category_ids);        

            $products = Product::with(['product_details', 'get_brands', 'get_vehicle_company', 'get_vehicle_model'])
                            ->Where([['products.quantity', '>', 0], ['status', '=', 1]])
                            ->Where('products.product_name', 'LIKE', '%' . $keyword . '%')
                            ->orWhereHas('product_category.category', function($query) use($keyword) {
                                $query->where('categories.name', 'LIKE', '%' . $keyword . '%');
                            })->orWhereHas('get_brands', function ($query) use($keyword) {
                        $query->where('brands.name', 'LIKE', '%' . $keyword . '%');
                    })->orWhereHas('get_vehicle_company', function ($query) use($keyword) {
                        $query->where('vehicle_companies.name', 'LIKE', '%' . $keyword . '%');
                    })->orWhereHas('get_vehicle_model', function ($query) use($keyword) {
                        $query->where('vehicle_models.name', 'LIKE', '%' . $keyword . '%');
                    })->orWhere(function($query) use ($cat_name) {
                        if ($cat_name != null) {
                            $query->orWhereHas('product_sub_categories.get_sub_categories', function($q) use ($cat_name) {
                                $q->Where('sub_categories.name', 'LIKE', '%' . $cat_name . '%');
                            });
                        }
                    })->paginate(20);
        } else if ($year != null && $make_id != null && $model_id != null) {
            $whereCond = [['products.vehicle_year_from', '<=', $year], ['products.vehicle_year_to', '>=', $year], ['products.quantity', '>', 0], ['status', '=', 1], 'products.vehicle_make_id' => $make_id, 'products.vehicle_model_id' => $model_id];
            $products = Product::with(['product_details', 'get_brands', 'get_vehicle_company', 'get_vehicle_model'])->Where($whereCond)->paginate(20);
        } else {
            $products = Product::with(['product_details', 'get_brands', 'get_vehicle_company', 'get_vehicle_model'])->Where([['products.quantity', '>', 0], ['status', '=', 1]])->paginate(20);
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
