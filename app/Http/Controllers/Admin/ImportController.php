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

                $product_array = array(
                    'product_name' => trim($row->product_name),
                    'product_slug' => $product_slug,
                    'product_long_description' => trim($row->product_long_description),
                    'product_short_description' => trim($row->product_short_description),
                    'vehicle_fit' => trim($row->vehicle_fit),
                    'sku' => trim($row->sku),
                    'price' => $row->price,
                    'quantity' => $row->quantity,
                    'vehicle_year' => $row->vehicle_year,
                    'vehicle_make_id' => $vehicle_company->id,
                    'vehicle_model_id' => $vehicle_model->id,
                    'length' => $row->length,
                    'weight' => $row->weight,
                    'width' => $row->width,
                    'height' => $row->height,
                    'part_type' => $row->part_type,
                    'operation' => $row->operation,
                    'wattage' => $row->wattage,
                    'mirror_option' => $row->mirror_option,
                    'location' => $row->location,
                    'size' => $row->size,
                    'material' => $row->material,
                    'color' => $row->color,
                    'front_location' => $row->front_location,
                    'side_location' => $row->side_location,
                    'includes' => $row->includes,
                    'design' => $row->design,
                    'product_line' => $row->product_line,
                    'status' => $row->status,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                );

                $product_detail_array = array(
                    'meta_title' => $row->meta_title,
                    'meta_description' => $row->meta_description,
                    'meta_keyword' => $row->meta_keyword,
                    'text' => $row->text,
                    'sale_type' => $row->sale_type,
                    'm_code' => $row->m_code,
                    'class' => $row->class,
                    'parse_link' => $row->parse_link,
                    'certification' => $row->certification,
                    'warranty' => $row->warranty,
                    'software' => $row->software,
                    'licensed_by' => $row->licensed_by,
                    'car_cover' => $row->car_cover,
                    'kit_includes' => $row->kit_includes,
                    'fender_flare_type' => $row->fender_flare_type,
                    'product_grade' => $row->product_grade,
                    'lighting_bulb_configuration' => $row->lighting_bulb_configuration,
                    'lighting_housing_shape' => $row->lighting_housing_shape,
                    'bracket_style' => $row->bracket_style,
                    'lighting_size' => $row->lighting_size,
                    'lighting_beam_pattern' => $row->lighting_beam_pattern,
                    'lighting_mount_type' => $row->lighting_mount_type,
                    'cooling_fan_type' => $row->cooling_fan_type,
                    'radiator_row_count' => $row->radiator_row_count,
                    'oil_plan_capacity' => $row->oil_plan_capacity,
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
                    $product_details = $product_details->first();
                    $existing_product_image_array = json_decode($product_details->product_images);

                    if ($existing_product_image_array != '') {
                        foreach ($existing_product_image_array as $exist_val) {
                            @unlink(base_path('public/product_images/') . $exist_val);
                        }
                    }

                    $product_images = $this->product_image_upload($row->product_image);
                    $product_detail_array['product_id'] = $products->id;
                    $product_detail_array['product_images'] = $product_images;
                    $product_details->fill($product_detail_array)->save();
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
                $file = file_get_contents($url);
                $save = file_put_contents($path . $filename, $file);
                $imageArray[$key] = $filename;
            }
            return json_encode($imageArray);
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
