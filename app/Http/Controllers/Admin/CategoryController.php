<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use View;
use Redirect;
use App\Category;
use Yajra\Datatables\Facades\Datatables;

class CategoryController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request) {
        $title = 'Categories';
        if ($request->ajax()) {
            return Datatables::of(Category::query())->make(true);
        }
        return View::make('admin.categories.index', compact('title'));
    }

    /**
     * create a new file
     *
     * @return Response
     */
    public function create() {
        $title = 'Categories | create';
        return View::make('admin.categories.add', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request) {
        $data = $request->all();
        $this->validate($request, [
            'name' => 'required|unique:categories|max:50'
//            'category_picture' => 'required'
        ]);

        if ($request->file('category_picture')) {
            if ($request->hasFile('category_picture')) {
                $image = $request->file('category_picture');
                $type = $image->getClientMimeType();
                if ($type == 'image/png' || $type == 'image/jpg' || $type == 'image/jpeg') {
                    $filename = time() . '.' . $image->getClientOriginalExtension();
                    $path = base_path('public/category/');
                    $image->move($path, $filename);
                    $data['category_image'] = $filename;
                }
            }
        }

        Category::create($data);
        return Redirect::back()
                        ->with('success-message', 'Category inserted successfully!');
    }
    
    /**
     * show function.
     *
     * @return Response
     */
    
    public function show(Request $request,$id){
        
    }

//    /**
//     * Update the specified resource in storage.
//     *
//     * @param  int  $id
//     * @return Response
//     */
//    public function update($id) {
//        
//    }
//
//    /**
//     * Remove the specified resource from storage.
//     *
//     * @param  int  $id
//     * @return Response
//     */
//    public function destroy($id) {
//        
//    }
}
