@extends('admin/layouts.master')
@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    {{ Form::open(array('route' => 'products.store', 'class' => 'form','enctype'=>'multipart/form-data')) }}
    <div class="row">
        <div class="page-header-section">
            <div class="col-lg-9">
                <h3>
                    Add New Product
                </h3>
            </div>
            <div class="col-lg-3">
                <h3><button type="submit" class="btn btn-primary pull-right">Save</button></h3>
            </div>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-3"> <!-- required for floating -->
            <!-- Nav tabs -->
            <ul class="nav nav-tabs tabs-left">
                <li class="active"><a href="#general" data-toggle="tab">General</a></li>
                <li class=""><a href="#auto_parts1" data-toggle="tab">Auto parts form1</a></li>
                <li class=""><a href="#auto_parts2" data-toggle="tab">Auto parts form2</a></li>
                <li class=""><a href="#auto_parts3" data-toggle="tab">Auto parts form3</a></li>
                <li class=""><a href="#meta_information" data-toggle="tab">Meta Information</a></li>
                <li class=""><a href="#images" data-toggle="tab">Images</a></li>
                <li class=""><a href="#categories" data-toggle="tab">Categories</a></li>
            </ul>
        </div>
        <div class="col-lg-9">
            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane active" id="general">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('product_name') ? ' has-error' : '' }}">
                                <label class="control-label">Product Name<span class="comps">*</span></label>
                                {{ Form::text('product_name', null,array('required', 'class'=>'form-control')) }}
                                @if ($errors->has('product_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('product_name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('price') ? ' has-error' : '' }}">
                                <label class="control-label">Product Price<span class="comps">*</span></label>
                                {{ Form::text('price', null,array('required', 'class'=>'form-control')) }}
                                @if ($errors->has('price'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('price') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group {{ $errors->has('product_long_description') ? ' has-error' : '' }}">
                                <label class="control-label">Product Long Description<span class="comps">*</span></label>
                                {{ Form::textarea('product_long_description', null,array('required', 'class'=>'form-control')) }}
                                @if ($errors->has('product_long_description'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('product_long_description') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group {{ $errors->has('product_short_description') ? ' has-error' : '' }}">
                                <label class="control-label">Product Short Description</label>
                                {{ Form::textarea('product_short_description', null,array('class'=>'form-control')) }}
                                @if ($errors->has('product_short_description'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('product_short_description') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group {{ $errors->has('vehicle_fit') ? ' has-error' : '' }}">
                                <label class="control-label">Vehicle Fit</label>
                                {{ Form::textarea('vehicle_fit', null,array('class'=>'form-control')) }}
                                @if ($errors->has('vehicle_fit'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('vehicle_fit') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('sku') ? ' has-error' : '' }}">
                                <label class="control-label">Sku<span class="comps">*</span></label>
                                {{ Form::text('sku', null,array('required', 'class'=>'form-control')) }}
                                @if ($errors->has('sku'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('sku') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('quantity') ? ' has-error' : '' }}">
                                <label class="control-label">Quantity<span class="comps">*</span></label>
                                {{ Form::text('quantity', null,array('required', 'class'=>'form-control')) }}
                                @if ($errors->has('quantity'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('quantity') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('weight') ? ' has-error' : '' }}">
                                <label class="control-label">Weight</label>
                                {{ Form::text('weight', null,array('class'=>'form-control')) }}
                                @if ($errors->has('weight'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('weight') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('length') ? ' has-error' : '' }}">
                                <label class="control-label">Product Length</label>
                                {{ Form::text('length', null,array('class'=>'form-control')) }}
                                @if ($errors->has('length'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('length') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('width') ? ' has-error' : '' }}">
                                <label class="control-label">Product Width</label>
                                {{ Form::text('width', null,array('class'=>'form-control')) }}
                                @if ($errors->has('width'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('width') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('height') ? ' has-error' : '' }}">
                                <label class="control-label">Product Height</label>
                                {{ Form::text('height', null,array('class'=>'form-control')) }}
                                @if ($errors->has('height'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('height') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('status') ? ' has-error' : '' }}">
                                <label class="control-label">Status</label>
                                {{ Form::select('status', ['1' => 'Enabled','0'=>'Disabled'], null, ['required','class' => 'form-control']) }}
                                @if ($errors->has('quantity'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('quantity') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('discount') ? ' has-error' : '' }}">
                                <label class="control-label">Discount</label>
                                {{ Form::text('discount', null,array('class'=>'form-control')) }}
                                @if ($errors->has('discount'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('discount') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="auto_parts1">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('vehicle_year_from') ? ' has-error' : '' }}">
                                <label class="control-label">Vehicle Year From</label>
                                {{ Form::text('vehicle_year_from', null,array('class'=>'form-control datepicker')) }}
                                @if ($errors->has('vehicle_year_from'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('vehicle_year_from') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('vehicle_year_to') ? ' has-error' : '' }}">
                                <label class="control-label">Vehicle Year To</label>
                                {{ Form::text('vehicle_year_to', null,array('class'=>'form-control datepicker')) }}
                                @if ($errors->has('vehicle_year_to'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('vehicle_year_to') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('vehicle_make_id') ? ' has-error' : '' }}">
                                <label class="control-label">Vehicle Make</label>
                                {{ Form::select('vehicle_make_id', $vehicle_company, null, ['class' => 'form-control']) }}
                                @if ($errors->has('vehicle_make_id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('vehicle_make_id') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('vehicle_model_id') ? ' has-error' : '' }}">
                                <label class="control-label">Vehicle Model</label>
                                {{ Form::select('vehicle_model_id', $vehicle_model, null, ['class' => 'form-control']) }}
                                @if ($errors->has('vehicle_model_id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('vehicle_model_id') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('brand_id') ? ' has-error' : '' }}">
                                <label class="control-label">Brand</label>
                                {{ Form::select('brand_id', $brands, null, ['class' => 'form-control']) }}
                                @if ($errors->has('brand_id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('brand_id') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('part_type') ? ' has-error' : '' }}">
                                <label class="control-label">Part Type</label>
                                {{ Form::text('part_type', null,array('class'=>'form-control')) }}
                                @if ($errors->has('part_type'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('part_type') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('operation') ? ' has-error' : '' }}">
                                <label class="control-label">Operation</label>
                                {{ Form::text('operation', null,array('class'=>'form-control')) }}
                                @if ($errors->has('operation'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('operation') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('wattage') ? ' has-error' : '' }}">
                                <label class="control-label">Wattage</label>
                                {{ Form::text('wattage', null,array('class'=>'form-control')) }}
                                @if ($errors->has('wattage'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('wattage') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('mirror_option') ? ' has-error' : '' }}">
                                <label class="control-label">Mirror Option</label>
                                {{ Form::text('mirror_option', null,array('class'=>'form-control')) }}
                                @if ($errors->has('mirror_option'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('mirror_option') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('location') ? ' has-error' : '' }}">
                                <label class="control-label">Location</label>
                                {{ Form::text('location', null,array('class'=>'form-control')) }}
                                @if ($errors->has('location'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('location') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('size') ? ' has-error' : '' }}">
                                <label class="control-label">Size</label>
                                {{ Form::text('size', null,array('class'=>'form-control')) }}
                                @if ($errors->has('size'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('size') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('material') ? ' has-error' : '' }}">
                                <label class="control-label">Material</label>
                                {{ Form::text('material', null,array('class'=>'form-control')) }}
                                @if ($errors->has('material'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('material') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
<!--                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('carpet_color') ? ' has-error' : '' }}">
                                <label class="control-label">Carpet Color</label>
                                {{ Form::text('carpet_color', null,array('class'=>'form-control')) }}
                                @if ($errors->has('carpet_color'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('carpet_color') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>-->
<!--                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('light_option') ? ' has-error' : '' }}">
                                <label class="control-label">Light Option</label>
                                {{ Form::text('light_option', null,array('class'=>'form-control')) }}
                                @if ($errors->has('light_option'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('light_option') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>-->
<!--                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('fuel_tank_option') ? ' has-error' : '' }}">
                                <label class="control-label">Fuel Tank Option</label>
                                {{ Form::text('fuel_tank_option', null,array('class'=>'form-control')) }}
                                @if ($errors->has('fuel_tank_option'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('fuel_tank_option') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>-->
                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('color') ? ' has-error' : '' }}">
                                <label class="control-label">Color</label>
                                {{ Form::text('color', null,array('class'=>'form-control')) }}
                                @if ($errors->has('color'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('color') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
<!--                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('hood_type') ? ' has-error' : '' }}">
                                <label class="control-label">Hood Type</label>
                                {{ Form::text('hood_type', null,array('class'=>'form-control')) }}
                                @if ($errors->has('hood_type'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('hood_type') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>-->
                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('front_location') ? ' has-error' : '' }}">
                                <label class="control-label">Front Location</label>
                                {{ Form::text('front_location', null,array('class'=>'form-control')) }}
                                @if ($errors->has('front_location'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('front_location') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('side_location') ? ' has-error' : '' }}">
                                <label class="control-label">Side Location</label>
                                {{ Form::text('side_location', null,array('class'=>'form-control')) }}
                                @if ($errors->has('side_location'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('side_location') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
<!--                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('tube_size') ? ' has-error' : '' }}">
                                <label class="control-label">Tube Size</label>
                                {{ Form::text('tube_size', null,array('class'=>'form-control')) }}
                                @if ($errors->has('tube_size'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('tube_size') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>-->
<!--                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('wheel_option') ? ' has-error' : '' }}">
                                <label class="control-label">Wheel Option</label>
                                {{ Form::text('wheel_option',null,array('class'=>'form-control')) }}
                                @if ($errors->has('wheel_option'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('wheel_option') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>-->
                    </div>
                </div>
                <div class="tab-pane" id="auto_parts2">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('includes') ? ' has-error' : '' }}">
                                <label class="control-label">Includes</label>
                                {{ Form::text('includes', null,array('class'=>'form-control')) }}
                                @if ($errors->has('includes'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('includes') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('design') ? ' has-error' : '' }}">
                                <label class="control-label">Design</label>
                                {{ Form::text('design', null,array('class'=>'form-control')) }}
                                @if ($errors->has('design'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('design') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('product_line') ? ' has-error' : '' }}">
                                <label class="control-label">Product Line</label>
                                {{ Form::text('product_line', null,array('class'=>'form-control')) }}
                                @if ($errors->has('product_line'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('product_line') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('text') ? ' has-error' : '' }}">
                                <label class="control-label">Text</label>
                                {{ Form::text('text', null,array('class'=>'form-control')) }}
                                @if ($errors->has('text'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('text') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('sale_type') ? ' has-error' : '' }}">
                                <label class="control-label">Sale Type</label>
                                {{ Form::text('sale_type', null,array('class'=>'form-control')) }}
                                @if ($errors->has('sale_type'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('sale_type') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('m_code') ? ' has-error' : '' }}">
                                <label class="control-label">M Code</label>
                                {{ Form::text('m_code', null,array('class'=>'form-control')) }}
                                @if ($errors->has('m_code'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('m_code') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('class') ? ' has-error' : '' }}">
                                <label class="control-label">Class</label>
                                {{ Form::text('class', null,array('class'=>'form-control')) }}
                                @if ($errors->has('class'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('class') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('parse_link') ? ' has-error' : '' }}">
                                <label class="control-label">Parse Link</label>
                                {{ Form::text('parse_link', null,array('class'=>'form-control')) }}
                                @if ($errors->has('parse_link'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('parse_link') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('certification') ? ' has-error' : '' }}">
                                <label class="control-label">Certification</label>
                                {{ Form::text('certification', null,array('class'=>'form-control')) }}
                                @if ($errors->has('certification'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('certification') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('warranty') ? ' has-error' : '' }}">
                                <label class="control-label">Warranty</label>
                                {{ Form::text('warranty', null,array('class'=>'form-control')) }}
                                @if ($errors->has('warranty'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('warranty') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
<!--                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('paint_code') ? ' has-error' : '' }}">
                                <label class="control-label">Paint Code</label>
                                {{ Form::text('paint_code', null,array('class'=>'form-control')) }}
                                @if ($errors->has('paint_code'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('paint_code') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>-->
<!--                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('paint_applicator') ? ' has-error' : '' }}">
                                <label class="control-label">Paint Applicator</label>
                                {{ Form::text('paint_applicator', null,array('class'=>'form-control')) }}
                                @if ($errors->has('paint_applicator'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('paint_applicator') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>-->
<!--                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('brake_pad') ? ' has-error' : '' }}">
                                <label class="control-label">Brake Pad</label>
                                {{ Form::text('brake_pad', null,array('class'=>'form-control')) }}
                                @if ($errors->has('brake_pad'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('brake_pad') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>-->
<!--                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('tonneau_cover_type') ? ' has-error' : '' }}">
                                <label class="control-label">Tonneau Cover Type</label>
                                {{ Form::text('tonneau_cover_type', null,array('class'=>'form-control')) }}
                                @if ($errors->has('tonneau_cover_type'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('tonneau_cover_type') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>-->
<!--                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('shaft_size') ? ' has-error' : '' }}">
                                <label class="control-label">Shaft Size</label>
                                {{ Form::text('shaft_size', null,array('class'=>'form-control')) }}
                                @if ($errors->has('shaft_size'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('shaft_size') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>-->
                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('licensed_by') ? ' has-error' : '' }}">
                                <label class="control-label">Licensed By</label>
                                {{ Form::text('licensed_by', null,array('class'=>'form-control')) }}
                                @if ($errors->has('licensed_by'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('licensed_by') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('car_cover') ? ' has-error' : '' }}">
                                <label class="control-label">Car Cover</label>
                                {{ Form::text('car_cover', null,array('class'=>'form-control')) }}
                                @if ($errors->has('car_cover'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('car_cover') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
<!--                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('tow_ball_diameter') ? ' has-error' : '' }}">
                                <label class="control-label">Tow Ball Diameter</label>
                                {{ Form::text('tow_ball_diameter', null,array('class'=>'form-control')) }}
                                @if ($errors->has('tow_ball_diameter'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('tow_ball_diameter') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>-->
<!--                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('trailer_hitch_class') ? ' has-error' : '' }}">
                                <label class="control-label">Trailer Hitch Class</label>
                                {{ Form::text('trailer_hitch_class', null,array('class'=>'form-control')) }}
                                @if ($errors->has('trailer_hitch_class'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('trailer_hitch_class') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>-->
                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('kit_includes') ? ' has-error' : '' }}">
                                <label class="control-label">Kit Includes</label>
                                {{ Form::text('kit_includes', null,array('class'=>'form-control')) }}
                                @if ($errors->has('kit_includes'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('kit_includes') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
<!--                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('trunk_mat_color') ? ' has-error' : '' }}">
                                <label class="control-label">Trunk Mat Color</label>
                                {{ Form::text('trunk_mat_color', null,array('class'=>'form-control')) }}
                                @if ($errors->has('trunk_mat_color'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('trunk_mat_color') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>-->
                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('fender_flare_type') ? ' has-error' : '' }}">
                                <label class="control-label">Fender Flare Type</label>
                                {{ Form::text('fender_flare_type', null,array('class'=>'form-control')) }}
                                @if ($errors->has('fender_flare_type'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('fender_flare_type') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('product_grade') ? ' has-error' : '' }}">
                                <label class="control-label">Product Grade</label>
                                {{ Form::text('product_grade', null,array('class'=>'form-control')) }}
                                @if ($errors->has('product_grade'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('product_grade') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
<!--                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('lighting_wattage_rating') ? ' has-error' : '' }}">
                                <label class="control-label">Lighting Wattage Rating</label>
                                {{ Form::text('lighting_wattage_rating', null,array('class'=>'form-control')) }}
                                @if ($errors->has('lighting_wattage_rating'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('lighting_wattage_rating') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>-->
                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('lighting_size') ? ' has-error' : '' }}">
                                <label class="control-label">Lighting Size</label>
                                {{ Form::text('lighting_size', null,array('class'=>'form-control')) }}
                                @if ($errors->has('lighting_size'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('lighting_size') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('lighting_beam_pattern') ? ' has-error' : '' }}">
                                <label class="control-label">Lighting Beam Pattern</label>
                                {{ Form::text('lighting_beam_pattern', null,array('class'=>'form-control')) }}
                                @if ($errors->has('lighting_beam_pattern'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('lighting_beam_pattern') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="auto_parts3">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('lighting_lens_material') ? ' has-error' : '' }}">
                                <label class="control-label">Lighting Lens Material</label>
                                {{ Form::text('lighting_lens_material', null,array('class'=>'form-control')) }}
                                @if ($errors->has('lighting_lens_material'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('lighting_lens_material') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('lighting_mount_type') ? ' has-error' : '' }}">
                                <label class="control-label">Lighting Mount Type</label>
                                {{ Form::text('lighting_mount_type', null,array('class'=>'form-control')) }}
                                @if ($errors->has('lighting_mount_type'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('lighting_mount_type') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
<!--                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('lighting_bulb_count') ? ' has-error' : '' }}">
                                <label class="control-label">Lighting Bulb Count</label>
                                {{ Form::text('lighting_bulb_count', null,array('class'=>'form-control')) }}
                                @if ($errors->has('lighting_bulb_count'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('lighting_bulb_count') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>-->
<!--                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('lighting_usage') ? ' has-error' : '' }}">
                                <label class="control-label">Lighting Usage</label>
                                {{ Form::text('lighting_usage', null,array('class'=>'form-control')) }}
                                @if ($errors->has('lighting_usage'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('lighting_usage') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>-->
<!--                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('lighting_bulb_brand') ? ' has-error' : '' }}">
                                <label class="control-label">Lighting Bulb Brand</label>
                                {{ Form::text('lighting_bulb_brand', null,array('class'=>'form-control')) }}
                                @if ($errors->has('lighting_bulb_brand'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('lighting_bulb_brand') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>-->
                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('lighting_bulb_configuration') ? ' has-error' : '' }}">
                                <label class="control-label">Lighting Bulb Configuration</label>
                                {{ Form::text('lighting_bulb_configuration', null,array('class'=>'form-control')) }}
                                @if ($errors->has('lighting_bulb_configuration'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('lighting_bulb_configuration') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('lighting_housing_shape') ? ' has-error' : '' }}">
                                <label class="control-label">Lighting Housing Shape</label>
                                {{ Form::text('lighting_housing_shape', null,array('class'=>'form-control')) }}
                                @if ($errors->has('lighting_housing_shape'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('lighting_housing_shape') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('bracket_style') ? ' has-error' : '' }}">
                                <label class="control-label">Bracket Style</label>
                                {{ Form::text('bracket_style', null,array('class'=>'form-control')) }}
                                @if ($errors->has('bracket_style'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('bracket_style') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('cooling_fan_type') ? ' has-error' : '' }}">
                                <label class="control-label">Cooling Fan Type</label>
                                {{ Form::text('cooling_fan_type', null,array('class'=>'form-control')) }}
                                @if ($errors->has('cooling_fan_type'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('cooling_fan_type') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('radiator_row_count') ? ' has-error' : '' }}">
                                <label class="control-label">Radiator Row Count</label>
                                {{ Form::text('radiator_row_count', null,array('class'=>'form-control')) }}
                                @if ($errors->has('radiator_row_count'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('radiator_row_count') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('oil_plan_capacity') ? ' has-error' : '' }}">
                                <label class="control-label">Oil Plan Capacity</label>
                                {{ Form::text('oil_plan_capacity', null,array('class'=>'form-control')) }}
                                @if ($errors->has('oil_plan_capacity'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('oil_plan_capacity') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
<!--                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('intake_type') ? ' has-error' : '' }}">
                                <label class="control-label">Intake Type</label>
                                {{ Form::text('intake_type', null,array('class'=>'form-control')) }}
                                @if ($errors->has('intake_type'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('intake_type') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>-->
<!--                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('regulator_option') ? ' has-error' : '' }}">
                                <label class="control-label">Regulator Option</label>
                                {{ Form::text('regulator_option', null,array('class'=>'form-control')) }}
                                @if ($errors->has('regulator_option'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('regulator_option') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>-->
<!--                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('manufacturing_process') ? ' has-error' : '' }}">
                                <label class="control-label">Manufacturing Process</label>
                                {{ Form::text('manufacturing_process', null,array('class'=>'form-control')) }}
                                @if ($errors->has('manufacturing_process'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('manufacturing_process') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>-->
<!--                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('brake_rotor_type') ? ' has-error' : '' }}">
                                <label class="control-label">Brake Rotor Type</label>
                                {{ Form::text('brake_rotor_type', null,array('class'=>'form-control')) }}
                                @if ($errors->has('brake_rotor_type'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('brake_rotor_type') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>-->
<!--                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('thread_type') ? ' has-error' : '' }}">
                                <label class="control-label">Thread Type</label>
                                {{ Form::text('thread_type', null,array('class'=>'form-control')) }}
                                @if ($errors->has('thread_type'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('thread_type') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>-->
<!--                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('spark_plug_type') ? ' has-error' : '' }}">
                                <label class="control-label">Spark Plug Type</label>
                                {{ Form::text('spark_plug_type', null,array('class'=>'form-control')) }}
                                @if ($errors->has('spark_plug_type'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('spark_plug_type') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>-->
                    </div>
                </div>
                <div class="tab-pane" id="meta_information">
                    <div class="row">
                        <div class="form-group {{ $errors->has('meta_title') ? ' has-error' : '' }}">
                            <label class="control-label">Meta Title</label>
                            {{ Form::text('meta_title', null,array('class'=>'form-control')) }}
                            @if ($errors->has('meta_title'))
                            <span class="help-block">
                                <strong>{{ $errors->first('meta_title') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('meta_description') ? ' has-error' : '' }}">
                            <label class="control-label">Meta Description</label>
                            {{ Form::text('meta_description', null,array('class'=>'form-control')) }}
                            @if ($errors->has('meta_description'))
                            <span class="help-block">
                                <strong>{{ $errors->first('meta_description') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('meta_keyword') ? ' has-error' : '' }}">
                            <label class="control-label">Meta Keyword</label>
                            {{ Form::text('meta_keyword', null,array('class'=>'form-control')) }}
                            @if ($errors->has('meta_keyword'))
                            <span class="help-block">
                                <strong>{{ $errors->first('meta_keyword') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="images">
                    <h3>Product Images:-</h3>
                    <div class="row form-group">
                        <div class="form-group">
                            <input type="file" name="product_images[]" id="file_type" multiple style="visibility: hidden;" class="file">
                            <div class="text-right">
                                <button class="browse btn btn-primary input-lg" type="button"><i class="glyphicon glyphicon-search"></i> Browse</button>
                                <a class="btn btn-xs btn-warning">
                                    <span class="glyphicon glyphicon-trash removePreviewImage"></span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="list-group">
                            <div class="list-group-item renderPreviewImage clearfix">

                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane" id="categories">
                    <h3>Categories:-</h3>
                    <ul class="parent_category" style="list-style: none;">
                        @foreach ($categories as $cat)
                        <li><input type="checkbox" name="parent_category[]" value="{{ $cat->id }}">{{ $cat->name }}
                            @if(!empty($cat->sub_categories->toArray()))
                            <a href="javascript:void(0);" class="toggleCategory"><span style="font-size: 20px;color: #000;font-weight: bold;" class="fa fa-angle-down"></span></a>
                            <ul class="sub_category" style="list-style: none;display: none;">
                                @foreach ($cat->sub_categories as $sub_cat)
                                <li><input type="checkbox" name="sub_category[]" value="{{ $sub_cat->id }}">{{ $sub_cat->name }}
                                    {{--
                                    @if(!empty($sub_cat->sub_sub_categories->toArray()))
                                    <a href="javascript:void(0);" class="toggleCategory"><span style="font-size: 20px;color: #000;font-weight: bold;" class="fa fa-angle-down"></span></a>
                                    <ul class="sub_sub_category" style="list-style: none;display: none;">
                                        @foreach ($sub_cat->sub_sub_categories as $sub_sub_cat)
                                        <li><input type="checkbox" name="sub_sub_category[]" value="{{ $sub_sub_cat->id }}">{{ $sub_cat->name.' '.$sub_sub_cat->get_vehicle_company_name->name }}</li>
                                        @endforeach
                                    </ul>
                                    @endif
                                    --}}
                                </li>
                                @endforeach
                            </ul>
                            @endif
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <!-- /.row -->
    {!! Form::close() !!}
</div>
<!-- /.container-fluid -->
@endsection
@push('scripts')

@endpush