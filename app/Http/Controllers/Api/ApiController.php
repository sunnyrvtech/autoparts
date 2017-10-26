<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use App\OrderDetail;
use App\Product;
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
        $orders = Order::latest('created_at')->skip($skip)->take($take)->get();
        $order_array = array();
        foreach ($orders as $key => $value) {
//            echo $value->getCustomer->id;
//            die;
            $order_array[$key]['order_id'] = $value->id;
            $order_array[$key]['customer_name'] = $value->getCustomer->first_name . ' ' . $value->getCustomer->last_name;
            $product_array = array();
            $product_name = '';
            $sku_number = '';
            $quantity = '';
            $price = '';
            $discount = '';
            $track_id = '';
            foreach ($value->getOrderDetailById as $k => $val) {
                $track_id .= $val->track_id . '|';
                $product_name .= $val->product_name . '|';
                $sku_number .= $val->sku_number . '|';
                $quantity .= $val->quantity . '|';
                $price .= $val->total_price / $val->quantity . '|';
                $discount .= $val->discount . '|';
            }
            $order_array[$key]['track_id'] = rtrim($track_id, '|');
            $order_array[$key]['product_name'] = rtrim($product_name, '|');
            $order_array[$key]['sku_number'] = rtrim($sku_number, '|');
            $order_array[$key]['quantity'] = rtrim($quantity, '|');
            $order_array[$key]['price'] = rtrim($price, '|');
            $order_array[$key]['discount'] = rtrim($discount, '|');
            $order_array[$key]['ship_price'] = $value->ship_price;
            $order_array[$key]['tax'] = $value->tax_rate;
            $order_array[$key]['total_price'] = $value->total_price;
            $order_array[$key]['shipping_method'] = $value->shipping_method;
            $order_array[$key]['payment_method'] = $value->payment_method;

            $order_array[$key]['billing_address'] = $value->getCustomer->getBillingDetails->address1 . ',' . $value->getCustomer->getBillingDetails->city . ',' . $value->getCustomer->getBillingDetails->get_state->name . ',' . $value->getCustomer->getBillingDetails->zip . ',' . $value->getCustomer->getBillingDetails->get_country->name;
            $order_array[$key]['shipping_address'] = $value->getCustomer->getShippingDetails->address1 . ',' . $value->getCustomer->getShippingDetails->city . ',' . $value->getCustomer->getShippingDetails->get_state->name . ',' . $value->getCustomer->getShippingDetails->zip . ',' . $value->getCustomer->getShippingDetails->get_country->name;

            $order_array[$key]['status'] = $value->order_status;
        }
        return $order_array;
    }

    /**
     * post order details API.
     *
     * @return Response
     */
    public function postOrderDetails(Request $request) {


        $path = $request->file('csvFile')->getRealPath();

        Excel::filter('chunk')->load($path)->chunk(1000, function($results) {
            foreach ($results as $key => $value) {
                $order = Order::find($value->order_id);
                if ($order) {
                    $order->fill(array('order_status' => $value->status))->save();
                    $order_detail_ids = OrderDetail::Where('order_id', $value->order_id)->get(array('id'));
                    $track_ids = explode('|', $value->track_id);
                    if (!empty($track_ids)) {
                        foreach ($order_detail_ids as $key => $val) {
                            $order_details = OrderDetail::find($val->id);
                            if (isset($track_ids[$key])) {
                                $track_id = $track_ids[$key];
                            } else {
                                $track_id = $track_ids[$key - 1];
                            }
                            $order_details->fill(array('track_id' => $track_id))->save();
                        }
                    }
                }
            }
        });
        return response()->json(['status' => "success"]);
    }

    public function getProductDetails(Request $request) {

        $start = $request->get('start');
        $end = $request->get('end');
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
                    'warranty' => @$value->product_details->warranty,
                    'brand' => @$value->get_brands->name,
                    'operation' => $value->operation,
                    'wattage' => $value->wattage,
                    'mirror_option' => $value->mirror_option,
                    'location' => $value->location,
                    'size' => $value->size,
                    'material' => $value->material,
                    'color' => $value->color,
                    'front_location' => $value->front_location,
                    'side_location' => $value->side_location,
                    'includes' => $value->includes,
                    'design' => $value->design,
                    'product_line' => $value->product_line,
                    'meta_title' => @$value->product_details->meta_title,
                    'meta_description' => @$value->product_details->meta_description,
                    'meta_keyword' => @$value->product_details->meta_keyword,
                    'software' => @$value->product_details->software,
                    'licensed_by' => @$value->product_details->licensed_by,
                    'car_cover' => @$value->product_details->car_cover,
                    'kit_includes' => @$value->product_details->kit_includes,
                    'fender_flare_type' => @$value->product_details->fender_flare_type,
                    'product_grade' => @$value->product_details->product_grade,
                    'lighting_bulb_configuration' => @$value->product_details->lighting_bulb_configuration,
                    'lighting_housing_shape' => @$value->product_details->lighting_housing_shape,
                    'bracket_style' => @$value->product_details->bracket_style,
                    'lighting_size' => @$value->product_details->lighting_size,
                    'lighting_beam_pattern' => @$value->product_details->lighting_beam_pattern,
                    'lighting_lens_material' => @$value->product_details->lighting_lens_material,
                    'lighting_mount_type' => @$value->product_details->lighting_mount_type,
                    'cooling_fan_type' => @$value->product_details->cooling_fan_type,
                    'radiator_row_count' => @$value->product_details->radiator_row_count,
                    'oil_plan_capacity' => @$value->product_details->oil_plan_capacity);
            }

            return $product_array;
        } else {
            return redirect()->route('products.index')->with('error-message', 'No Product found to export !');
        }
    }

}
