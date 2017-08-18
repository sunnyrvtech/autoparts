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
use App\ProductCategory;
use App\ProductSubCategory;
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
                        $product_images = $this->product_image_upload($row->product_image);
                        $product_detail_array['product_id'] = $product->id;
                        $product_detail_array['product_images'] = $product_images;
                        ProductDetail::create($product_detail_array);
                        ProductCategory::create(array('product_id' => $product->id, 'category_id' => $sub_category->category_id));
                        ProductSubCategory::create(array('product_id' => $product->id, 'sub_category_id' => $sub_category->id));
                    }
                } else {
                    $products->fill($product_array)->save();
                    $product_details = ProductDetail::where('product_id', $products->id);
                    $product_images = $this->product_image_upload($row->product_image);
                    $product_detail_array['product_id'] = $products->id;
                    $product_detail_array['product_images'] = $product_images;
                    if ($product_details->count()) {
                        $product_details = $product_details->first();
                        if ($product_details->product_images != null) {
                            $existing_product_image_array = json_decode($product_details->product_images);

                            if ($existing_product_image_array != '') {
                                foreach ($existing_product_image_array as $exist_val) {
                                    @unlink(base_path('public/product_images/') . $exist_val);
                                }
                            }
                        }
                        $product_details->fill($product_detail_array)->save();
                    } else {
                        ProductDetail::create($product_detail_array);
                    }
                    // delete all products category while update product data
                    ProductCategory::where('product_id', $products->id)->delete();
                    ProductSubCategory::where('product_id', $products->id)->delete();

                    ProductCategory::create(array('product_id' => $products->id, 'category_id' => $sub_category->category_id));
                    ProductSubCategory::create(array('product_id' => $products->id, 'sub_category_id' => $sub_category->id));
                }
            }
        });
        Session::flash('success-message', 'Data import successfully !');
    }

    /**
     * function to import category data using csv file.
     *
     * @param  int  $id
     * @return Response
     */
    public function createCategoryByCsv(Request $request) {
        $path = $request->file('csvFile')->getRealPath();
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
                $filename = str_random(15) . $extention;
                if (@getimagesize($url)) {
                    $file = file_get_contents($url);
                    $save = file_put_contents($path . $filename, $file);
                    $imageArray[$key] = $filename;
                }
            }
            return json_encode(array_values($imageArray));
        } else {
            return null;
        }
    }

    /**
     * function to import sub category data using csv file.
     *
     * @param  int  $id
     * @return Response
     */
    public function createSubCategoryByCsv(Request $request) {
        $path = $request->file('csvFile')->getRealPath();
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
        $path = $request->file('csvFile')->getRealPath();
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
        $path = $request->file('csvFile')->getRealPath();
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
            DB::statement('DELETE FROM product_categories');
            DB::statement('DELETE FROM product_sub_categories');
            DB::statement('DELETE FROM categories');
            DB::statement('DELETE FROM sub_categories');
            DB::statement('DELETE FROM vehicle_models');
            DB::statement('DELETE FROM vehicle_companies');

            DB::statement('ALTER TABLE products AUTO_INCREMENT=1');
            DB::statement('ALTER TABLE categories AUTO_INCREMENT=1');
            DB::statement('ALTER TABLE sub_categories AUTO_INCREMENT=1');
            DB::statement('ALTER TABLE product_details AUTO_INCREMENT=1');
            DB::statement('ALTER TABLE product_categories AUTO_INCREMENT=1');
            DB::statement('ALTER TABLE product_sub_categories AUTO_INCREMENT=1');
            DB::statement('ALTER TABLE vehicle_models AUTO_INCREMENT=1');
            DB::statement('ALTER TABLE vehicle_companies AUTO_INCREMENT=1');
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
        $skip = ($limit == 1) ? 0 : ($limit-1) * $take;
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


            Excel::create($filename, function($excel) use ($export_array) {
                $excel->sheet('Sheetname', function($sheet) use ($export_array) {
                    $sheet->fromArray($export_array, null, 'A1', true);
                });
            })->download('csv');

            return redirect()->route('products.index')->with('success-message', 'Product export successfully !');
        } else {
            return redirect()->route('products.index')->with('error-message', 'No Product found to export !');
        }
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
