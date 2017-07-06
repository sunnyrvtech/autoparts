<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use View;
use App\WarehouseStore;
use Redirect;
use Session;
use Yajra\Datatables\Facades\Datatables;

class WareHouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request) {
        $title = 'Warehouse Store';
        if ($request->ajax()) {
            $warehouse = WarehouseStore::get();
            foreach ($warehouse as $key => $value) {
                $warehouse[$key]['action'] = '<a href="' . route('warehouses.show', $value->id) . '" data-toggle="tooltip" title="update" class="glyphicon glyphicon-edit"></a>&nbsp;&nbsp<a href="' . route('warehouses.destroy', $value->id) . '" data-toggle="tooltip" title="delete" data-method="delete" class="glyphicon glyphicon-trash deleteRow"></a>';
            }
            return Datatables::of($warehouse)->make(true);
        }
        return View::make('admin.warehouses.index', compact('title'));
    }

    /**
     * create a new file
     *
     * @return Response
     */
    public function create() {
        $title = 'Warehouse | create';
        return View::make('admin.warehouses.add', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request) {
        $data = $request->all();
        $this->validate($request, [
            'store_name' => 'required|max:100',
            'email' => 'required|email|max:150|unique:warehouse_stores',
            'address' => 'required|max:150',
            'country' => 'required|max:100',
            'state' => 'required|max:100',
            'city' => 'required|max:100',
            'zip' => 'required|max:6',
        ]);

        $address = str_replace(" ", "+", $data['country']) . "+" . str_replace(" ", "+", $data['state']) . "+" . str_replace(" ", "+", $data['city']) . "+" . str_replace(" ", "+", $data['address']) . "+" . $data['zip'];
        $url = "http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&region=USA";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        $response_a = json_decode($response);
        if (isset($response_a->results[0]->geometry->location->lat)) {
            $data['latitude'] = $response_a->results[0]->geometry->location->lat;
            $data['longitude'] = $response_a->results[0]->geometry->location->lng;
        } else {
            $data['latitude'] = null;
            $data['longitude'] = null;
        }
        WarehouseStore::create($data);
        return Redirect::back()
                        ->with('success-message', 'Store created successfully!');
    }

    /**
     * show function.
     *
     * @return Response
     */
    public function show(Request $request, $id) {
        $title = 'Warehouse | update';
        $warehouse = WarehouseStore::where('id', $id)->first();
        return View::make('admin.warehouses.edit', compact('title', 'warehouse'));
    }

//
//    /**
//     * Update the specified resource in storage.
//     *
//     * @param  int  $id
//     * @return Response
//     */
    public function update(Request $request, $id) {
        $title = 'Warehouse | update';
        $data = $request->all();
        $this->validate($request, [
            'store_name' => 'required|max:100',
            'email' => 'required|email|max:150|unique:warehouse_stores,email,'.$id,
            'address' => 'required|max:150',
            'country' => 'required|max:100',
            'state' => 'required|max:100',
            'city' => 'required|max:100',
            'zip' => 'required|max:6',
        ]);

        $address = str_replace(" ", "+", $data['country']) . "+" . str_replace(" ", "+", $data['state']) . "+" . str_replace(" ", "+", $data['city']) . "+" . str_replace(" ", "+", $data['address']) . "+" . $data['zip'];
        $url = "http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&region=USA";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        $response_a = json_decode($response);
        if (isset($response_a->results[0]->geometry->location->lat)) {
            $data['latitude'] = $response_a->results[0]->geometry->location->lat;
            $data['longitude'] = $response_a->results[0]->geometry->location->lng;
        } else {
            $data['latitude'] = null;
            $data['longitude'] = null;
        }
        $warehouse = WarehouseStore::findOrFail($id);
        $warehouse->fill($data)->save();

        return Redirect::back()
                        ->with('success-message', 'Store updated successfully!');
    }

/**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        $warehouse = WarehouseStore::find($id);

        if (!$warehouse) {
            Session::flash('error-message', 'Something went wrong .Please try again later!');
        } else {
            $warehouse->delete();
            Session::flash('success-message', 'Store deleted successfully !');
        }
        return 'true';
    }
}
