<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\TaxRate;
use App\Country;
use App\State;
use View;
use Redirect;
use Session;
use Yajra\Datatables\Facades\Datatables;

class TaxRateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request) {
        $title = 'Tax Rates';
        if ($request->ajax()) {
            $tax_rates = TaxRate::get();
            foreach ($tax_rates as $key => $value) {
                $state_ids = json_decode($value->state_id);
                $state_name = State::WhereIn('id',$state_ids)->pluck('name')->toArray();
                $country_name = Country::Where('id',$value->country_id)->pluck('name')->toArray();
                $tax_rates[$key]['action'] = '<a href="' . route('tax_rates.show', $value->id) . '" data-toggle="tooltip" title="update" class="glyphicon glyphicon-edit"></a>&nbsp;&nbsp;<a href="' . route('tax_rates.destroy', $value->id) . '" data-toggle="tooltip" title="delete" data-method="delete" class="glyphicon glyphicon-trash deleteRow"></a>';
                $tax_rates[$key]['country_name'] = implode(', ',$country_name);
                $tax_rates[$key]['state_name'] = implode(', ',$state_name);
            }
            return Datatables::of($tax_rates)->make(true);
        }
        return View::make('admin.tax_rates.index', compact('title'));
    }

    /**
     * create a new file
     *
     * @return Response
     */
    public function create() {
        $title = 'Tax Rate | create';
        $states = State::Where('country_id', 231)->whereNotNull('postal_code')->get();
        
        $countries = Country::get();
        return View::make('admin.tax_rates.add', compact('title', 'countries','states'));
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
            'states' => 'required',
            'price' => 'required'
        ]);

        $data['state_id'] = json_encode($data['states']);

        TaxRate::create($data);
        return redirect()->route('tax_rates.index')
                        ->with('success-message', 'Added successfully!');
    }
    
    /**
     * show function.
     *
     * @return Response
     */
    public function show(Request $request, $id) {
        $title = 'Tax Rate | update';
        $tax_rates = TaxRate::where('id', $id)->first();
        $countries = Country::get();
        $states = State::Where('country_id', $tax_rates->country_id)->get();
        return View::make('admin.tax_rates.edit', compact('title', 'tax_rates','states','countries'));
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
            'states' => 'required',
            'price' => 'required'
        ]);

        $data['state_id'] = json_encode($data['states']);

        $tax_rates = TaxRate::findOrFail($id);
        $tax_rates->fill($data)->save();

        return redirect()->route('tax_rates.index')
                        ->with('success-message', 'Updated successfully!');
    }
    
     //    /**
//     * Remove the specified resource from storage.
//     *
//     * @param  int  $id
//     * @return Response
//     */
    public function destroy($id) {
        $tax_rates = TaxRate::find($id);

        if (!$tax_rates) {
            Session::flash('error-message', 'Something went wrong .Please try again later!');
        } else {
            $tax_rates->delete();
            Session::flash('success-message', 'Deleted successfully !');
        }
        return 'true';
    }
}
