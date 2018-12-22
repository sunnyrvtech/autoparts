<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use View;
use App\ShippingRate;
use App\Country;
use Session;
use Redirect;
use Yajra\Datatables\Facades\Datatables;
use DB;

class ShippingRateController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request) {

        $title = 'Shipping Rate';

        if ($request->ajax()) {
            $shipping_rates = ShippingRate::with(['get_country'])->get();
            foreach ($shipping_rates as $key => $value) {
                $shipping_rates[$key]['action'] = '<a href="' . route('shipping_rates.show', $value->id) . '" data-toggle="tooltip" title="update" class="glyphicon glyphicon-edit"></a>&nbsp;&nbsp;<a href="' . route('shipping_rates.destroy', $value->id) . '" data-toggle="tooltip" title="delete" data-method="delete" class="glyphicon glyphicon-trash deleteRow"></a>';
            }
            return Datatables::of($shipping_rates)->make(true);
        }
        return View::make('admin.ship_rates.index', compact('title'));
    }

    /**
     * create a new file
     *
     * @return Response
     */
    public function create() {
        $title = 'Shipping Rate | create';
        $countries = Country::get(array('name', 'id'));
        return View::make('admin.ship_rates.add', compact('title', 'countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request) {
        $data = $request->all();
        $this->validate($request, [
            'country_id' => 'required',
//            'low_weight' => 'required|numeric',
//            'high_weight' => 'required|numeric',
            'price' => 'required',
        ]);

        $shipping_rates = ShippingRate::Where('country_id', $data['country_id'])->first();

        if ($shipping_rates) {
            if ($shipping_rates->ship_type != $data['ship_type']) {
                return Redirect::back()
                                ->with('error-message', 'Sorry !  The other ship type is already exist for this country.');
            }
        }

        if ($request->get('zip_code') != null && $request->get('ship_type') == 'zip_biased') {
            $data['zip_code'] = json_encode(explode(',', $data['zip_code']));
            $data['low_weight'] = null;
            $data['high_weight'] = null;
        } else {
            $data['zip_code'] = null;
        }

        if ($request->get('low_weight') == null && $request->get('high_weight') == null) {
            $data['low_weight'] = null;
            $data['high_weight'] = null;
        }
        if ($request->get('sku')) {
            $data['sku'] = json_encode(explode(',', $data['sku']));
        }

        ShippingRate::create($data);
        return redirect()->route('shipping_rates.index')->with('success-message', 'Added successfully!');
    }

    /**
     * show function.
     *
     * @return Response
     */
    public function show($id) {
        $title = 'Shipping Rate';
        $countries = Country::get(array('name', 'id'));
        $shipping_rates = ShippingRate::where('id', $id)->first();
        return View::make('admin.ship_rates.edit', compact('title', 'shipping_rates', 'countries'));
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
            'country_id' => 'required',
//            'low_weight' => 'required|numeric',
//            'high_weight' => 'required|numeric',
            'price' => 'required',
        ]);

        $shipping_rates = ShippingRate::find($id);

        if ($request->get('zip_code') != null) {
            $data['zip_code'] = json_encode(explode(',', $data['zip_code']));
            $data['low_weight'] = null;
            $data['high_weight'] = null;
        } else {
            $data['zip_code'] = null;
        }

        if ($request->get('low_weight') == null && $request->get('high_weight') == null) {
            $data['low_weight'] = null;
            $data['high_weight'] = null;
        }

        if ($request->get('sku')) {
            $data['sku'] = json_encode(explode(',', $data['sku']));
        }else{
            $data['sku'] = null;
        }
        
        if (!$shipping_rates) {
            return Redirect::back()
                            ->with('success-message', 'Something went wrong.Please try again later!');
        } else {
            $shipping_rates->fill($data)->save();
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
        $shipping_rates = ShippingRate::find($id);

        if (!$shipping_rates) {
            Session::flash('error-message', 'Something went wrong .Please try again later!');
        } else {
            $shipping_rates->delete();
            Session::flash('success-message', 'Deleted successfully !');
        }
        return 'true';
    }

}
