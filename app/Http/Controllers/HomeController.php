<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;

class HomeController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $view = View::make('index');
        $sections = $view->renderSections();
        return $sections['content'];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
//    public function store() {
//        
//    }
//
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
