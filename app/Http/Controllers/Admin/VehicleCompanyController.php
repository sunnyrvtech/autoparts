<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use View;
use Redirect;
use App\VehicleCompany;
use Session;
use Yajra\Datatables\Facades\Datatables;

class VehicleCompanyController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request) {
        $title = 'Vehicle';
        if ($request->ajax()) {

            $vehicle_companies = VehicleCompany::get();
            foreach ($vehicle_companies as $key => $value) {
                $vehicle_companies[$key]['action'] = '<a href="' . route('vehicle.show', $value->id) . '" data-toggle="tooltip" title="update" class="glyphicon glyphicon-edit"></a>&nbsp;&nbsp;<a href="' . route('vehicle.destroy', $value->id) . '" data-toggle="tooltip" title="delete" data-method="delete" class="glyphicon glyphicon-trash deleteRow"></a>';
            }
            return Datatables::of($vehicle_companies)->make(true);
        }
        return View::make('admin.vehicle_companies.index', compact('title'));
    }

    /**
     * create a new file
     *
     * @return Response
     */
    public function create() {
        $title = 'Vehicle';
        return View::make('admin.vehicle_companies.add', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request) {
        $data = $request->all();
        $this->validate($request, [
            'name' => 'required|unique:vehicle_companies|max:50'
        ]);
        VehicleCompany::create($data);
        return Redirect::back()
                        ->with('success-message', 'Record inserted successfully!');
    }

    /**
     * show function.
     *
     * @return Response
     */
    public function show(Request $request, $id) {
        $title = 'Vehicle | update';
        $vehicle_company = VehicleCompany::where('id', $id)->first(array('name','id'));
        return View::make('admin.vehicle_companies.edit', compact('title', 'vehicle_company'));
    
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
            'name' => 'required|max:50|unique:vehicle_companies,name,' . $id
        ]);
        
        $vehicle_company = VehicleCompany::findOrFail($id);
        $vehicle_company->fill($data)->save();
        return Redirect::back()
                        ->with('success-message', 'Record updated successfully!');
    
    }
//
//    /**
//     * Remove the specified resource from storage.
//     *
//     * @param  int  $id
//     * @return Response
//     */
    public function destroy($id) {
        $vehicle_company = VehicleCompany::find($id);

        if (!$vehicle_company) {
            Session::flash('error-message', 'Something went wrong .Please try again later!');
        } else {
            $vehicle_company->delete();
            Session::flash('success-message', 'Record deleted successfully !');
        }
        return 'true';
    }
}
