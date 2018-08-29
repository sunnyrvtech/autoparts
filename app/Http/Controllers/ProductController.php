<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;
use App\Product;
use App\VehicleCompany;
use App\VehicleModel;
use App\Cart;
use App\Country;
use App\State;
use App\ShippingMethod;
use App\ShippingRate;
use App\SubCategory;
use App\CoupanCode;
use App\CoupanUsage;
use App\TaxRate;
use App\ShippingAddress;
use App\BillingAddress;
//use App\ProductSubCategory;
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
        $data['title'] = 'Products';
        $data['products'] = Product::where([['product_slug', '=', $slug], ['status', '=', 1]])->first();
        if ($data['products']) {
            $data['bredcrum'] = '<span class="divider"> &gt; </span><span><a href="' . url('/' . $data['products']->get_vehicle_company->slug . '/' . $data['products']->get_vehicle_model->slug . '/' . $data['products']->get_sub_category->slug) . '">' . $data['products']->get_sub_category->name . '</a></span><span class="divider"> &gt; </span><span>' . $slug . '</span>';
            return view('products.single', $data);
        }
        return view('errors.404');
    }

    /**
     * Cart function.
     *
     * @return Response
     */
    public function Cart(Request $request) {
        $offer_code = $request->get('offer_code');
        $tax_price = '';
        $shipping_address = null;
        $billing_address = null;
        if (Auth::check()) {
            $carts = Cart::where('user_id', Auth::id())->get(array('id', 'product_id', 'quantity', 'total_price'));
            $shipping_address = ShippingAddress::where('user_id', Auth::id())->first();
            $billing_address = BillingAddress::where('user_id', Auth::id())->first();
            if (!$shipping_address = ShippingAddress::where('user_id', Auth::id())->first()) {
                if (Session::has('shipping_address'))
                    $shipping_address = Session::get('shipping_address');
            }else {
                //get tax price
                $regrex = '"([^"]*)' . $shipping_address->state_id . '([^"]*)"';
                $tax_price = TaxRate::Where('country_id', $shipping_address->country_id)->whereRaw("state_id REGEXP '" . $regrex . "'")->first(array('price'));
            }
            if (!$billing_address = BillingAddress::where('user_id', Auth::id())->first()) {
                if (Session::has('billing_address'))
                    $billing_address = Session::get('billing_address');
            }

            if (empty($carts->toArray())) {
                $carts = array();
            }
            $customer_email = Auth::user()->email;
        } else {
            if (Session::has('cartItem')) {
                $carts = json_decode(json_encode(Session::get('cartItem')));  // here json_encode and decode is used to covert simple array to object array
            } else {
                $carts = array();
            }
            if (Session::has('billing_address'))
                $shipping_address = Session::get('billing_address');
            if (Session::has('shipping_address'))
                $billing_address = Session::get('shipping_address');
            $customer_email = Session::get('customer_email');
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
                    $check_usage = CoupanUsage::Where([['coupan_id', '=', $coupan_code->id], ['email', '=', $customer_email], ['usage', '>=', $coupan_code->usage]])->first();
                    $current_date = strtotime(Carbon::now());
                    if (strtotime($coupan_code->expiration_date) < $current_date) {
                        return response()->json(array('error' => 'Sorry,this coupan code has been expired!'), 401);
                    } else if ($check_usage) {
                        return response()->json(array('error' => 'Sorry,You have exceed the coupan code usage limit!'), 401);
                    } else if ($coupan_code->coupon_type == 'per_product' && ($coupan_code->product_sku == null || empty(array_intersect($sku_array, json_decode($coupan_code->product_sku))))) {
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
        if (!empty($shipping_methods->toArray()) && $shipping_address != null && $method_name != 'Free shipping') {

            $rates = ShippingRate::where('country_id', $shipping_address->country_id)->first();
            if (!$rates) {
                return response()->json(array('error' => 'No shipping available in your country !'), 401);
            }

            if ($rates->ship_type == 'zip_biased') {
                $ship_regrex = '"([^"]*)' . $shipping_address->zip . '([^"]*)"';
                $shipping_rates = ShippingRate::whereRaw("zip_code REGEXP '" . $ship_regrex . "'")->first(array('price'));
                if ($shipping_rates != '')
                    $shipping_price = $shipping_rates->price;
            } else {
                $shipping_rates = ShippingRate::where('country_id', $shipping_address->country_id)->where(function ($query) use ($total_weight) {
                            $query->where('low_weight', '>=', $total_weight)
                                    ->where('low_weight', '<=', $total_weight)
                                    ->orwhere('high_weight', '>=', $total_weight)
                                    ->where('high_weight', '<=', $total_weight);
                        })->first(array('price'));

                if ($shipping_rates == '')
                    $shipping_price = ShippingRate::where('country_id', $shipping_address->country_id)->max('price');
            }
            if (!$shipping_price)
                return response()->json(array('error' => 'No shipping available in your country !'), 401);
        }


        $other_cart_data = array(
            'shipping_price' => $shipping_price,
            'tax_price' => $tax_price ? $tax_price->price : 0,
            'shipping_method' => $method_name,
            'discount_status' => $discount_status,
            'discount_code' => $offer_code,
            'coupon_discount' => $coupon_discount
        );

        if ($discount_status) {
            if ($coupan_code->coupon_type == 'per_product') {
                $check_discount_array = array_intersect($sku_array, json_decode($coupan_code->product_sku));
                foreach ($check_discount_array as $k => $val) {
                    $cart_data[$k]['coupon_discount'] = $coupon_discount;
                }
            }
            $other_cart_data['coupon_type'] = $coupan_code->coupon_type;
        }

        if ($shipping_address != null) {
            $shipping_address->state_name = State::Where('id', $shipping_address->state_id)->pluck('name')->first();
            $shipping_country = Country::Where('id', $shipping_address->country_id)->first(array('name', 'sortname'));
            $shipping_address->country_name = $shipping_country->name;
            $shipping_address->country_code = $shipping_country->sortname;
        }
        if ($billing_address != null) {
            $billing_address->state_name = State::Where('id', $billing_address->state_id)->pluck('name')->first();
            $billing_country = Country::Where('id', $billing_address->country_id)->first(array('name', 'sortname'));
            $billing_address->country_name = $billing_country->name;
            $billing_address->country_code = $billing_country->sortname;
        }

        $data['cart_data'] = $cart_data;
        $data['other_cart_data'] = $other_cart_data;

        Session::put('cart_data', $data);
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
                        $q->select(['id', 'name', 'slug']);
                    }])->where([['vehicle_year_from', '<=', $year], ['vehicle_year_to', '>=', $year]])->groupby('vehicle_make_id')->get(array('vehicle_make_id'));
        $vehicle_companies = collect($vehicle_companies)->sortBy('get_vehicle_company.name')->values();
        return $vehicle_companies;
    }

    /**
     * function to get product vehicle model based on make id.
     *
     * @return Response
     */
    public function getProductVehicleModelByMakeId(Request $request) {

        $make_id = $request->get('id');
        //$year = $request->get('year');
        // get vehicle model data from product table and vehicle model table
        $vehicle_models = Product::with(['get_vehicle_model' => function ($q) {
                        $q->select(['id', 'name', 'slug']);
                    }])->where([['vehicle_make_id', $make_id]])->groupby('vehicle_model_id')->get(array('vehicle_model_id'));
        $vehicle_models = collect($vehicle_models)->sortBy('get_vehicle_model.name')->values();
        return $vehicle_models;
    }

    /**
     * function to get product vehicle model based on make id.
     *
     * @return Response
     */
    public function getProductVehicleYearByModelId(Request $request) {

        $model_id = $request->get('id');
        $make_id = $request->get('vehicle_make');
        $vehicle_year_from = Product::where([['vehicle_make_id', $make_id], ['vehicle_model_id', $model_id]])->groupby('vehicle_year_from')->pluck('vehicle_year_from')->toArray();
        $vehicle_year_to = Product::where([['vehicle_make_id', $make_id], ['vehicle_model_id', $model_id]])->groupby('vehicle_year_to')->pluck('vehicle_year_to')->toArray();

        $years = array_values(array_unique(array_merge($vehicle_year_from, $vehicle_year_to)));
        sort($years);
        return $years;
    }

    /**
     * function for search product.
     *
     * @return Response
     */
    public function searchProduct(Request $request) {

        $title = 'Products | Search';

        $keyword_array = explode(" ", $request->get('q'));
        $keyword = array();
        $years_array = array();
        foreach ($keyword_array as $value) {
            if (is_numeric($value)) {
                array_push($years_array, $value);
            } else if ($value) {
                array_push($keyword, $value);
            }
        }

        $cat_id = $request->input('cat');
        $make_id = $request->input('make');
        $model_id = $request->input('model');
        $products = Product::with(['product_details', 'get_sub_category', 'get_brands', 'get_vehicle_company', 'get_vehicle_model'])
                        ->Where(function($query) use($keyword, $cat_id, $make_id, $model_id, $years_array) {
                            $query->Where([['products.quantity', '>', 0], ['status', '=', 1]]);

                            if ($cat_id != null)
                                $query->Where('sub_category_id', '=', $cat_id);
                            if ($make_id != null)
                                $query->Where('vehicle_make_id', '=', $make_id);
                            if ($model_id != null)
                                $query->Where('vehicle_model_id', '=', $model_id);
                            if (!empty($keyword)) {
                                $query->Where(function($q) use($keyword) {
                                    foreach ($keyword as $val) {
                                        $q->Where('keyword_search', 'LIKE', '%' . $val . '%');
                                    }
                                });
                            }
                            
                            if (!empty($years_array)) {
                                $query->Where(function($q) use($years_array) {

                                    foreach ($years_array as $year) {
                                        $q->orwhere([['vehicle_year_from', '<=', $year], ['vehicle_year_to', '>=', $year]]);
                                    }
                                });
                            }
                        })->paginate(20);
        $vehicles = VehicleCompany::orderby('name')->get(array('slug', 'name', 'id'));
        $view = View::make('products.search', compact('title', 'products', 'vehicles'));
        if ($request->wantsJson()) {
            $sections = $view->renderSections();
            return $sections['content'];
        }
        return $view;
    }

    /**
     * function for search product.
     *
     * @return Response
     */
    public function searchProduct1(Request $request) {

        $title = 'Products | Search';

        $keyword = $request->input('q');
        $cat_id = $request->input('cat');
        $make_id = $request->input('make');
        $model_id = $request->input('model');

        if (($keyword != null || $cat_id != null || $make_id != null || $model_id != null)) {
            $products = Product::with(['product_details', 'get_sub_category', 'get_brands', 'get_vehicle_company', 'get_vehicle_model'])
                            ->Where([['products.quantity', '>', 0], ['status', '=', 1]])
                            ->Where(function($query) use($keyword, $cat_id, $make_id, $model_id) {
                                if ($cat_id != null)
                                    $query->Where('sub_category_id', '=', $cat_id);
                                if ($make_id != null)
                                    $query->Where('vehicle_make_id', '=', $make_id);
                                if ($model_id != null)
                                    $query->Where('vehicle_model_id', '=', $model_id);
                                if (!is_numeric($keyword) && $keyword != null) {
                                    $query->whereRaw("MATCH(product_name) AGAINST(? IN BOOLEAN MODE)", [$keyword]);
                                    $query->orWhere('products.sku', 'LIKE', $keyword . '%');
                                } elseif ($keyword != null) {
                                    $query->Where('products.price', 'LIKE', $keyword . '%');
                                }
                            })->orWhere(function($query) use($keyword) {
                        if ($keyword != null) {
                            $query->WhereHas('product_details', function ($q) use ($keyword) {
                                $q->where('product_details.oem_number', 'LIKE', '%' . $keyword . '%')
                                        ->orwhere('product_details.parse_link', 'LIKE', '%' . $keyword . '%');
                            });
                        }
                    })->orWhere(function($query) use($keyword) {
                        if ($keyword != null) {
                            $query->WhereHas('get_vehicle_company', function ($q) use($keyword) {
                                $q->where('vehicle_companies.name', 'LIKE', '%' . $keyword . '%');
                            });
                        }
                    })->orWhere(function($query) use($keyword) {
                        if ($keyword != null) {
                            $query->WhereHas('get_vehicle_model', function ($q) use($keyword) {
                                $q->where('vehicle_models.name', 'LIKE', '%' . $keyword . '%');
                            });
                        }
                    })->orWhere(function($query) use ($keyword) {
                        if ($keyword != null) {
                            $query->orWhereHas('get_sub_category', function($q) use ($keyword) {
                                $q->Where('sub_categories.name', 'LIKE', '%' . $keyword . '%');
                            });
                        }
                    })->paginate(20);
        } else {
            $products = Product::with(['product_details', 'get_sub_category', 'get_brands', 'get_vehicle_company', 'get_vehicle_model'])->Where([['products.quantity', '>', 0], ['status', '=', 1]])->paginate(20);
        }
        $vehicles = VehicleCompany::orderby('name')->get(array('slug', 'name', 'id'));
        $view = View::make('products.search', compact('title', 'products', 'vehicles'));
        if ($request->wantsJson()) {
            $sections = $view->renderSections();
            return $sections['content'];
        }
        return $view;
    }

    public function getAddresses() {
        if (!$data['shipping_address'] = ShippingAddress::where('user_id', Auth::id())->first()) {
            if (Session::has('shipping_address'))
                $data['shipping_address'] = Session::get('shipping_address');
        }
        if (!$data['billing_address'] = BillingAddress::where('user_id', Auth::id())->first()) {
            if (Session::has('billing_address'))
                $data['billing_address'] = Session::get('billing_address');
        }

        if (isset($data['shipping_address']))
            $data['shipping_states'] = State::Where('country_id', $data['shipping_address']->country_id)->get(array('name', 'id'));

        if (isset($data['billing_address']))
            $data['billing_states'] = State::Where('country_id', $data['billing_address']->country_id)->get(array('name', 'id'));

        $data['countries'] = Country::get(array('name', 'id'));

        return View::make('carts.addresses', $data);
    }

    public function postCartAddresses(Request $request) {
        $data = $request->all();
        $this->validate($request, [
            'billing_first_name' => 'required|max:150',
            'shipping_first_name' => 'required|max:150',
            'email' => 'required',
            'billing_last_name' => 'required|max:150',
            'shipping_last_name' => 'required|max:150',
            'billing_address1' => 'required|max:150',
            'shipping_address1' => 'required|max:150',
            'billing_country_id' => 'required',
            'shipping_country_id' => 'required',
            'billing_state_id' => 'required',
            'shipping_state_id' => 'required',
            'billing_city' => 'required',
            'shipping_city' => 'required',
            'billing_zip' => 'required|max:6',
            'shipping_zip' => 'required|max:6'
        ]);


        $shipping_address = array(
            'first_name' => $data['shipping_first_name'],
            'last_name' => $data['shipping_last_name'],
            'address1' => $data['shipping_address1'],
            'address2' => $data['shipping_address2'],
            'country_id' => $data['shipping_country_id'],
            'state_id' => $data['shipping_state_id'],
            'city' => $data['shipping_city'],
            'zip' => $data['shipping_zip']
        );
        $billing_address = array(
            'first_name' => $data['billing_first_name'],
            'last_name' => $data['billing_last_name'],
            'address1' => $data['billing_address1'],
            'address2' => $data['billing_address2'],
            'country_id' => $data['billing_country_id'],
            'state_id' => $data['billing_state_id'],
            'city' => $data['billing_city'],
            'zip' => $data['billing_zip']
        );


        if (Auth::check()) {
            $shippings = ShippingAddress::where('user_id', Auth::id())->first();
            if (!empty($shippings)) {
                $shippings->fill($shipping_address)->save();
            } else {
                $shipping_address['user_id'] = Auth::id();
                ShippingAddress::create($shipping_address);
            }
            $billings = BillingAddress::where('user_id', Auth::id())->first();
            if (!empty($billings)) {
                $billings->fill($billing_address)->save();
            } else {
                $billing_address['user_id'] = Auth::id();
                BillingAddress::create($billing_address);
            }
        } else {
            Session::put('shipping_address', (object) $shipping_address);
            Session::put('billing_address', (object) $billing_address);
            Session::put('customer_email', $data['email']);
        }
        return redirect()->route('cart');
    }

}
