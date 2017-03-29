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
            $categories = Category::get();
            foreach ($categories as $key => $value) {
                $categories[$key]['action'] = '<a href="' . route('subcategories.show', $value->id) . '" data-toggle="tooltip" title="update" class="glyphicon glyphicon-eye-open"></a>&nbsp;<a href="' . route('categories.show', $value->id) . '" data-toggle="tooltip" title="update" class="glyphicon glyphicon-edit"></a>';
            }
            return Datatables::of($categories)->make(true);
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
    public function show(Request $request, $id) {
        $title = 'Categories | update';
        $categories = Category::where('id', $id)->first();
        return View::make('admin.categories.edit', compact('title', '$categories'));
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
