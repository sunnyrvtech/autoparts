<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use App\OrderDetail;
use App\Product;
use App\ProductDetail;
use App\Brand;
use App\VehicleModel;
use App\VehicleCompany;
use App\Category;
use App\SubCategory;
use App\ProductCategory;
use App\ProductSubCategory;
use Carbon\Carbon;
use Excel;
use DB;
use Mail;

class ApiController extends Controller {

    /**
     * get order details API.
     *
     * @return Response
     */
    public function getOrderDetails(Request $request) {
        $page_size = $request->get('page_size') ? $request->get('page_size') : 10;
        $current_page = $request->get('current_page') ? $request->get('current_page') : 1;
//        $start = $request->get('start') ? $request->get('start') : 1;
//        $end = $request->get('end') ? $request->get('end') : 10;
        $skip = ($current_page - 1) * $page_size;
//        $take = ($end - $start) + 1;

        $filter_array = array(
            'date' => $request->get('date'),
            'ids' => $request->get('ids'),
            'status' => $request->get('status'),
        );

        $orders = Order::Where(function($query) use ($filter_array) {
                    if ($filter_array['ids'] != null && $filter_array['ids'] != null) {
                        $ids = explode(',', $filter_array['ids']);
                        if (count($ids) == 2) {
                            $query->whereBetween('id', $ids);
                        } else {
                            $query->where('id', $ids[0]);
                        }
                    }
                    if ($filter_array['date'] != null && $filter_array['date'] != null) {
                        $dates = explode(',', $filter_array['date']);
                        if (count($dates) == 2) {
                            $dates[1] = date('Y-m-d', strtotime('+1 day', strtotime($dates[1])));
                            $query->whereBetween('created_at', $dates);
                        } else {
                            $query->where('created_at', 'like', $dates[0] . '%');
                        }
                    }
                    if ($filter_array['status'] != null) {
                        $query->Where('order_status', $filter_array['status']);
                    }
                })->latest('created_at')->skip($skip)->take($page_size)->get();
        $total_order = Order::count();
        $order_array = array();
        if (!empty($orders->toArray())) {
            foreach ($orders as $key => $value) {
                $item_array = array();
                foreach ($value->getOrderDetailById as $k => $val) {
                    $item_array[$k]['item_id'] = $val->id;
                    $item_array[$k]['item_url'] = url('/products/' . $val->getProduct->product_slug);
                    $item_array[$k]['track_number'] = $val->track_id != null ? $val->track_id : '';
                    $item_array[$k]['product_name'] = $val->product_name;
                    $item_array[$k]['sku_number'] = $val->sku_number;
                    $item_array[$k]['quantity'] = $val->quantity;
                    $item_array[$k]['price'] = $val->total_price - ($val->total_price * $val->discount / 100);
                    $item_array[$k]['discount'] = $val->discount != null ? $val->discount : '';
                    $item_array[$k]['ship_carrier'] = $val->ship_carrier != null ? $val->ship_carrier : '';
                    $item_array[$k]['ship_date'] = $val->ship_date != null ? date('Y-m-d', strtotime($val->ship_date)) : '';
                    $item_array[$k]['notes'] = $val->notes != null ? $val->notes : '';
                }
                $order_array['total_orders'] = $total_order;
                $order_array['page_size'] = $page_size;
                $order_array['total_pages'] = ceil($total_order / $page_size);
                $order_array['current_page'] = $current_page;
                $order_array['orders'][$key] = array(
                    'order_id' => $value->id,
                    'order_date' => date('Y-m-d', strtotime($value->created_at)),
                    'customer_name' => $value->getCustomer->first_name . ' ' . $value->getCustomer->last_name,
                    'customer_email' => $value->getCustomer->email,
                    'ship_price' => $value->ship_price != null ? $value->ship_price : '',
                    'tax' => $value->tax_rate != null ? $value->tax_rate : '',
                    'total_price' => $value->total_price,
                    'shipping_method' => $value->shipping_method,
                    'payment_method' => $value->payment_method,
                    'billing_address1' => $value->getCustomer->getBillingDetails->address1,
                    'billing_address2' => $value->getCustomer->getBillingDetails->address2,
                    'billing_city' => $value->getCustomer->getBillingDetails->city,
                    'billing_state' => $value->getCustomer->getBillingDetails->get_state->name,
                    'billing_zip' => $value->getCustomer->getBillingDetails->zip,
                    'billing_country' => $value->getCustomer->getBillingDetails->get_country->name,
                    'shipping_address1' => $value->getCustomer->getShippingDetails->address1,
                    'shipping_address2' => $value->getCustomer->getShippingDetails->address2,
                    'shipping_city' => $value->getCustomer->getShippingDetails->city,
                    'shipping_state' => $value->getCustomer->getShippingDetails->get_state->name,
                    'shipping_zip' => $value->getCustomer->getShippingDetails->zip,
                    'shipping_country' => $value->getCustomer->getShippingDetails->get_country->name,
                    'status' => $value->order_status,
                    'items' => $item_array,
                );
            }
        } else {
            return array();
        }
        return $order_array;
    }

    /**
     * post order details API.
     *
     * @return Response
     */
    public function postOrderDetails(Request $request) {

        $data = $request->all();
        $failed_ids = array();
        foreach ($data['orders'] as $key => $value) {
            $page_data = $value;
            $order = Order::find($page_data['order_id']);

            if ($order) {
                $old_order_status = $order->order_status;
                $order->fill(array('order_status' => $page_data['status']))->save();
                foreach ($page_data['items'] as $val) {
                    $update_array = array(
                        'track_id' => $val['track_number'] != null ? $val['track_number'] : null,
                        'ship_carrier' => $val['ship_carrier'] != null ? $val['ship_carrier'] : null,
                        'ship_date' => $val['ship_date'] != null ? $val['ship_date'] : null,
                        'notes' => $val['notes'] != null ? $val['notes'] : null,
                    );
                    if ($order_details = OrderDetail::find($val['item_id'])) {
                        if ($old_order_status != $page_data['status'] && ($page_data['status'] == 'shipped' || $page_data['status'] == 'completed')) {
                           $this->saveOrderInvoice($order, $order_details);
                        }


                        if (!$order_details->fill($update_array)->save()) {
                            $failed_ids[$key] = $page_data['order_id'];
                        }
                    }
                }
            }
        }

        if (empty($failed_ids)) {
            return response()->json(['status' => "success"]);
        } else {
            return response()->json(['status' => "error", 'failed_order_ids' => json_encode($failed_ids)]);
        }
    }

    public function saveOrderInvoice($order, $item_data) {
        if ($order['order_status'] == 'completed') {
            $order['order_time'] = date('M d,Y H:i:s A', strtotime($order->updated_at));
        } else {
            $order['order_time'] = date('M d,Y H:i:s A', strtotime($item_data->ship_date));
        }

        $data = array(
            'user_name' => $order->getCustomer->first_name . ' ' . $order->getCustomer->last_name,
            'email' => $order->getCustomer->email,
            'order' => $order,
            'item_data' => $item_data,
            'shipping_address' => $order->getCustomer->getShippingDetails,
            'billing_address' => $order->getCustomer->getBillingDetails
        );
        
        DB::table('order_emails')->insert(['order_data'=>json_encode($data)]);
        return true;
    }

    public function getProductDetails(Request $request) {
        $page_size = $request->get('page_size') ? $request->get('page_size') : 10;
        $current_page = $request->get('current_page') ? $request->get('current_page') : 1;
//        $start = $request->get('start') ? $request->get('start') : 1;
//        $end = $request->get('end') ? $request->get('end') : 10;
        $skip = ($current_page - 1) * $page_size;
//        $take = ($end - $start) + 1;


        $filter_array = array(
            'ids' => $request->get('ids'),
            'date' => $request->get('date'),
            'sku' => $request->get('sku'),
        );

        $products = Product::Where(function($query) use ($filter_array) {
                    if ($filter_array['ids'] != null && $filter_array['ids'] != null) {
                        $ids = explode(',', $filter_array['ids']);
                        if (count($ids) == 2)
                            $query->whereBetween('id', $ids);
                        else
                            $query->where('id', $ids[0]);
                    }
                    if ($filter_array['sku'] != null && $filter_array['sku'] != null) {
                        $sku = explode(',', $filter_array['sku']);
                        $query->whereIn('sku', $sku);
                    }
                    if ($filter_array['date'] != null && $filter_array['date'] != null) {
                        $dates = explode(',', $filter_array['date']);
                        if (count($dates) == 2) {
                            $dates[1] = date('Y-m-d', strtotime('+1 day', strtotime($dates[1])));
                            $query->whereBetween('created_at', $dates);
                        } else {
                            $query->where('created_at', 'like', $dates[0] . '%');
                        }
                    }
                })->skip($skip)->take($page_size)->get();
        $total_product = Product::count();
        $product_array = array();
        if (!empty($products->toArray())) {
            foreach ($products as $key => $value) {
                $product_array['total_products'] = $total_product;
                $product_array['page_size'] = $page_size;
                $product_array['total_pages'] = ceil($total_product / $page_size);
                $product_array['current_page'] = $current_page;
                $product_array['products'][$key] = array(
                    'id' => $value->id,
                    'sku' => $value->sku,
                    'text' => @$value->product_details->text,
                    'sale_type' => @$value->product_details->sale_type,
                    'vehicle_make' => @$value->get_vehicle_company->name,
                    'vehicle_model' => @$value->get_vehicle_model->name,
                    'vehicle_year' => $value->vehicle_year_from . '-' . $value->vehicle_year_to,
                    'product_name' => $value->product_name,
                    'product_long_description' => $value->product_long_description,
                    'product_short_description' => $value->product_short_description,
                    'vehicle_fit' => $value->vehicle_fit,
                    'm_code' => @$value->product_details->m_code,
                    'class' => @$value->product_details->class,
                    'part_type' => $value->part_type,
                    'parse_link' => @$value->product_details->parse_link,
                    'oem_number' => @$value->product_details->oem_number,
                    'category' => @$value->product_category->category->name,
                    'sub_category' => @$value->product_sub_category->get_sub_categories->name,
                    'certification' => @$value->product_details->certification,
                    'price' => $value->price,
                    'special_price' => !empty(@$value->special_price) ? @$value->special_price : '',
                    'discount' => !empty(@$value->discount) ? @$value->discount : '',
                    'quantity' => $value->quantity,
                    'status' => $value->status,
                    'weight' => !empty(@$value->weight) ? @$value->weight : '',
                    'length' => !empty(@$value->length) ? @$value->length : '',
                    'width' => !empty(@$value->width) ? @$value->width : '',
                    'height' => !empty(@$value->height) ? @$value->height : '',
                    'warranty' => !empty(@$value->product_details->warranty) ? @$value->product_details->warranty : '',
                    'brand' => !empty(@$value->get_brands->name) ? @$value->get_brands->name : '',
                    'operation' => !empty($value->operation) ? @$value->operation : '',
                    'wattage' => !empty(@$value->wattage) ? @$value->wattage : '',
                    'mirror_option' => !empty(@$value->mirror_option) ? @$value->mirror_option : '',
                    'location' => !empty(@$value->location) ? @$value->location : '',
                    'size' => !empty(@$value->size) ? @$value->size : '',
                    'material' => !empty(@$value->material) ? @$value->material : '',
                    'color' => !empty(@$value->color) ? @$value->color : '',
                    'front_location' => !empty(@$value->front_location) ? @$value->front_location : '',
                    'side_location' => !empty(@$value->side_location) ? @$value->side_location : '',
                    'includes' => !empty(@$value->includes) ? @$value->includes : '',
                    'design' => !empty(@$value->design) ? @$value->design : '',
                    'product_line' => !empty(@$value->product_line) ? @$value->product_line : '',
                    'meta_title' => !empty(@$value->product_details->meta_title) ? @$value->product_details->meta_title : '',
                    'meta_description' => !empty(@$value->product_details->meta_description) ? @$value->product_details->meta_description : '',
                    'meta_keyword' => !empty(@$value->product_details->meta_keyword) ? @$value->product_details->meta_keyword : '',
                    'software' => !empty(@$value->product_details->software) ? @$value->product_details->software : '',
                    'licensed_by' => !empty(@$value->product_details->licensed_by) ? @$value->product_details->licensed_by : '',
                    'car_cover' => !empty(@$value->product_details->car_cover) ? @$value->product_details->car_cover : '',
                    'kit_includes' => !empty(@$value->design) ? @$value->product_details->kit_includes : '',
                    'fender_flare_type' => !empty(@$value->product_details->fender_flare_type) ? @$value->product_details->fender_flare_type : '',
                    'product_grade' => !empty(@$value->product_details->product_grade) ? @$value->product_details->product_grade : '',
                    'lighting_bulb_configuration' => !empty(@$value->product_details->lighting_bulb_configuration) ? @$value->product_details->lighting_bulb_configuration : '',
                    'lighting_housing_shape' => !empty(@$value->product_details->lighting_housing_shape) ? @$value->product_details->lighting_housing_shape : '',
                    'bracket_style' => !empty(@$value->product_details->bracket_style) ? @$value->product_details->bracket_style : '',
                    'lighting_size' => !empty(@$value->product_details->lighting_size) ? @$value->product_details->lighting_size : '',
                    'lighting_beam_pattern' => !empty(@$value->product_details->lighting_beam_pattern) ? @$value->product_details->lighting_beam_pattern : '',
                    'lighting_lens_material' => !empty(@$value->product_details->lighting_lens_material) ? @$value->product_details->lighting_lens_material : '',
                    'lighting_mount_type' => !empty(@$value->product_details->lighting_mount_type) ? @$value->product_details->lighting_mount_type : '',
                    'cooling_fan_type' => !empty(@$value->product_details->cooling_fan_type) ? @$value->product_details->cooling_fan_type : '',
                    'radiator_row_count' => !empty(@$value->product_details->radiator_row_count) ? @$value->product_details->radiator_row_count : '',
                    'oil_plan_capacity' => !empty(@$value->product_details->oil_plan_capacity) ? @$value->product_details->oil_plan_capacity : '',
                    'product_images' => !empty($value->product_details->product_images) ? json_decode($value->product_details->product_images) : [],
                    'created_at' => date('Y-m-d H:i:s', strtotime($value->created_at)));
            }
            return $product_array;
        } else {
            return array();
        }
    }

    public function addProductDetails(Request $request) {

        $data = $request->all();
        foreach ($data['products'] as $key => $value) {
            $row = $value;

            $product_array = array();
            $product_detail_array = array();

            if (!isset($row['product_name']) || !isset($row['sku']) || !isset($row['price']) || !isset($row['quantity']) || !isset($row['status']) || !isset($row['category']) || !isset($row['sub_category'])) {

                return response()->json(['status' => "error", "message" => "The following fields are must be in the json request i.e:- product_name,sku,price,quantity,status,category,sub_category"]);
            }

            if (!$category = Category::where('name', 'like', trim($row['category']))->first(array('id'))) {
                $category = Category::create(array('name' => trim($row['category']), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()));
            }

            if (!$sub_category = SubCategory::where('category_id', $category->id)->where('name', 'like', trim($row['sub_category']))->first(array('id', 'category_id'))) {
                $slug = $this->createSlug(trim($row->sub_category), 'category');
                $sub_category = SubCategory::create(array('category_id' => $category->id, 'name' => trim($row['sub_category']), 'slug' => $slug, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()));
            }
            if (isset($row['vehicle_make'])) {
                if (!$vehicle_company = VehicleCompany::where('name', 'like', trim(ucfirst(strtolower($row['vehicle_make']))))->first(array('id'))) {
                    $vehicle_company = VehicleCompany::create(array('name' => trim(ucfirst(strtolower($row['vehicle_make']))), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()));
                }
                $product_array['vehicle_make_id'] = $vehicle_company->id;
            }
            if (isset($row['vehicle_model'])) {
                if (!$vehicle_model = VehicleModel::where('name', 'like', trim(ucfirst(strtolower($row['vehicle_model']))))->first(array('id'))) {
                    $vehicle_model = VehicleModel::create(array('name' => trim(ucfirst(strtolower($row['vehicle_model']))), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()));
                }
                $product_array['vehicle_model_id'] = $vehicle_model->id;
            }


            $product_array = $this->productArray($row, $product_array);
            $product_detail_array = $this->productDetailArray($row, $product_detail_array);

            $product_array['created_at'] = Carbon::now();
            $product_array['updated_at'] = Carbon::now();

            $product_array['product_slug'] = $product_slug = $this->createSlug(trim($row['product_name']), 'product');

            $products = Product::where('sku', 'like', $row['sku'])->first();

            if (!$products) {
                if ($product = Product::create($product_array)) {
                    if (isset($row['product_images']) && !empty($row['product_images']))
                        $product_detail_array['product_images'] = json_encode($row['product_images']);
                    $product_detail_array['product_id'] = $product->id;
                    ProductDetail::create($product_detail_array);
                    ProductCategory::create(array('product_id' => $product->id, 'category_id' => $category->id));
                    ProductSubCategory::create(array('product_id' => $product->id, 'sub_category_id' => $sub_category->id));
                }
            } else {
                return response()->json(['status' => "error", "message" => "Product already exist related to this sku " . $row['sku']]);
            }
        }
        return response()->json(['status' => "success"]);
    }

    public function updateProductDetails(Request $request) {

        $data = $request->all();
        foreach ($data['products'] as $key => $value) {
            $row = $value;
            $products = Product::where('sku', 'like', $row['sku'])->first();

            if ($products) {
                $product_array = array();
                $product_detail_array = array();
                if (isset($row['category'])) {
                    if (!$category = Category::where('name', 'like', trim($row['category']))->first(array('id'))) {
                        return response()->json(['status' => "error", 'message' => $row['category'] . ' category not found !']);
                    } else {

                        if ($product_category = ProductCategory::where('product_id', $products->id)->first()) {
                            $product_category->fill(array('category_id' => $category->id))->save();
                        } else {
                            ProductCategory::create(array('product_id' => $products->id, 'category_id' => $category->id));
                        }
                    }
                }

                if (isset($row['category']) && $row['sub_category']) {
                    if (!$sub_category = SubCategory::where('category_id', $category->id)->where('name', 'like', trim($row['sub_category']))->first(array('id', 'category_id'))) {
                        return response()->json(['status' => "error", 'message' => $row['sub_category'] . ' sub category not found !']);
                    } else {

                        if ($product_sub_category = ProductSubCategory::where('product_id', $products->id)->first()) {
                            $product_sub_category->fill(array('sub_category' => $sub_category->id))->save();
                        } else {
                            ProductSubCategory::create(array('product_id' => $products->id, 'sub_category_id' => $sub_category->id));
                        }
                    }
                }
                if (isset($row['vehicle_make'])) {
                    if (!$vehicle_company = VehicleCompany::where('name', 'like', trim(ucfirst(strtolower($row['vehicle_make']))))->first(array('id'))) {
                        $vehicle_company = VehicleCompany::create(array('name' => trim(ucfirst(strtolower($row['vehicle_make']))), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()));
                    }
                    $product_array['vehicle_make_id'] = $vehicle_company->id;
                }
                if (isset($row['vehicle_model'])) {
                    if (!$vehicle_model = VehicleModel::where('name', 'like', trim(ucfirst(strtolower($row['vehicle_model']))))->first(array('id'))) {
                        $vehicle_model = VehicleModel::create(array('name' => trim(ucfirst(strtolower($row['vehicle_model']))), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()));
                    }
                    $product_array['vehicle_model_id'] = $vehicle_model->id;
                }

                $product_array = $this->productArray($row, $product_array);
                $product_detail_array = $this->productDetailArray($row, $product_detail_array);

                $products->fill($product_array)->save();
                $product_details = ProductDetail::where('product_id', $products->id);
                if ($product_details->count()) {
                    $product_details = $product_details->first();
                    if (isset($row['product_images']) && !empty($row['product_images'])) {
                        if (json_decode($product_details->product_images) != null)
                            $product_detail_array['product_images'] = json_encode(array_merge(json_decode($product_details->product_images), $row['product_images']));
                        else
                            $product_detail_array['product_images'] = json_encode($row['product_images']);
                    }
                    $product_details->fill($product_detail_array)->save();
                }
            } else {
                return response()->json(['status' => "error", "message" => "Product not exist related to this sku" . $row['sku']]);
            }
        }
        return response()->json(['status' => "success"]);
    }

    public function productArray($row, $product_array) {
        if (isset($row['vehicle_year'])) {
            $vehicle_year = explode('-', $row['vehicle_year']);
            $product_array['vehicle_year_from'] = $vehicle_year[0];
            $product_array['vehicle_year_to'] = $vehicle_year[1];
        }

        if (isset($row['product_name']))
            $product_array['product_name'] = trim($row['product_name']);
        if (isset($row['product_long_description']))
            $product_array['product_long_description'] = trim($row['product_long_description']);
        if (isset($row['product_short_description']))
            $product_array['product_short_description'] = trim($row['product_short_description']);
        if (isset($row['vehicle_fit']))
            $product_array['vehicle_fit'] = empty($row['vehicle_fit']) ? null : trim($row['vehicle_fit']);
        if (isset($row['sku']))
            $product_array['sku'] = trim($row['sku']);
        if (isset($row['price']))
            $product_array['price'] = $row['price'];
        if (isset($row['quantity']))
            $product_array['quantity'] = $row['quantity'];
        if (isset($row['discount']))
            $product_array['discount'] = empty($row['discount']) ? null : trim($row['discount']);
        if (isset($row['special_price']))
            $product_array['special_price'] = empty($row['special_price']) ? null : trim($row['special_price']);
        if (isset($row['length']))
            $product_array['length'] = empty($row['length']) ? null : trim($row['length']);
        if (isset($row['weight']))
            $product_array['weight'] = empty($row['weight']) ? null : trim($row['weight']);
        if (isset($row['width']))
            $product_array['width'] = empty($row['width']) ? null : trim($row['width']);
        if (isset($row['height']))
            $product_array['height'] = empty($row['height']) ? null : trim($row['height']);
        if (isset($row['part_type']))
            $product_array['part_type'] = empty($row['part_type']) ? null : trim($row['part_type']);
        if (isset($row['operation']))
            $product_array['operation'] = empty($row['operation']) ? null : trim($row['operation']);
        if (isset($row['wattage']))
            $product_array['wattage'] = empty($row['wattage']) ? null : trim($row['wattage']);
        if (isset($row['mirror_option']))
            $product_array['mirror_option'] = empty($row['mirror_option']) ? null : trim($row['mirror_option']);
        if (isset($row['location']))
            $product_array['location'] = empty($row['location']) ? null : trim($row['location']);
        if (isset($row['size']))
            $product_array['size'] = empty($row['size']) ? null : trim($row['size']);
        if (isset($row['material']))
            $product_array['material'] = empty($row['material']) ? null : trim($row['material']);
        if (isset($row['color']))
            $product_array['color'] = empty($row['color']) ? null : trim($row['color']);

        if (isset($row['front_location']))
            $product_array['front_location'] = empty($row['front_location']) ? null : trim($row['front_location']);
        if (isset($row['side_location']))
            $product_array['side_location'] = empty($row['side_location']) ? null : trim($row['side_location']);
        if (isset($row['includes']))
            $product_array['includes'] = empty($row['includes']) ? null : trim($row['includes']);
        if (isset($row['design']))
            $product_array['design'] = empty($row['design']) ? null : trim($row['design']);
        if (isset($row['product_line']))
            $product_array['product_line'] = empty($row['product_line']) ? null : trim($row['product_line']);
        if (isset($row['status']))
            $product_array['status'] = empty($row['status']) ? 1 : trim($row['status']);
        return $product_array;
    }

    public function productDetailArray($row, $product_detail_array) {
        if (isset($row['meta_title']))
            $product_detail_array['meta_title'] = empty($row['meta_title']) ? null : trim($row['meta_title']);
        if (isset($row['meta_description']))
            $product_detail_array['meta_description'] = empty($row['meta_description']) ? null : trim($row['meta_description']);
        if (isset($row['meta_keyword']))
            $product_detail_array['meta_keyword'] = empty($row['meta_keyword']) ? null : trim($row['meta_keyword']);
        if (isset($row['text']))
            $product_detail_array['text'] = empty($row['text']) ? null : trim($row['text']);
        if (isset($row['sale_type']))
            $product_detail_array['sale_type'] = empty($row['sale_type']) ? null : trim($row['sale_type']);
        if (isset($row['m_code']))
            $product_detail_array['m_code'] = empty($row['m_code']) ? null : trim($row['m_code']);
        if (isset($row['class']))
            $product_detail_array['class'] = empty($row['class']) ? null : trim($row['class']);
        if (isset($row['parse_link']))
            $product_detail_array['parse_link'] = empty($row['parse_link']) ? null : trim($row['parse_link']);
        if (isset($row['oem_number']))
            $product_detail_array['oem_number'] = empty($row['oem_number']) ? null : trim($row['oem_number']);
        if (isset($row['certification']))
            $product_detail_array['certification'] = empty($row['certification']) ? null : trim($row['certification']);
        if (isset($row['warranty']))
            $product_detail_array['warranty'] = empty($row['warranty']) ? null : trim($row['warranty']);
        if (isset($row['software']))
            $product_detail_array['software'] = empty($row['software']) ? null : trim($row['software']);
        if (isset($row['licensed_by']))
            $product_detail_array['licensed_by'] = empty($row['licensed_by']) ? null : trim($row['licensed_by']);
        if (isset($row['car_cover']))
            $product_detail_array['car_cover'] = empty($row['car_cover']) ? null : trim($row['car_cover']);
        if (isset($row['kit_includes']))
            $product_detail_array['kit_includes'] = empty($row['kit_includes']) ? null : trim($row['kit_includes']);
        if (isset($row['fender_flare_type']))
            $product_detail_array['fender_flare_type'] = empty($row['fender_flare_type']) ? null : trim($row['fender_flare_type']);
        if (isset($row['product_grade']))
            $product_detail_array['product_grade'] = empty($row['product_grade']) ? null : trim($row['product_grade']);
        if (isset($row['lighting_bulb_configuration']))
            $product_detail_array['lighting_bulb_configuration'] = empty($row['lighting_bulb_configuration']) ? null : trim($row['lighting_bulb_configuration']);
        if (isset($row['lighting_housing_shape']))
            $product_detail_array['lighting_housing_shape'] = empty($row['lighting_housing_shape']) ? null : trim($row['lighting_housing_shape']);
        if (isset($row['bracket_style']))
            $product_detail_array['bracket_style'] = empty($row['bracket_style']) ? null : trim($row['bracket_style']);
        if (isset($row['lighting_size']))
            $product_detail_array['lighting_size'] = empty($row['lighting_size']) ? null : trim($row['lighting_size']);
        if (isset($row['lighting_beam_pattern']))
            $product_detail_array['lighting_beam_pattern'] = empty($row['lighting_beam_pattern']) ? null : trim($row['lighting_beam_pattern']);
        if (isset($row['lighting_lens_material']))
            $product_detail_array['lighting_lens_material'] = empty($row['lighting_lens_material']) ? null : trim($row['lighting_lens_material']);
        if (isset($row['lighting_mount_type']))
            $product_detail_array['lighting_mount_type'] = empty($row['lighting_mount_type']) ? null : trim($row['lighting_mount_type']);
        if (isset($row['cooling_fan_type']))
            $product_detail_array['cooling_fan_type'] = empty($row['cooling_fan_type']) ? null : trim($row['cooling_fan_type']);
        if (isset($row['radiator_row_count']))
            $product_detail_array['radiator_row_count'] = empty($row['radiator_row_count']) ? null : trim($row['radiator_row_count']);
        if (isset($row['oil_plan_capacity']))
            $product_detail_array['oil_plan_capacity'] = empty($row['oil_plan_capacity']) ? null : trim($row['oil_plan_capacity']);
        return $product_detail_array;
    }

    /**
     * function to create unique slug
     *
     * @param  int  $id
     * @return Response
     */
    public function createSlug($title, $table) {
        // Normalize the title
        $slug = str_slug($title);
        // Get any that could possibly be related.
        // This cuts the queries down by doing it once.
        $allSlugs = $this->getRelatedSlugs($slug, $table);
        // If we haven't used it before then we are all good.
        if (!$allSlugs->contains('slug', $slug)) {
            return $slug;
        }
        // Just append numbers like a savage until we find not used.
        for ($i = 1; $i <= 10; $i++) {
            $newSlug = $slug . '-' . $i;
            if (!$allSlugs->contains('slug', $newSlug)) {
                return $newSlug;
            }
        }
        throw new \Exception('Can not create a unique slug');
    }

    protected function getRelatedSlugs($slug, $table) {
        if ($table == 'category') {
            return SubCategory::select('slug')->where('slug', 'like', $slug . '%')
                            ->get();
        } else {
            return Product::select('product_slug')->where('product_slug', 'like', $slug . '%')
                            ->get();
        }
    }

}
