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

class ApiController extends Controller {

    /**
     * get order details API.
     *
     * @return Response
     */
    public function getOrderDetails(Request $request) {
        $start = $request->get('start');
        $end = $request->get('end');
        $skip = $start - 1;
        $take = ($end - $start) + 1;

        $filter_array = array(
            'date_from' => $request->get('date_from'),
            'date_to' => date('Y-m-d', strtotime('+1 day', strtotime($request->get('date_to')))),
            'order_from' => $request->get('order_from'),
            'order_to' => $request->get('order_to'),
            'order_id' => $request->get('order_id'),
            'status' => $request->get('status'),
        );

        $orders = Order::Where(function($query) use ($filter_array) {
                    if ($filter_array['date_from'] != null && $filter_array['date_to'] != null) {
                        $query->whereBetween('created_at', [$filter_array['date_from'], $filter_array['date_to']]);
                    }
                    if ($filter_array['order_from'] != null && $filter_array['order_from'] != null) {
                        $query->whereBetween('id', [$filter_array['order_from'], $filter_array['order_to']]);
                    } elseif ($filter_array['order_id'] != null) {
                        $query->Where('id', $filter_array['order_id']);
                    }
                    if ($filter_array['status'] != null) {
                        $query->Where('order_status', $filter_array['status']);
                    }
                })->latest('created_at')->skip($skip)->take($take)->get();

        $order_array = array();
        foreach ($orders as $key => $value) {
            $item_array = array();
            foreach ($value->getOrderDetailById as $k => $val) {
                $item_array[$k]['item_id'] = $val->id;
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
            $order_array[$key]['total_orders'] = Order::count();
            $order_array[$key]['total_pages'] = $orders->count();
            $order_array[$key]['page' . ($key + 1)] = array(
                'order_id' => $value->id,
                'order_date' => date('Y-m-d', strtotime($value->created_at)),
                'customer_name' => $value->getCustomer->first_name . ' ' . $value->getCustomer->last_name,
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
        return $order_array;
    }

    /**
     * post order details API.
     *
     * @return Response
     */
    public function postOrderDetails(Request $request) {

        $data = $request->all();
        foreach ($data as $key => $value) {
            $page_data = $value['page' . ($key + 1)];
            $order = Order::find($page_data['order_id']);
            if ($order) {
                $order->fill(array('order_status' => $page_data['status']))->save();
                foreach ($page_data['items'] as $val) {
                    $update_array = array(
                        'track_id' => $val['track_number'] != '' ? $val['track_number'] : null,
                        'ship_carrier' => $val['ship_carrier'] != '' ? $val['ship_carrier'] : null,
                        'ship_date' => $val['ship_date'] != '' ? $val['ship_date'] : null,
                        'notes' => $val['notes'] != '' ? $val['notes'] : null,
                    );
                    if ($order_details = OrderDetail::find($val['item_id'])) {
                        $order_details->fill($update_array)->save();
                    }
                }
            }
        }

        return response()->json(['status' => "success"]);
//        
//        
//        
//
//
//        $path = $request->file('csvFile')->getRealPath();
//
//        Excel::filter('chunk')->load($path)->chunk(1000, function($results) {
//            foreach ($results as $key => $value) {
//                $order = Order::find($value->order_id);
//                if ($order) {
//                    $order->fill(array('order_status' => $value->status))->save();
//                    $order_detail_ids = OrderDetail::Where('order_id', $value->order_id)->get(array('id'));
//                    $track_ids = explode('|', $value->track_id);
//                    if (!empty($track_ids)) {
//                        foreach ($order_detail_ids as $key => $val) {
//                            $order_details = OrderDetail::find($val->id);
//                            if (isset($track_ids[$key])) {
//                                $track_id = $track_ids[$key];
//                            } else {
//                                $track_id = $track_ids[$key - 1];
//                            }
//                            $order_details->fill(array('track_id' => $track_id))->save();
//                        }
//                    }
//                }
//            }
//        });
//        return response()->json(['status' => "success"]);
    }

    public function getProductDetails(Request $request) {

        $start = $request->get('start') ? $request->get('start') : 1;
        $end = $request->get('end') ? $request->get('end') : 10;
        $skip = $start - 1;
        $take = ($end - $start) + 1;
        $products = Product::take($take)->skip($skip)->get();
        $product_array = array();
        if (!empty($products->toArray())) {
            foreach ($products as $key => $value) {
                $product_array[$key] = array(
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
                    'special_price' => $value->special_price,
                    'discount' => $value->discount,
                    'quantity' => $value->quantity,
                    'status' => $value->status,
                    'weight' => $value->weight,
                    'length' => $value->length,
                    'width' => $value->width,
                    'height' => $value->height,
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
                    'oil_plan_capacity' => !empty(@$value->product_details->oil_plan_capacity) ? @$value->product_details->oil_plan_capacity : '');
            }
            return $product_array;
        } else {
            return redirect()->route('products.index')->with('error-message', 'No Product found to export !');
        }
    }

    public function postProductDetails(Request $request) {
        $path = $request->file('csvFile')->getRealPath();
        Excel::filter('chunk')->load($path)->chunk(1000, function($results) {
            foreach ($results as $key => $row) {

                if (!$category = Category::where('name', 'like', trim($row->category))->first(array('id'))) {
                    $category = Category::create(array('name' => trim($row->category), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()));
                }

                if (!$sub_category = SubCategory::where('category_id', $category->id)->where('name', 'like', trim($row->sub_category))->first(array('id', 'category_id'))) {
                    $slug = $this->createSlug(trim($row->sub_category), 'category');
                    $sub_category = SubCategory::create(array('category_id' => $category->id, 'name' => trim($row->sub_category), 'slug' => $slug, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()));
                }
                if (!$vehicle_company = VehicleCompany::where('name', 'like', trim(ucfirst(strtolower($row->vehicle_make))))->first(array('id'))) {
                    $vehicle_company = VehicleCompany::create(array('name' => trim(ucfirst(strtolower($row->vehicle_make))), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()));
                }
                if (!$vehicle_model = VehicleModel::where('name', 'like', trim(ucfirst(strtolower($row->vehicle_model))))->first(array('id'))) {
                    $vehicle_model = VehicleModel::create(array('name' => trim(ucfirst(strtolower($row->vehicle_model))), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()));
                }

                $product_slug = $this->createSlug(trim($row->product_name), 'product');
                $vehicle_year = explode('-', $row->vehicle_year);
                $product_array = array(
                    'product_name' => trim($row->product_name),
                    'product_slug' => $product_slug,
                    'product_long_description' => trim($row->product_long_description),
                    'product_short_description' => trim($row->product_short_description),
                    'vehicle_fit' => empty($row->vehicle_fit) ? null : trim($row->vehicle_fit),
                    'sku' => trim($row->sku),
                    'price' => $row->price,
                    'quantity' => $row->quantity,
                    'discount' => $row->discount,
                    'special_price' => $row->special_price,
                    'vehicle_year_from' => $vehicle_year[0],
                    'vehicle_year_to' => $vehicle_year[1],
                    'vehicle_make_id' => $vehicle_company->id,
                    'vehicle_model_id' => $vehicle_model->id,
                    'length' => empty($row->length) ? null : trim($row->length),
                    'weight' => empty($row->weight) ? null : trim($row->weight),
                    'width' => empty($row->width) ? null : trim($row->width),
                    'height' => empty($row->height) ? null : trim($row->height),
                    'part_type' => empty($row->part_type) ? null : trim($row->part_type),
                    'operation' => empty($row->operation) ? null : trim($row->operation),
                    'wattage' => empty($row->wattage) ? null : trim($row->wattage),
                    'mirror_option' => empty($row->mirror_option) ? null : trim($row->mirror_option),
                    'location' => empty($row->location) ? null : trim($row->location),
                    'size' => empty($row->size) ? null : trim($row->size),
                    'material' => empty($row->material) ? null : trim($row->material),
                    'color' => empty($row->color) ? null : trim($row->color),
                    'front_location' => empty($row->front_location) ? null : trim($row->front_location),
                    'side_location' => empty($row->side_location) ? null : trim($row->side_location),
                    'includes' => empty($row->includes) ? null : trim($row->includes),
                    'design' => empty($row->design) ? null : trim($row->design),
                    'product_line' => empty($row->product_line) ? null : trim($row->product_line),
                    'status' => empty($row->status) ? 1 : trim($row->status),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                );

                $product_detail_array = array(
                    'meta_title' => empty($row->meta_title) ? null : trim($row->meta_title),
                    'meta_description' => empty($row->meta_description) ? null : trim($row->meta_description),
                    'meta_keyword' => empty($row->meta_keyword) ? null : trim($row->meta_keyword),
                    'text' => empty($row->text) ? null : trim($row->text),
                    'sale_type' => empty($row->sale_type) ? null : trim($row->sale_type),
                    'm_code' => empty($row->m_code) ? null : trim($row->m_code),
                    'class' => empty($row->class) ? null : trim($row->class),
                    'parse_link' => empty($row->parse_link) ? null : trim($row->parse_link),
                    'oem_number' => empty($row->oem_number) ? null : trim($row->oem_number),
                    'certification' => empty($row->certification) ? null : trim($row->certification),
                    'warranty' => empty($row->warranty) ? null : trim($row->warranty),
                    'software' => empty($row->software) ? null : trim($row->software),
                    'licensed_by' => empty($row->licensed_by) ? null : trim($row->licensed_by),
                    'car_cover' => empty($row->car_cover) ? null : trim($row->car_cover),
                    'kit_includes' => empty($row->kit_includes) ? null : trim($row->kit_includes),
                    'fender_flare_type' => empty($row->fender_flare_type) ? null : trim($row->fender_flare_type),
                    'product_grade' => empty($row->product_grade) ? null : trim($row->product_grade),
                    'lighting_bulb_configuration' => empty($row->lighting_bulb_configuration) ? null : trim($row->lighting_bulb_configuration),
                    'lighting_housing_shape' => empty($row->lighting_housing_shape) ? null : trim($row->lighting_housing_shape),
                    'bracket_style' => empty($row->bracket_style) ? null : trim($row->bracket_style),
                    'lighting_size' => empty($row->lighting_size) ? null : trim($row->lighting_size),
                    'lighting_beam_pattern' => empty($row->lighting_beam_pattern) ? null : trim($row->lighting_beam_pattern),
                    'lighting_lens_material' => empty($row->lighting_lens_material) ? null : trim($row->lighting_lens_material),
                    'lighting_mount_type' => empty($row->lighting_mount_type) ? null : trim($row->lighting_mount_type),
                    'cooling_fan_type' => empty($row->cooling_fan_type) ? null : trim($row->cooling_fan_type),
                    'radiator_row_count' => empty($row->radiator_row_count) ? null : trim($row->radiator_row_count),
                    'oil_plan_capacity' => empty($row->oil_plan_capacity) ? null : trim($row->oil_plan_capacity),
                );


                $products = Product::where('sku', 'like', $row->sku)->first();

                if (!$products) {
                    if ($product = Product::create($product_array)) {
                        $product_detail_array['product_id'] = $product->id;
                        ProductDetail::create($product_detail_array);
                        ProductCategory::create(array('product_id' => $product->id, 'category_id' => $sub_category->category_id));
                        ProductSubCategory::create(array('product_id' => $product->id, 'sub_category_id' => $sub_category->id));
//                        if (!empty($row->product_region)) {
//                            $zone_ids = array_unique(json_decode($row->product_region));
//                            $product_prices = json_decode($row->product_price);
//                            $this->addZonePrice($products->id, $zone_ids, $product_prices);
//                        }
                    }
                } else {
                    $products->fill($product_array)->save();
                    $product_details = ProductDetail::where('product_id', $products->id);
                    $product_detail_array['product_id'] = $products->id;
                    if ($product_details->count()) {
                        $product_details = $product_details->first();
                        $product_details->fill($product_detail_array)->save();
                    } else {
                        ProductDetail::create($product_detail_array);
                    }
                    // delete all products category while update product data
                    ProductCategory::where('product_id', $products->id)->delete();
                    ProductSubCategory::where('product_id', $products->id)->delete();

                    ProductCategory::create(array('product_id' => $products->id, 'category_id' => $sub_category->category_id));
                    ProductSubCategory::create(array('product_id' => $products->id, 'sub_category_id' => $sub_category->id));
//                    if (!empty($row->product_region)) {
//                        $zone_ids = array_unique(json_decode($row->product_region));
//                        $product_prices = json_decode($row->product_price);
//                        $this->addZonePrice($products->id, $zone_ids, $product_prices);
//                    }
                }
            }
        });
        return response()->json(['status' => "success"]);
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
