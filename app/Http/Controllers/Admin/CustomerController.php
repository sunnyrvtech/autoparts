<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use View;
use App\User;
use Redirect;
use Yajra\Datatables\Facades\Datatables;

class CustomerController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request) {
        $title = 'Customers';
        if ($request->ajax()) {
            $users = User::get();
            foreach ($users as $key => $value) {
                $users[$key]['action'] = '<a href="' . route('customers.show', $value->id) . '" data-toggle="tooltip" title="View Sub Category" class="glyphicon glyphicon-edit"></a>';
            }
            return Datatables::of($users)->make(true);
        }
        return View::make('admin.customers.index', compact('title'));
    }

    /**
     * create a new file
     *
     * @return Response
     */
    public function create() {
        $title = 'Customers | create';
        return View::make('admin.customers.add', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request) {
        $data = $request->all();
        $this->validate($request, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6',
            'status' => 'required',
        ]);

        $data['password'] = bcrypt($data['password']);

        User::create($data);
        return Redirect::back()
                        ->with('success-message', 'Customer created successfully!');
    }

    /**
     * show function.
     *
     * @return Response
     */
    public function show(Request $request, $id) {
        $title = 'Customers | update';
        $users = User::where('id', $id)->first();
        return View::make('admin.customers.edit', compact('title', 'users'));
    }

//
//    /**
//     * Update the specified resource in storage.
//     *
//     * @param  int  $id
//     * @return Response
//     */
    public function update(Request $request, $id) {
        $title = 'Customers | update';
        $data = $request->all();
        $this->validate($request, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$id,
            'status' => 'required',
        ]);
        $users = User::findOrFail($id);
        $users->fill($data)->save();

        return Redirect::back()
                        ->with('success-message', 'Customer updated successfully!');
    }

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
