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
                    $category = Category::insert(array('name' => trim($row->category)));
                }

                if (!$sub_category = SubCategory::where('category_id', $category->id)->where('name', 'like', trim($row->sub_category))->first(array('id', 'category_id'))) {

                    $slug = $this->createSlug(trim($row->sub_category));
                    $sub_category = SubCategory::insert(array('category_id' => $category->id, 'name' => trim($row->sub_category), 'slug' => $slug));
                }
                if (!$vehicle_company = VehicleCompany::where('name', 'like', trim($row->vehicle_make))->first(array('id'))) {
                    $vehicle_company = VehicleCompany::insert(array('name' => trim($row->vehicle_make)));
                }
                if (!$vehicle_model = VehicleModel::where('name', 'like', trim($row->vehicle_model))->first(array('id'))) {
                    $vehicle_model = VehicleModel::insert(array('name' => trim($row->vehicle_model)));
                }

                $product_array = array(
                    'product_name' => trim($row->product_name),
                    'product_long_description' => trim($row->product_description),
                    'part_number' => trim($row->sku),
                    'price' => $row->price,
                    'quantity' => $row->quantity,
                    'vehicle_year' => $row->vehicle_year,
                    'vehicle_make_id' => $vehicle_company->id,
                    'vehicle_model_id' => $vehicle_model->id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                );


                $products = Product::where('part_number', 'like', $row->sku)->first();

                if (!$products) {
                    if ($product = Product::create($product_array)) {
                        $product_detail_array = array(
                            'product_id' => $product->id
                        );
                        ProductDetail::create($product_detail_array);
                        ProductCategory::create(array('product_id' => $product->id, 'category_id' => $sub_category->category_id));
                        ProductSubCategory::create(array('product_id' => $product->id, 'sub_category_id' => $sub_category->id));
                    }
                }
            }
        });
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
                    Category::insert(array('name' => trim($row->category)));
                }
            }
        });
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
                    $slug = $this->createSlug(trim($row->sub_category));
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
    public function createSlug($title) {
        // Normalize the title
        $slug = str_slug($title);
        // Get any that could possibly be related.
        // This cuts the queries down by doing it once.
        $allSlugs = $this->getRelatedSlugs($slug);
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

    protected function getRelatedSlugs($slug) {
        return SubCategory::select('slug')->where('slug', 'like', $slug . '%')
                        ->get();
    }

}
