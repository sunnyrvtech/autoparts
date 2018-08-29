@extends('admin/layouts.master')
@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    {{ Form::open(array('route' => ['products.update',$products->id],'method'=>'PUT' ,'class' => 'form','enctype'=>'multipart/form-data')) }}
    <div class="row">
        <div class="page-header-section">
            <div class="col-lg-9">
                <h3>
                    Update Product
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
                        <div class="col-lg-12">
                            <div class="form-group {{ $errors->has('product_name') ? ' has-error' : '' }}">
                                <label class="control-label">Product Name<span class="comps">*</span></label>
                                {{ Form::text('product_name',  $products->product_name,array('required', 'class'=>'form-control')) }}
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
                                {{ Form::text('price',$products->price,array('required', 'class'=>'form-control')) }}
                                @if ($errors->has('price'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('price') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('special_price') ? ' has-error' : '' }}">
                                <label class="control-label">Special Price<span class="comps"></span></label>
                                {{ Form::text('special_price', $products->special_price,array('class'=>'form-control')) }}
                                @if ($errors->has('special_price'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('special_price') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group {{ $errors->has('product_long_description') ? ' has-error' : '' }}">
                                <label class="control-label">Product Long Description<span class="comps">*</span></label>
                                {{ Form::textarea('product_long_description', $products->product_long_description,array('class'=>'form-control textarea')) }}
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
                                {{ Form::textarea('product_short_description', $products->product_short_description,array('class'=>'form-control textarea')) }}
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
                                {{ Form::textarea('vehicle_fit', $products->vehicle_fit,array('class'=>'form-control textarea')) }}
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
                                {{ Form::text('sku', $products->sku,array('required', 'class'=>'form-control')) }}
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
                                {{ Form::text('quantity', $products->quantity,array('required', 'class'=>'form-control')) }}
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
                                {{ Form::text('weight', $products->weight,array('class'=>'form-control')) }}
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
                                {{ Form::text('length', $products->length,array('class'=>'form-control')) }}
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
                                {{ Form::text('width', $products->width,array('class'=>'form-control')) }}
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
                                {{ Form::text('height', $products->height,array('class'=>'form-control')) }}
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
                                {{ Form::select('status', ['1' => 'Enabled','0'=>'Disabled'], $products->status, ['required','class' => 'form-control']) }}
                                @if ($errors->has('status'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('status') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('discount') ? ' has-error' : '' }}">
                                <label class="control-label">Discount</label>
                                {{ Form::text('discount', number_format($products->discount),array('class'=>'form-control')) }}
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
                                {{ Form::text('vehicle_year_from', $products->vehicle_year_from,array('class'=>'form-control datepicker')) }}
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
                                {{ Form::text('vehicle_year_to', $products->vehicle_year_to,array('class'=>'form-control datepicker')) }}
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
                                {{ Form::select('vehicle_make_id', $vehicle_company, $products->vehicle_make_id, ['class' => 'form-control']) }}
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
                                {{ Form::select('vehicle_model_id',$vehicle_model, $products->vehicle_model_id, ['class' => 'form-control']) }}
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
                                {{ Form::select('brand_id', $brands, $products->brand_id, ['class' => 'form-control']) }}
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
                                {{ Form::text('part_type', $products->part_type,array('class'=>'form-control')) }}
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
                                {{ Form::text('operation', $products->operation,array('class'=>'form-control')) }}
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
                                {{ Form::text('wattage', $products->wattage,array('class'=>'form-control')) }}
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
                                {{ Form::text('mirror_option', $products->mirror_option,array('class'=>'form-control')) }}
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
                                {{ Form::text('location', $products->location,array('class'=>'form-control')) }}
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
                                {{ Form::text('size', $products->size,array('class'=>'form-control')) }}
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
                                {{ Form::text('material', $products->material,array('class'=>'form-control')) }}
                                @if ($errors->has('material'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('material') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('color') ? ' has-error' : '' }}">
                                <label class="control-label">Color</label>
                                {{ Form::text('color', $products->color,array('class'=>'form-control')) }}
                                @if ($errors->has('color'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('color') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('front_location') ? ' has-error' : '' }}">
                                <label class="control-label">Front Location</label>
                                {{ Form::text('front_location', $products->front_location,array('class'=>'form-control')) }}
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
                                {{ Form::text('side_location', $products->side_location,array('class'=>'form-control')) }}
                                @if ($errors->has('side_location'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('side_location') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="auto_parts2">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('includes') ? ' has-error' : '' }}">
                                <label class="control-label">Includes</label>
                                {{ Form::text('includes', $products->includes,array('class'=>'form-control')) }}
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
                                {{ Form::text('design', $products->design,array('class'=>'form-control')) }}
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
                                {{ Form::text('product_line', $products->product_line,array('class'=>'form-control')) }}
                                @if ($errors->has('product_line'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('product_line') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('software') ? ' has-error' : '' }}">
                                <label class="control-label">Software</label>
                                {{ Form::text('software', @$products->product_details->software,array('class'=>'form-control')) }}
                                @if ($errors->has('software'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('software') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('text') ? ' has-error' : '' }}">
                                <label class="control-label">Text</label>
                                {{ Form::text('text', @$products->product_details->text,array('class'=>'form-control')) }}
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
                                {{ Form::text('sale_type', @$products->product_details->sale_type,array('class'=>'form-control')) }}
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
                                {{ Form::text('m_code', @$products->product_details->m_code,array('class'=>'form-control')) }}
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
                                {{ Form::text('class', @$products->product_details->class,array('class'=>'form-control')) }}
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
                                {{ Form::text('parse_link', @$products->product_details->parse_link,array('class'=>'form-control')) }}
                                @if ($errors->has('parse_link'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('parse_link') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('oem_number') ? ' has-error' : '' }}">
                                <label class="control-label">OEM Number</label>
                                {{ Form::text('oem_number', @$products->product_details->oem_number,array('class'=>'form-control')) }}
                                @if ($errors->has('oem_number'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('oem_number') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('certification') ? ' has-error' : '' }}">
                                <label class="control-label">Certification</label>
                                {{ Form::text('certification', @$products->product_details->certification,array('class'=>'form-control')) }}
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
                                {{ Form::text('warranty', @$products->product_details->warranty,array('class'=>'form-control')) }}
                                @if ($errors->has('warranty'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('warranty') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('licensed_by') ? ' has-error' : '' }}">
                                <label class="control-label">Licensed By</label>
                                {{ Form::text('licensed_by', @$products->product_details->licensed_by,array('class'=>'form-control')) }}
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
                                {{ Form::text('car_cover', @$products->product_details->car_cover,array('class'=>'form-control')) }}
                                @if ($errors->has('car_cover'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('car_cover') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('kit_includes') ? ' has-error' : '' }}">
                                <label class="control-label">Kit Includes</label>
                                {{ Form::text('kit_includes', @$products->product_details->kit_includes,array('class'=>'form-control')) }}
                                @if ($errors->has('kit_includes'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('kit_includes') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('fender_flare_type') ? ' has-error' : '' }}">
                                <label class="control-label">Fender Flare Type</label>
                                {{ Form::text('fender_flare_type', @$products->product_details->fender_flare_type,array('class'=>'form-control')) }}
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
                                {{ Form::text('product_grade', @$products->product_details->product_grade,array('class'=>'form-control')) }}
                                @if ($errors->has('product_grade'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('product_grade') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('lighting_size') ? ' has-error' : '' }}">
                                <label class="control-label">Lighting Size</label>
                                {{ Form::text('lighting_size', @$products->product_details->lighting_size,array('class'=>'form-control')) }}
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
                                {{ Form::text('lighting_beam_pattern', @$products->product_details->lighting_beam_pattern,array('class'=>'form-control')) }}
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
                                {{ Form::text('lighting_lens_material', @$products->product_details->lighting_lens_material,array('class'=>'form-control')) }}
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
                                {{ Form::text('lighting_mount_type', @$products->product_details->lighting_mount_type,array('class'=>'form-control')) }}
                                @if ($errors->has('lighting_mount_type'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('lighting_mount_type') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group {{ $errors->has('lighting_bulb_configuration') ? ' has-error' : '' }}">
                                <label class="control-label">Lighting Bulb Configuration</label>
                                {{ Form::text('lighting_bulb_configuration', @$products->product_details->lighting_bulb_configuration,array('class'=>'form-control')) }}
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
                                {{ Form::text('lighting_housing_shape', @$products->product_details->lighting_housing_shape,array('class'=>'form-control')) }}
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
                                {{ Form::text('bracket_style', @$products->product_details->bracket_style,array('class'=>'form-control')) }}
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
                                {{ Form::text('cooling_fan_type', @$products->product_details->cooling_fan_type,array('class'=>'form-control')) }}
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
                                {{ Form::text('radiator_row_count', @$products->product_details->radiator_row_count,array('class'=>'form-control')) }}
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
                                {{ Form::text('oil_plan_capacity', @$products->product_details->oil_plan_capacity,array('class'=>'form-control')) }}
                                @if ($errors->has('oil_plan_capacity'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('oil_plan_capacity') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="meta_information">
                    <div class="row">
                        <div class="form-group {{ $errors->has('meta_title') ? ' has-error' : '' }}">
                            <label class="control-label">Meta Title</label>
                            {{ Form::text('meta_title', @$products->meta_title,array('class'=>'form-control')) }}
                            @if ($errors->has('meta_title'))
                            <span class="help-block">
                                <strong>{{ $errors->first('meta_title') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('meta_description') ? ' has-error' : '' }}">
                            <label class="control-label">Meta Description</label>
                            {{ Form::textarea('meta_description', @$products->meta_description,array('class'=>'form-control')) }}
                            @if ($errors->has('meta_description'))
                            <span class="help-block">
                                <strong>{{ $errors->first('meta_description') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('meta_keyword') ? ' has-error' : '' }}">
                            <label class="control-label">Meta Keyword</label>
                            {{ Form::textarea('meta_keyword', @$products->meta_keyword,array('class'=>'form-control')) }}
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
                    <div class="row">
                        <div class="list-group">
                            <?php $product_images = json_decode(@$products->product_details->product_images) ?>
                            @if($product_images != '')
                            @foreach($product_images as $key=>$img_val)
                            <div class="row form-group">
                                <div class="col-lg-2">
                                    <img width="100px" src="{{ URL::asset('/product_images').'/'.$img_val}}">
                                </div>
                                <div class="col-lg-2 pull-right">
                                    <a class="btn btn-xs btn-warning" onclick="$(this).parent().parent().remove();">
                                        <span class="glyphicon glyphicon-trash"></span>
                                    </a>
                                    <input type="hidden" name="old_product_image[]"value="{{ $img_val }}">
                                </div>
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
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
                        <li><input type="radio" @if($cat->id == $products->category_id) checked @endif name="parent_category" value="{{ $cat->id }}">{{ $cat->name }}
                                   @if(!empty($cat->sub_categories->toArray()))
                                   <a href="javascript:void(0);" class="toggleCategory"><span style="font-size: 20px;color: #000;font-weight: bold;" class="fa fa-angle-down"></span></a>
                            <ul class="sub_category" style="list-style: none;display: none;">
                                @foreach ($cat->sub_categories as $sub_cat)
                                <li class="@if($sub_cat->id == $products->sub_category_id) categoryExist @endif"><input type="radio" @if($sub_cat->id == $products->sub_category_id) checked @endif name="sub_category" value="{{ $sub_cat->id }}">{{ $sub_cat->name }}</li>
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
<script type="text/javascript">
    $(document).ready(function () {
        $("input[name='parent_category']").click(function () {
            $("input[name='sub_category']").prop('checked', false);
            $(this).parent().find(".sub_category li:first input").prop('checked', true);
        });
        $("input[name='sub_category']").click(function () {
            $("input[name='parent_category']").prop('checked', false);
            $(this).parent().parent().parent().find("input[name='parent_category']").prop('checked', true);
        });
    });
</script>
@endpush