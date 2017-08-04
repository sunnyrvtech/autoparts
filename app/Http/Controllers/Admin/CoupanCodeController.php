<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\CoupanCode;
use View;
use Redirect;
use Session;
use Yajra\Datatables\Facades\Datatables;

class CoupanCodeController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request) {
        $title = 'Copon Code';
        if ($request->ajax()) {
            $coupan_codes = CoupanCode::get();
            foreach ($coupan_codes as $key => $value) {
                $coupan_codes[$key]['action'] = '<a href="' . route('coupon_code.show', $value->id) . '" data-toggle="tooltip" title="update" class="glyphicon glyphicon-edit"></a><a href="' . route('coupon_code.destroy', $value->id) . '" data-toggle="tooltip" title="delete" data-method="delete" class="glyphicon glyphicon-trash deleteRow"></a>';
            }
            return Datatables::of($coupan_codes)->make(true);
        }
        return View::make('admin.coupan_codes.index', compact('title'));
    }

    /**
     * create a new file
     *
     * @return Response
     */
    public function create() {
        $title = 'Coupon Code | create';
        return View::make('admin.coupan_codes.add', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request) {
        $data = $request->all();
        $this->validate($request, [
            'coupan_type' => 'required',
            'code' => 'required',
            'usage' => 'required',
            'expiration_date' => 'required',
            'status' => 'required',
        ]);


        CoupanCode::create($data);
        return redirect()->route('coupon_code.index')
                        ->with('success-message', 'Coupan Code created successfully!');
    }

    /**
     * show function.
     *
     * @return Response
     */
    public function show(Request $request, $id) {
        $title = 'Coupon Code | update';
        $coupan_codes = CoupanCode::where('id', $id)->first();
        return View::make('admin.coupan_codes.edit', compact('title', 'coupan_codes'));
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
            'coupan_type' => 'required',
            'code' => 'required',
            'usage' => 'required',
            'expiration_date' => 'required',
            'status' => 'required',
        ]);
        $coupan_codes = CoupanCode::findOrFail($id);
        //CoupanCode::Where('id','>',1)->update(['status' => 0]);
        $coupan_codes->fill($data)->save();

        return redirect()->route('coupon_code.index')
                        ->with('success-message', 'Coupan Code updated successfully!');
    }

    //    /**
//     * Remove the specified resource from storage.
//     *
//     * @param  int  $id
//     * @return Response
//     */
    public function destroy($id) {
        $coupan_codes = CoupanCode::find($id);

        if (!$coupan_codes) {
            Session::flash('error-message', 'Something went wrong .Please try again later!');
        } else {
            $coupan_codes->delete();
            Session::flash('success-message', 'Deleted successfully !');
        }
        return 'true';
    }

}
