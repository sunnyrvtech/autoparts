<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ProductZone;
use App\State;
use View;
use Redirect;
use Session;
use Yajra\Datatables\Facades\Datatables;

class ProductZoneController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request) {
        $title = 'Zones';
        if ($request->ajax()) {
            $product_zones = ProductZone::get();
            foreach ($product_zones as $key => $value) {
                $state_ids = json_decode($value->state_id);
                $state_name = State::WhereIn('id',$state_ids)->pluck('name')->toArray();
                $product_zones[$key]['action'] = '<a href="' . route('zones.show', $value->id) . '" data-toggle="tooltip" title="update" class="glyphicon glyphicon-edit"></a>&nbsp;&nbsp;<a href="' . route('zones.destroy', $value->id) . '" data-toggle="tooltip" title="delete" data-method="delete" class="glyphicon glyphicon-trash deleteRow"></a>';
                $product_zones[$key]['state_name'] = implode(', ',$state_name);
            }
            return Datatables::of($product_zones)->make(true);
        }
        return View::make('admin.product_zones.index', compact('title'));
    }

    /**
     * create a new file
     *
     * @return Response
     */
    public function create() {
        $title = 'Zones | create';
        $states = State::Where('country_id', 231)->whereNotNull('postal_code')->get();
        return View::make('admin.product_zones.add', compact('title', 'states'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request) {
        $data = $request->all();
        $this->validate($request, [
            'zone_name' => 'required',
            'states' => 'required'
        ]);

        $data['state_id'] = json_encode($data['states']);

        ProductZone::create($data);
        return redirect()->route('zones.index')
                        ->with('success-message', 'Zone created successfully!');
    }
    
    /**
     * show function.
     *
     * @return Response
     */
    public function show(Request $request, $id) {
        $title = 'Zones | update';
        $product_zones = ProductZone::where('id', $id)->first();
        $states = State::Where('country_id', 231)->whereNotNull('postal_code')->get();
        return View::make('admin.product_zones.edit', compact('title', 'product_zones','states'));
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
            'zone_name' => 'required',
            'states' => 'required'
        ]);

        $data['state_id'] = json_encode($data['states']);
        $product_zones = ProductZone::findOrFail($id);
        $product_zones->fill($data)->save();

        return redirect()->route('zones.index')
                        ->with('success-message', 'Zone updated successfully!');
    }
    
     //    /**
//     * Remove the specified resource from storage.
//     *
//     * @param  int  $id
//     * @return Response
//     */
    public function destroy($id) {
        $product_zones = ProductZone::find($id);

        if (!$product_zones) {
            Session::flash('error-message', 'Something went wrong .Please try again later!');
        } else {
            $product_zones->delete();
            Session::flash('success-message', 'Deleted successfully !');
        }
        return 'true';
    }

}
