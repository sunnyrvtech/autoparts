<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use View;
use App\Product;
use App\ProductDetail;
use App\Brand;
use App\VehicleModel;
use App\VehicleCompany;
use App\Category;
use App\SubCategory;
//use App\ProductCategory;
//use App\ProductSubCategory;
//use App\ProductPriceZone;
use Redirect;
use Session;
use Excel;
use Carbon\Carbon;
use DB;

class ImportController extends Controller {

    /**
     * function to import product data using csv file.
     *
     * @param  int  $id
     * @return Response
     */
    public function uploadCsv(Request $request) {
        $path = $request->file('productCsv')->getRealPath();
        Excel::filter('chunk')->load($path)->chunk(1000, function($results) {
            foreach ($results as $key => $row) {
                $search_keyword = '';
                $search_keyword = trim($row->product_name);
                if (!empty($row->parse_link)) {
                    $search_keyword = $search_keyword . ' ' . trim($row->parse_link);
                }
                if (!empty($row->oem_number)) {
                    $search_keyword = $search_keyword . ' ' . trim($row->oem_number);
                }
                if (!$category = Category::where('name', 'like', trim($row->category))->first(array('id','name'))) {
                    $category = Category::create(array('name' => trim($row->category), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()));
                }

                if (!$sub_category = SubCategory::where('category_id', $category->id)->where('name', 'like', trim($row->sub_category))->first(array('id','name', 'category_id'))) {
                    $slug = $this->createSlug(trim($row->sub_category), 'category');
                    $sub_category = SubCategory::create(array('category_id' => $category->id, 'name' => trim($row->sub_category), 'slug' => $slug, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()));
                }
                if (!$vehicle_company = VehicleCompany::where('name', 'like', trim(ucfirst(strtolower($row->vehicle_make))))->first(array('id','name'))) {
                    $make_slug = $this->createSlug(trim($row->vehicle_make), 'vehicle_make');
                    $vehicle_company = VehicleCompany::create(array('name' => trim(ucfirst(strtolower($row->vehicle_make))), 'slug' => $make_slug, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()));
                }
                if (!$vehicle_model = VehicleModel::where('name', 'like', trim(ucfirst(strtolower($row->vehicle_model))))->first(array('id','name'))) {
                    $model_slug = $this->createSlug(trim($row->vehicle_model), 'vehicle_model');
                    $vehicle_model = VehicleModel::create(array('name' => trim(ucfirst(strtolower($row->vehicle_model))), 'slug' => $model_slug, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()));
                }
                
                $search_keyword = $search_keyword.' '.$category->name.' '.$sub_category->name.' '.$vehicle_company->name.' '.$vehicle_model->name;
                
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
                    'category_id' => $category->id,
                    'sub_category_id' => $sub_category->id,
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
                    'keyword_search' => substr($search_keyword, 0, 255),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                );

                if (isset($row->brand) && !empty($row->brand)) {
                    if (!$brand = Brand::where('name', 'like', trim(ucfirst(strtolower($row->brand))))->first(array('id'))) {
                        $brand = Brand::create(array('name' => trim(ucfirst(strtolower($row->brand))), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()));
                        $product_array['brand_id'] = $brand->id;
                    } else {
                        $product_array['brand_id'] = $brand->id;
                    }
                }



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

                if (isset($row['product_image']) && !empty($row['product_image'])) {
                    $product_images_array = explode("|", $row['product_image']);
                    $product_images = array_map(function($pro_val) {
                        return basename($pro_val);
                    }, $product_images_array);

                    $product_detail_array['product_images'] = json_encode(array_values(array_unique($product_images)));
                }

                if (!$products) {
                    if ($product = Product::create($product_array)) {
                        //$product_images = $this->product_image_upload($row->product_image);
                        $product_detail_array['product_id'] = $product->id;
                        //$product_detail_array['product_images'] = $product_images;
                        ProductDetail::create($product_detail_array);
//                        ProductCategory::create(array('product_id' => $product->id, 'category_id' => $sub_category->category_id));
//                        ProductSubCategory::create(array('product_id' => $product->id, 'sub_category_id' => $sub_category->id));
//                        if (!empty($row->product_region)) {
//                            $zone_ids = array_unique(json_decode($row->product_region));
//                            $product_prices = json_decode($row->product_price);
//                            $this->addZonePrice($products->id, $zone_ids, $product_prices);
//                        }
                    }
                } else {
                    $products->fill($product_array)->save();
                    $product_details = ProductDetail::where('product_id', $products->id);
                    //$product_images = $this->product_image_upload($row->product_image);
                    $product_detail_array['product_id'] = $products->id;
                    //$product_detail_array['product_images'] = $product_images;
                    if ($product_details->count()) {
                        $product_details = $product_details->first();
//                        if ($product_details->product_images != null) {
//                            $existing_product_image_array = json_decode($product_details->product_images);
//
//                            if ($existing_product_image_array != '') {
//                                foreach ($existing_product_image_array as $exist_val) {
//                                    @unlink(base_path('public/product_images/') . $exist_val);
//                                }
//                            }
//                        }
                        $product_details->fill($product_detail_array)->save();
                    } else {
                        ProductDetail::create($product_detail_array);
                    }
                    // delete all products category while update product data
//                    ProductCategory::where('product_id', $products->id)->delete();
//                    ProductSubCategory::where('product_id', $products->id)->delete();
//
//                    ProductCategory::create(array('product_id' => $products->id, 'category_id' => $sub_category->category_id));
//                    ProductSubCategory::create(array('product_id' => $products->id, 'sub_category_id' => $sub_category->id));
////                    if (!empty($row->product_region)) {
//                        $zone_ids = array_unique(json_decode($row->product_region));
//                        $product_prices = json_decode($row->product_price);
//                        $this->addZonePrice($products->id, $zone_ids, $product_prices);
//                    }
                }
            }
        });
        Session::flash('success-message', 'Data import successfully !');
    }

    public function addZonePrice($product_id, $zone_ids, $product_prices) {

        $old_price_data = ProductPriceZone::where('product_id', $product_id)->pluck('zone_id')->toArray();

        // this is used to check if old region is deleted while update
        $check_del_zone_price = array_diff($old_price_data, $zone_ids);
        if ($check_del_zone_price) {
            ProductPriceZone::whereIn('zone_id', $check_del_zone_price)->delete();
        }
        foreach ($zone_ids as $ky => $val) {
            $product_price_zone = ProductPriceZone::where([['product_id', '=', $product_id], ['zone_id', '=', $val]]);
            if ($product_price_zone->count()) {
                $product_price_zone = $product_price_zone->first();
                $product_price_zone->fill(array('product_price' => $product_prices[$ky]))->save();
            } else {
                $region_array = array('product_id' => $product_id, 'zone_id' => $val, 'product_price' => $product_prices[$ky]);
                ProductPriceZone::create($region_array);
            }
        }
        return true;
    }

    /**
     * function to import category data using csv file.
     *
     * @param  int  $id
     * @return Response
     */
    public function createCategoryByCsv(Request $request) {
        $path = $request->file('productCsv')->getRealPath();
        Excel::filter('chunk')->load($path)->chunk(1000, function($results) {
            foreach ($results as $key => $row) {
                $category = Category::where('name', 'like', trim($row->category))->first();
                if (!$category) {
                    $category = Category::create(array('name' => trim($row->category), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()));
                }
                if (!$sub_category = SubCategory::where('category_id', $category->id)->where('name', 'like', trim($row->sub_category))->first(array('id', 'category_id'))) {
                    $slug = $this->createSlug(trim($row->sub_category), 'category');
                    $sub_category = SubCategory::create(array('category_id' => $category->id, 'name' => trim($row->sub_category), 'slug' => $slug, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()));
                }
            }
        });
        Session::flash('success-message', 'Categories import successfully !');
    }

    /**
     * function to upload product images.
     *
     * @param  int  $id
     * @return Response
     */
    public function product_image_upload($images) {
        if ($images != '') {
            $product_images = explode("|", $images);
            $imageArray = array();
            $path = base_path('public/product_images/');
            foreach ($product_images as $key => $val) {
                $url = $val;
                $extention = pathinfo($url, PATHINFO_EXTENSION);
                $filename = basename($url);

                $arrContextOptions = array(
                    "ssl" => array(
                        "verify_peer" => false,
                        "verify_peer_name" => false,
                    ),
                );
                $file = file_get_contents($url, false, stream_context_create($arrContextOptions));
                $save = file_put_contents($path . $filename, $file);
                $imageArray[$key] = $filename;
            }
            return json_encode(array_values($imageArray));
        } else {
            return null;
        }
    }

    /**
     * function to upload product images.
     *
     * @param  int  $id
     * @return Response
     */
    public function uploadProductImages(Request $request) {
        $path = $request->file('imageCsv')->getRealPath();
        Excel::filter('chunk')->load($path)->chunk(1000, function($results) {
            foreach ($results as $key => $row) {
                $products = Product::where('sku', 'like', $row->sku)->first();
                if ($products) {
                    $product_images = $this->product_image_upload($row->product_images);
                    $product_details = ProductDetail::where('product_id', $products->id)->first();
                    $product_details->fill($product_images)->save();
                }
            }
        });
        Session::flash('success-message', 'Product images import successfully !');
    }

    /**
     * function to import sub category data using csv file.
     *
     * @param  int  $id
     * @return Response
     */
    public function createSubCategoryByCsv(Request $request) {
        $path = $request->file('productCsv')->getRealPath();
        Excel::filter('chunk')->load($path)->chunk(1000, function($results) {
            foreach ($results as $key => $row) {
                $category = Category::where('name', 'like', trim($row->category))->first();
                if ($category) {
                    $slug = $this->createSlug(trim($row->sub_category), 'category');
                    $sub_category = SubCategory::where('category_id', $category->id)->where('name', 'like', trim($row->sub_category))->first();
                    if (!$sub_category) {
                        SubCategory::insert(array('category_id' => $category->id, 'name' => trim($row->sub_category), 'slug' => $slug));
                    }
                }
            }
        });
    }

    /**
     * function to import vehicle company data using csv file.
     *
     * @param  int  $id
     * @return Response
     */
    public function createCompanyByCsv(Request $request) {
        $path = $request->file('productCsv')->getRealPath();
        Excel::filter('chunk')->load($path)->chunk(1000, function($results) {

            foreach ($results as $key => $row) {
                $vehicle_company = VehicleCompany::where('name', 'like', trim($row->vehicle_make))->first();
                if (!$vehicle_company) {
                    VehicleCompany::insert(array('name' => trim($row->vehicle_make)));
                }
            }
        });
    }

    /**
     * function to import vehicle model data using csv file.
     *
     * @param  int  $id
     * @return Response
     */
    public function createModelByCsv(Request $request) {
        $path = $request->file('productCsv')->getRealPath();
        Excel::filter('chunk')->load($path)->chunk(1000, function($results) {

            foreach ($results as $key => $row) {
                $vehicle_model = VehicleModel::where('name', 'like', trim($row->vehicle_model))->first();
                if (!$vehicle_model) {
                    VehicleModel::insert(array('name' => trim($row->vehicle_model)));
                }
            }
        });
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

    public function deleteProductData(Request $request) {

        if ($request->get('method') == 'delete_product_data') {
            $products = ProductDetail::Where('id', '>', 1)->get(array('product_images'));

            foreach ($products as $val) {
                if ($val->product_images != null) {
                    $existing_product_image_array = json_decode($val->product_images, true);
                    foreach ($existing_product_image_array as $exist_val) {
                        @unlink(base_path('public/product_images/') . $exist_val);
                        // die;
                    }
                }
            }
            DB::statement('DELETE FROM products');
            DB::statement('DELETE FROM product_details');
//            DB::statement('DELETE FROM product_categories');
//            DB::statement('DELETE FROM product_sub_categories');
            // DB::statement('DELETE FROM categories');
            // DB::statement('DELETE FROM sub_categories');
            // DB::statement('DELETE FROM vehicle_models');
            // DB::statement('DELETE FROM vehicle_companies');

            DB::statement('ALTER TABLE products AUTO_INCREMENT=1');
            // DB::statement('ALTER TABLE categories AUTO_INCREMENT=1');
            //  DB::statement('ALTER TABLE sub_categories AUTO_INCREMENT=1');
            DB::statement('ALTER TABLE product_details AUTO_INCREMENT=1');
//            DB::statement('ALTER TABLE product_categories AUTO_INCREMENT=1');
//            DB::statement('ALTER TABLE product_sub_categories AUTO_INCREMENT=1');
            //   DB::statement('ALTER TABLE vehicle_models AUTO_INCREMENT=1');
            //   DB::statement('ALTER TABLE vehicle_companies AUTO_INCREMENT=1');
            Session::flash('success-message', 'All products data deleted successfully !');
        }
    }

    /**
     * function to import product data using csv file.
     *
     * @param  int  $id
     * @return Response
     */
    public function exportCsv(Request $request) {

        $take = 10000;
        $limit = $request->get('export_product');
        $skip = ($limit == 1) ? 0 : ($limit - 1) * $take;
        $filename = 'product' . $limit;
        $products = Product::take($take)->skip($skip)->get();
        $export_array = array();
        if (!empty($products->toArray())) {

            foreach ($products as $key => $value) {
                $export_array[$key] = array(
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
                    'category' => @$value->get_category->name,
                    'sub_category' => @$value->get_sub_category->name,
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


            $myFile = Excel::create($filename, function($excel) use ($export_array) {
                        $excel->sheet('Sheetname', function($sheet) use ($export_array) {
                            $sheet->fromArray($export_array, null, 'A1', true);
                        });
                    })->download('csv');
//            $myFile = $myFile->string('csv'); //change csv for the format you want, default is xls
//            $response = array(
//                'name' => $filename . '.' . 'csv', //no extention needed
//                'file' => "data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64," . base64_encode($myFile) //mime type of used format
//            );
//            return response()->json($response);
            return redirect()->route('products.index')->with('success-message', 'Product export successfully !');
        } else {
            return redirect()->route('products.index')->with('error-message', 'No Product found to export !');
//            return response()->json('No Product found to export !', 401);
        }
    }

    /**
     * function to import product data using csv file.
     *
     * @param  int  $id
     * @return Response
     */
    public function exportSampleCsv(Request $request) {

        $filename = 'sample';
        $sale_type = "Example sale type";
        $vehicle_make = "Example vehicle make";
        $vehicle_model = "Example vehicle model";
        $vehicle_year = "1997-1999";
        $product_name = "Example Product name";
        $product_long_description = "Example long description";
        $product_short_description = "Example short description";
        $vehicle_fit = "Example vehicle fit";
        $m_code = 2091637;
        $class = 19;
        $part_type = "Example part type";
        $parse_link = "GM2502165,GM2503165";
        $oem_number = 16526200165261;
        $category = "Example category";
        $sub_category = "Example sub category";
        $certification = "Example certification";
        $price = 143.7;
        $special_price = 143.7;
        $discount = 10;
        $quantity = 1;
        $status = 1;
        $weight = 11.5;
        $length = 2;
        $width = 1;
        $height = 1;
        $warranty = "1 Year";
        $brand = "Example brand";
        $operation = "Example operation";
        $wattage = "Example wattage";
        $mirror_option = "Example mirror option";
        $location = "Example location";
        $size = "Example size";
        $material = "Example material";
        $color = "Example color";
        $front_location = "Example front location";
        $side_location = "Example side location";
        $includes = "Example include";
        $design = "Example design";
        $product_line = "Example product line";
        $meta_title = "Example meta title";
        $meta_description = "Example meta description";
        $meta_keyword = "Example meta keyword";
        $software = "Example software";
        $licensed_by = "Example licensed by";
        $car_cover = "Example car cover";
        $kit_includes = "Example ket include";
        $fender_flare_type = "Example fender_flare_type";
        $product_grade = "Example product grade1";
        $lighting_bulb_configuration = "Example lighting bulb configuration";
        $lighting_housing_shape = "Example lighting housing shape";
        $bracket_style = "Example bracket style";
        $lighting_size = "Example lighting size";
        $lighting_beam_pattern = "Example lighting beam pattern";
        $lighting_lens_material = "Example lighting lens material";
        $lighting_mount_type = "Example lighting mount type";
        $cooling_fan_type = "Example cooling fan type";
        $radiator_row_count = "Example radiator row count";
        $oil_plan_capacity = "Example oil_plan_capacity";
        $export_array = array();
        for ($i = 1; $i <= 5; $i++) {
            $export_array[$i] = array(
                'sku' => $i,
                'text' => $i,
                'sale_type' => $sale_type . $i,
                'vehicle_make' => $vehicle_make . $i,
                'vehicle_model' => $vehicle_model . $i,
                'vehicle_year' => $vehicle_year,
                'product_name' => $product_name . $i,
                'product_long_description' => $product_long_description . $i,
                'product_short_description' => $product_long_description . $i,
                'vehicle_fit' => $vehicle_fit . $i,
                'm_code' => $m_code . $i,
                'class' => $class,
                'part_type' => $part_type . $i,
                'parse_link' => $parse_link,
                'oem_number' => $oem_number . $i,
                'category' => $category . $i,
                'sub_category' => $sub_category . $i,
                'certification' => $certification . $i,
                'price' => $price . $i,
                'special_price' => $special_price . $i,
                'discount' => $discount,
                'quantity' => $quantity . $i,
                'status' => $status . $i,
                'weight' => $weight . $i,
                'length' => $length . $i,
                'width' => $width . $i,
                'height' => $height . $i,
                'warranty' => $warranty,
                'brand' => $brand . $i,
                'operation' => $operation . $i,
                'wattage' => $wattage . $i,
                'mirror_option' => $mirror_option . $i,
                'location' => $location . $i,
                'size' => $size . $i,
                'material' => $material . $i,
                'color' => $color . $i,
                'front_location' => $front_location . $i,
                'side_location' => $side_location . $i,
                'includes' => $includes . $i,
                'design' => $design . $i,
                'product_line' => $product_line . $i,
                'meta_title' => $meta_title . $i,
                'meta_description' => $meta_description . $i,
                'meta_keyword' => $meta_keyword . $i,
                'software' => $software . $i,
                'licensed_by' => $licensed_by . $i,
                'car_cover' => $car_cover . $i,
                'kit_includes' => $kit_includes . $i,
                'fender_flare_type' => $fender_flare_type . $i,
                'product_grade' => $product_grade . $i,
                'lighting_bulb_configuration' => $lighting_bulb_configuration . $i,
                'lighting_housing_shape' => $lighting_housing_shape . $i,
                'bracket_style' => $bracket_style . $i,
                'lighting_size' => $lighting_size . $i,
                'lighting_beam_pattern' => $lighting_beam_pattern . $i,
                'lighting_lens_material' => $lighting_lens_material . $i,
                'lighting_mount_type' => $lighting_mount_type . $i,
                'cooling_fan_type' => $cooling_fan_type . $i,
                'radiator_row_count' => $radiator_row_count . $i,
                'oil_plan_capacity' => $oil_plan_capacity . $i);
        }


        $myFile = Excel::create($filename, function($excel) use ($export_array) {
                    $excel->sheet('Sheetname', function($sheet) use ($export_array) {
                        $sheet->fromArray($export_array, null, 'A1', true);
                    });
                })->download('csv');

        return redirect()->route('products.index')->with('success-message', 'Sample file download successfully !');
    }

    protected function getRelatedSlugs($slug, $table) {
        if ($table == 'category') {
            return SubCategory::select('slug')->where('slug', 'like', $slug . '%')
                            ->get();
        } elseif ($table == 'vehicle_make') {
            return VehicleCompany::select('slug')->where('slug', 'like', $slug . '%')
                            ->get();
        } elseif ($table == 'vehicle_model') {
            return VehicleModel::select('slug')->where('slug', 'like', $slug . '%')
                            ->get();
        } else {
            return Product::select('product_slug')->where('product_slug', 'like', $slug . '%')
                            ->get();
        }
    }

}
