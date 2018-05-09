<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use View;
use Redirect;
use App\VehicleModel;
use Session;
use Yajra\Datatables\Facades\Datatables;

class VehicleModelController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request) {
        $title = 'Vehicle Model';
        
        if ($request->ajax()) {
            $vehicle_models = VehicleModel::get();
            foreach ($vehicle_models as $key => $value) {
                $vehicle_models[$key]['action'] = '<a href="' . route('vehicle_model.show', $value->id) . '" data-toggle="tooltip" title="update" class="glyphicon glyphicon-edit"></a>&nbsp;&nbsp;<a href="' . route('vehicle_model.destroy', $value->id) . '" data-toggle="tooltip" title="delete" data-method="delete" class="glyphicon glyphicon-trash deleteRow"></a>';
            }
            return Datatables::of($vehicle_models)->make(true);
        }
        return View::make('admin.vehicle_models.index', compact('title'));
    }

    /**
     * create a new file
     *
     * @return Response
     */
    public function create() {
        $title = 'Vehicle';
        return View::make('admin.vehicle_models.add', compact('title'));
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
        $data['slug'] = $this->createSlug($data['name']);
        VehicleModel::create($data);
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
        $vehicle_model = VehicleModel::where('id', $id)->first(array('name', 'id'));
        return View::make('admin.vehicle_models.edit', compact('title', 'vehicle_model'));
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
            'name' => 'required|max:50|unique:vehicle_models,name,' . $id
        ]);

        $vehicle_model = VehicleModel::findOrFail($id);
        $vehicle_model->fill($data)->save();
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
        $vehicle_model = VehicleModel::find($id);

        if (!$vehicle_model) {
            Session::flash('error-message', 'Something went wrong .Please try again later!');
        } else {
            $vehicle_model->delete();
            Session::flash('success-message', 'Record deleted successfully !');
        }
        return 'true';
    }
    
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
        return VehicleModel::select('slug')->where('slug', 'like', $slug . '%')
                        ->get();
    }

}
