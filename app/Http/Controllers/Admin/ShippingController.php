<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use View;
use App\ShippingMethod;
use Session;
use Redirect;
use Yajra\Datatables\Facades\Datatables;
use DB;

class ShippingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request) {

        $title = 'Shipping';

        if ($request->ajax()) {
            $shipping_methods = ShippingMethod::get();
            foreach ($shipping_methods as $key => $value) {
                $shipping_methods[$key]['action'] = '<a href="' . route('shipping.show', $value->id) . '" data-toggle="tooltip" title="update" class="glyphicon glyphicon-edit"></a>&nbsp;&nbsp;<a href="' . route('shipping.destroy', $value->id) . '" data-toggle="tooltip" title="delete" data-method="delete" class="glyphicon glyphicon-trash deleteRow"></a>';
            }
            return Datatables::of($shipping_methods)->make(true);
        }
        return View::make('admin.shippings.index', compact('title'));
    }

    /**
     * create a new file
     *
     * @return Response
     */
    public function create() {
        $title = 'Shipping | create';
        return View::make('admin.shippings.add', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request) {
        $data = $request->all();
        $this->validate($request, [
             'name' => 'required|unique:shipping_methods|max:100'
        ]);

        ShippingMethod::create($data);
        return redirect()->route('shipping.index')->with('success-message', 'Added successfully!');
    }

    /**
     * show function.
     *
     * @return Response
     */
    public function show($id) {
        $title = 'Shipping';
        $shipping_methods = ShippingMethod::where('id', $id)->first();
        return View::make('admin.shippings.edit', compact('title', 'shipping_methods'));
    }

//    /**
//     * Update the specified resource in storage.
//     *
//     * @param  int  $id
//     * @return Response
//     */
    public function update(Request $request, $id) {
        $data = $request->all();
        $this->validate($request, [
            'name' => 'required|max:100|unique:shipping_methods,name,' . $id
//            'category_picture' => 'required'
        ]);

        $shipping_methods = ShippingMethod::find($id);

        if (!$shipping_methods) {
            return Redirect::back()
                            ->with('success-message', 'Something went wrong.Please try again later!');
        } else {
            $shipping_methods->fill($data)->save();
            return Redirect::back()
                            ->with('success-message', 'Updated successfully!');
        }
    }

//    /**
//     * Remove the specified resource from storage.
//     *
//     * @param  int  $id
//     * @return Response
//     */
    public function destroy($id) {
        $shipping_methods = ShippingMethod::find($id);

        if (!$shipping_methods) {
            Session::flash('error-message', 'Something went wrong .Please try again later!');
        } else {
            $shipping_methods->delete();
            Session::flash('success-message', 'Deleted successfully !');
        }
        return 'true';
    }

}
