<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Page Heading -->
    <?php echo e(Form::open(array('route' => 'products.store', 'class' => 'form','enctype'=>'multipart/form-data'))); ?>

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
                            <div class="form-group <?php echo e($errors->has('product_name') ? ' has-error' : ''); ?>">
                                <label class="control-label">Product Name<span class="comps">*</span></label>
                                <?php echo e(Form::text('product_name', null,array('required', 'class'=>'form-control'))); ?>

                                <?php if($errors->has('product_name')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('product_name')); ?></strong>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group <?php echo e($errors->has('price') ? ' has-error' : ''); ?>">
                                <label class="control-label">Product Price<span class="comps">*</span></label>
                                <?php echo e(Form::text('price', null,array('required', 'class'=>'form-control'))); ?>

                                <?php if($errors->has('price')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('price')); ?></strong>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group <?php echo e($errors->has('product_long_description') ? ' has-error' : ''); ?>">
                                <label class="control-label">Product Long Description<span class="comps">*</span></label>
                                <?php echo e(Form::textarea('product_long_description', null,array('required', 'class'=>'form-control'))); ?>

                                <?php if($errors->has('product_long_description')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('product_long_description')); ?></strong>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group <?php echo e($errors->has('product_short_description') ? ' has-error' : ''); ?>">
                                <label class="control-label">Product Short Description</label>
                                <?php echo e(Form::textarea('product_short_description', null,array('class'=>'form-control'))); ?>

                                <?php if($errors->has('product_short_description')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('product_short_description')); ?></strong>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group <?php echo e($errors->has('vehicle_fit') ? ' has-error' : ''); ?>">
                                <label class="control-label">Vehicle Fit</label>
                                <?php echo e(Form::textarea('vehicle_fit', null,array('class'=>'form-control'))); ?>

                                <?php if($errors->has('vehicle_fit')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('vehicle_fit')); ?></strong>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group <?php echo e($errors->has('part_number') ? ' has-error' : ''); ?>">
                                <label class="control-label">Part Number<span class="comps">*</span></label>
                                <?php echo e(Form::text('part_number', null,array('required', 'class'=>'form-control'))); ?>

                                <?php if($errors->has('part_number')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('part_number')); ?></strong>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group <?php echo e($errors->has('quantity') ? ' has-error' : ''); ?>">
                                <label class="control-label">Quantity<span class="comps">*</span></label>
                                <?php echo e(Form::text('quantity', null,array('required', 'class'=>'form-control'))); ?>

                                <?php if($errors->has('quantity')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('quantity')); ?></strong>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group <?php echo e($errors->has('status') ? ' has-error' : ''); ?>">
                                <label class="control-label">Status</label>
                                <?php echo e(Form::select('status', ['1' => 'Enabled','0'=>'Disabled'], null, ['required','class' => 'form-control'])); ?>

                                <?php if($errors->has('quantity')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('quantity')); ?></strong>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group <?php echo e($errors->has('discount') ? ' has-error' : ''); ?>">
                                <label class="control-label">Discount</label>
                                <?php echo e(Form::text('discount', null,array('class'=>'form-control'))); ?>

                                <?php if($errors->has('discount')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('discount')); ?></strong>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="auto_parts1">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group <?php echo e($errors->has('vehicle_year') ? ' has-error' : ''); ?>">
                                <label class="control-label">Vehicle Year</label>
                                <?php echo e(Form::text('vehicle_year', null,array('class'=>'form-control datepicker'))); ?>

                                <?php if($errors->has('vehicle_year')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('vehicle_year')); ?></strong>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group <?php echo e($errors->has('vehicle_make_id') ? ' has-error' : ''); ?>">
                                <label class="control-label">Vehicle Make</label>
                                <?php echo e(Form::select('vehicle_make_id', [], null, ['class' => 'form-control'])); ?>

                                <?php if($errors->has('vehicle_make_id')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('vehicle_make_id')); ?></strong>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group <?php echo e($errors->has('vehicle_model_id') ? ' has-error' : ''); ?>">
                                <label class="control-label">Vehicle Model</label>
                                <?php echo e(Form::select('vehicle_model_id', [], null, ['class' => 'form-control'])); ?>

                                <?php if($errors->has('vehicle_model_id')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('vehicle_model_id')); ?></strong>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group <?php echo e($errors->has('brand_id') ? ' has-error' : ''); ?>">
                                <label class="control-label">Brand</label>
                                <?php echo e(Form::select('brand_id', [], null, ['class' => 'form-control'])); ?>

                                <?php if($errors->has('brand_id')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('brand_id')); ?></strong>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group <?php echo e($errors->has('part_type') ? ' has-error' : ''); ?>">
                                <label class="control-label">Part Type</label>
                                <?php echo e(Form::text('part_type', null,array('class'=>'form-control'))); ?>

                                <?php if($errors->has('part_type')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('part_type')); ?></strong>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group <?php echo e($errors->has('operation') ? ' has-error' : ''); ?>">
                                <label class="control-label">Operation</label>
                                <?php echo e(Form::text('operation', null,array('class'=>'form-control'))); ?>

                                <?php if($errors->has('operation')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('operation')); ?></strong>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group <?php echo e($errors->has('wattage') ? ' has-error' : ''); ?>">
                                <label class="control-label">Wattage</label>
                                <?php echo e(Form::text('wattage', null,array('class'=>'form-control'))); ?>

                                <?php if($errors->has('wattage')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('wattage')); ?></strong>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group <?php echo e($errors->has('mirror_option') ? ' has-error' : ''); ?>">
                                <label class="control-label">Mirror Option</label>
                                <?php echo e(Form::text('mirror_option', null,array('class'=>'form-control'))); ?>

                                <?php if($errors->has('mirror_option')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('mirror_option')); ?></strong>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group <?php echo e($errors->has('location') ? ' has-error' : ''); ?>">
                                <label class="control-label">Location</label>
                                <?php echo e(Form::text('location', null,array('class'=>'form-control'))); ?>

                                <?php if($errors->has('location')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('location')); ?></strong>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group <?php echo e($errors->has('size') ? ' has-error' : ''); ?>">
                                <label class="control-label">Size</label>
                                <?php echo e(Form::text('size', null,array('class'=>'form-control'))); ?>

                                <?php if($errors->has('size')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('size')); ?></strong>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group <?php echo e($errors->has('material') ? ' has-error' : ''); ?>">
                                <label class="control-label">Material</label>
                                <?php echo e(Form::text('material', null,array('class'=>'form-control'))); ?>

                                <?php if($errors->has('material')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('material')); ?></strong>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group <?php echo e($errors->has('carpet_color') ? ' has-error' : ''); ?>">
                                <label class="control-label">Carpet Color</label>
                                <?php echo e(Form::text('carpet_color', null,array('class'=>'form-control'))); ?>

                                <?php if($errors->has('carpet_color')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('carpet_color')); ?></strong>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group <?php echo e($errors->has('light_option') ? ' has-error' : ''); ?>">
                                <label class="control-label">Light Option</label>
                                <?php echo e(Form::text('light_option', null,array('class'=>'form-control'))); ?>

                                <?php if($errors->has('light_option')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('light_option')); ?></strong>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group <?php echo e($errors->has('fuel_tank_option') ? ' has-error' : ''); ?>">
                                <label class="control-label">Fuel Tank Option</label>
                                <?php echo e(Form::text('fuel_tank_option', null,array('class'=>'form-control'))); ?>

                                <?php if($errors->has('fuel_tank_option')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('fuel_tank_option')); ?></strong>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group <?php echo e($errors->has('color') ? ' has-error' : ''); ?>">
                                <label class="control-label">Color</label>
                                <?php echo e(Form::text('color', null,array('class'=>'form-control'))); ?>

                                <?php if($errors->has('color')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('color')); ?></strong>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group <?php echo e($errors->has('hood_type') ? ' has-error' : ''); ?>">
                                <label class="control-label">Hood Type</label>
                                <?php echo e(Form::text('hood_type', null,array('class'=>'form-control'))); ?>

                                <?php if($errors->has('hood_type')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('hood_type')); ?></strong>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group <?php echo e($errors->has('front_location') ? ' has-error' : ''); ?>">
                                <label class="control-label">Front Location</label>
                                <?php echo e(Form::text('front_location', null,array('class'=>'form-control'))); ?>

                                <?php if($errors->has('front_location')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('front_location')); ?></strong>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group <?php echo e($errors->has('side_location') ? ' has-error' : ''); ?>">
                                <label class="control-label">Side Location</label>
                                <?php echo e(Form::text('side_location', null,array('class'=>'form-control'))); ?>

                                <?php if($errors->has('side_location')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('side_location')); ?></strong>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group <?php echo e($errors->has('tube_size') ? ' has-error' : ''); ?>">
                                <label class="control-label">Tube Size</label>
                                <?php echo e(Form::text('tube_size', null,array('class'=>'form-control'))); ?>

                                <?php if($errors->has('tube_size')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('tube_size')); ?></strong>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group <?php echo e($errors->has('wheel_option') ? ' has-error' : ''); ?>">
                                <label class="control-label">Wheel Option</label>
                                <?php echo e(Form::text('wheel_option',null,array('class'=>'form-control'))); ?>

                                <?php if($errors->has('wheel_option')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('wheel_option')); ?></strong>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="auto_parts2">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group <?php echo e($errors->has('includes') ? ' has-error' : ''); ?>">
                                <label class="control-label">Includes</label>
                                <?php echo e(Form::text('includes', null,array('class'=>'form-control'))); ?>

                                <?php if($errors->has('includes')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('includes')); ?></strong>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group <?php echo e($errors->has('design') ? ' has-error' : ''); ?>">
                                <label class="control-label">Design</label>
                                <?php echo e(Form::text('design', null,array('class'=>'form-control'))); ?>

                                <?php if($errors->has('design')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('design')); ?></strong>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group <?php echo e($errors->has('product_line') ? ' has-error' : ''); ?>">
                                <label class="control-label">Product Line</label>
                                <?php echo e(Form::text('product_line', null,array('class'=>'form-control'))); ?>

                                <?php if($errors->has('product_line')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('product_line')); ?></strong>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group <?php echo e($errors->has('software') ? ' has-error' : ''); ?>">
                                <label class="control-label">Software</label>
                                <?php echo e(Form::text('software', null,array('class'=>'form-control'))); ?>

                                <?php if($errors->has('software')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('software')); ?></strong>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group <?php echo e($errors->has('paint_code') ? ' has-error' : ''); ?>">
                                <label class="control-label">Paint Code</label>
                                <?php echo e(Form::text('paint_code', null,array('class'=>'form-control'))); ?>

                                <?php if($errors->has('paint_code')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('paint_code')); ?></strong>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group <?php echo e($errors->has('paint_applicator') ? ' has-error' : ''); ?>">
                                <label class="control-label">Paint Applicator</label>
                                <?php echo e(Form::text('paint_applicator', null,array('class'=>'form-control'))); ?>

                                <?php if($errors->has('paint_applicator')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('paint_applicator')); ?></strong>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group <?php echo e($errors->has('brake_pad') ? ' has-error' : ''); ?>">
                                <label class="control-label">Brake Pad</label>
                                <?php echo e(Form::text('brake_pad', null,array('class'=>'form-control'))); ?>

                                <?php if($errors->has('brake_pad')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('brake_pad')); ?></strong>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group <?php echo e($errors->has('tonneau_cover_type') ? ' has-error' : ''); ?>">
                                <label class="control-label">Tonneau Cover Type</label>
                                <?php echo e(Form::text('tonneau_cover_type', null,array('class'=>'form-control'))); ?>

                                <?php if($errors->has('tonneau_cover_type')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('tonneau_cover_type')); ?></strong>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group <?php echo e($errors->has('shaft_size') ? ' has-error' : ''); ?>">
                                <label class="control-label">Shaft Size</label>
                                <?php echo e(Form::text('shaft_size', null,array('class'=>'form-control'))); ?>

                                <?php if($errors->has('shaft_size')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('shaft_size')); ?></strong>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group <?php echo e($errors->has('licensed_by') ? ' has-error' : ''); ?>">
                                <label class="control-label">Licensed By</label>
                                <?php echo e(Form::text('licensed_by', null,array('class'=>'form-control'))); ?>

                                <?php if($errors->has('licensed_by')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('licensed_by')); ?></strong>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group <?php echo e($errors->has('car_cover') ? ' has-error' : ''); ?>">
                                <label class="control-label">Car Cover</label>
                                <?php echo e(Form::text('car_cover', null,array('class'=>'form-control'))); ?>

                                <?php if($errors->has('car_cover')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('car_cover')); ?></strong>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group <?php echo e($errors->has('tow_ball_diameter') ? ' has-error' : ''); ?>">
                                <label class="control-label">Tow Ball Diameter</label>
                                <?php echo e(Form::text('tow_ball_diameter', null,array('class'=>'form-control'))); ?>

                                <?php if($errors->has('tow_ball_diameter')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('tow_ball_diameter')); ?></strong>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group <?php echo e($errors->has('trailer_hitch_class') ? ' has-error' : ''); ?>">
                                <label class="control-label">Trailer Hitch Class</label>
                                <?php echo e(Form::text('trailer_hitch_class', null,array('class'=>'form-control'))); ?>

                                <?php if($errors->has('trailer_hitch_class')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('trailer_hitch_class')); ?></strong>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group <?php echo e($errors->has('kit_includes') ? ' has-error' : ''); ?>">
                                <label class="control-label">Kit Includes</label>
                                <?php echo e(Form::text('kit_includes', null,array('class'=>'form-control'))); ?>

                                <?php if($errors->has('kit_includes')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('kit_includes')); ?></strong>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group <?php echo e($errors->has('trunk_mat_color') ? ' has-error' : ''); ?>">
                                <label class="control-label">Trunk Mat Color</label>
                                <?php echo e(Form::text('trunk_mat_color', null,array('class'=>'form-control'))); ?>

                                <?php if($errors->has('trunk_mat_color')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('trunk_mat_color')); ?></strong>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group <?php echo e($errors->has('fender_flare_type') ? ' has-error' : ''); ?>">
                                <label class="control-label">Fender Flare Type</label>
                                <?php echo e(Form::text('fender_flare_type', null,array('class'=>'form-control'))); ?>

                                <?php if($errors->has('fender_flare_type')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('fender_flare_type')); ?></strong>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group <?php echo e($errors->has('product_grade') ? ' has-error' : ''); ?>">
                                <label class="control-label">Product Grade</label>
                                <?php echo e(Form::text('product_grade', null,array('class'=>'form-control'))); ?>

                                <?php if($errors->has('product_grade')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('product_grade')); ?></strong>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group <?php echo e($errors->has('lighting_wattage_rating') ? ' has-error' : ''); ?>">
                                <label class="control-label">Lighting Wattage Rating</label>
                                <?php echo e(Form::text('lighting_wattage_rating', null,array('class'=>'form-control'))); ?>

                                <?php if($errors->has('lighting_wattage_rating')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('lighting_wattage_rating')); ?></strong>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group <?php echo e($errors->has('lighting_size') ? ' has-error' : ''); ?>">
                                <label class="control-label">Lighting Size</label>
                                <?php echo e(Form::text('lighting_size', null,array('class'=>'form-control'))); ?>

                                <?php if($errors->has('lighting_size')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('lighting_size')); ?></strong>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group <?php echo e($errors->has('lighting_beam_pattern') ? ' has-error' : ''); ?>">
                                <label class="control-label">Lighting Beam Pattern</label>
                                <?php echo e(Form::text('lighting_beam_pattern', null,array('class'=>'form-control'))); ?>

                                <?php if($errors->has('lighting_beam_pattern')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('lighting_beam_pattern')); ?></strong>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="auto_parts3">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group <?php echo e($errors->has('lighting_lens_material') ? ' has-error' : ''); ?>">
                                <label class="control-label">Lighting Lens Material</label>
                                <?php echo e(Form::text('lighting_lens_material', null,array('class'=>'form-control'))); ?>

                                <?php if($errors->has('lighting_lens_material')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('lighting_lens_material')); ?></strong>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group <?php echo e($errors->has('lighting_mount_type') ? ' has-error' : ''); ?>">
                                <label class="control-label">Lighting Mount Type</label>
                                <?php echo e(Form::text('lighting_mount_type', null,array('class'=>'form-control'))); ?>

                                <?php if($errors->has('lighting_mount_type')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('lighting_mount_type')); ?></strong>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group <?php echo e($errors->has('lighting_bulb_count') ? ' has-error' : ''); ?>">
                                <label class="control-label">Lighting Bulb Count</label>
                                <?php echo e(Form::text('lighting_bulb_count', null,array('class'=>'form-control'))); ?>

                                <?php if($errors->has('lighting_bulb_count')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('lighting_bulb_count')); ?></strong>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group <?php echo e($errors->has('lighting_usage') ? ' has-error' : ''); ?>">
                                <label class="control-label">Lighting Usage</label>
                                <?php echo e(Form::text('lighting_usage', null,array('class'=>'form-control'))); ?>

                                <?php if($errors->has('lighting_usage')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('lighting_usage')); ?></strong>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group <?php echo e($errors->has('lighting_bulb_brand') ? ' has-error' : ''); ?>">
                                <label class="control-label">Lighting Bulb Brand</label>
                                <?php echo e(Form::text('lighting_bulb_brand', null,array('class'=>'form-control'))); ?>

                                <?php if($errors->has('lighting_bulb_brand')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('lighting_bulb_brand')); ?></strong>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group <?php echo e($errors->has('lighting_bulb_configuration') ? ' has-error' : ''); ?>">
                                <label class="control-label">Lighting Bulb Configuration</label>
                                <?php echo e(Form::text('lighting_bulb_configuration', null,array('class'=>'form-control'))); ?>

                                <?php if($errors->has('lighting_bulb_configuration')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('lighting_bulb_configuration')); ?></strong>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group <?php echo e($errors->has('lighting_housing_shape') ? ' has-error' : ''); ?>">
                                <label class="control-label">Lighting Housing Shape</label>
                                <?php echo e(Form::text('lighting_housing_shape', null,array('class'=>'form-control'))); ?>

                                <?php if($errors->has('lighting_housing_shape')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('lighting_housing_shape')); ?></strong>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group <?php echo e($errors->has('bracket_style') ? ' has-error' : ''); ?>">
                                <label class="control-label">Bracket Style</label>
                                <?php echo e(Form::text('bracket_style', null,array('class'=>'form-control'))); ?>

                                <?php if($errors->has('bracket_style')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('bracket_style')); ?></strong>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group <?php echo e($errors->has('cooling_fan_type') ? ' has-error' : ''); ?>">
                                <label class="control-label">Cooling Fan Type</label>
                                <?php echo e(Form::text('cooling_fan_type', null,array('class'=>'form-control'))); ?>

                                <?php if($errors->has('cooling_fan_type')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('cooling_fan_type')); ?></strong>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group <?php echo e($errors->has('radiator_row_count') ? ' has-error' : ''); ?>">
                                <label class="control-label">Radiator Row Count</label>
                                <?php echo e(Form::text('radiator_row_count', null,array('class'=>'form-control'))); ?>

                                <?php if($errors->has('radiator_row_count')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('radiator_row_count')); ?></strong>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group <?php echo e($errors->has('oil_plan_capacity') ? ' has-error' : ''); ?>">
                                <label class="control-label">Oil Plan Capacity</label>
                                <?php echo e(Form::text('oil_plan_capacity', null,array('class'=>'form-control'))); ?>

                                <?php if($errors->has('oil_plan_capacity')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('oil_plan_capacity')); ?></strong>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group <?php echo e($errors->has('intake_type') ? ' has-error' : ''); ?>">
                                <label class="control-label">Intake Type</label>
                                <?php echo e(Form::text('intake_type', null,array('class'=>'form-control'))); ?>

                                <?php if($errors->has('intake_type')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('intake_type')); ?></strong>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group <?php echo e($errors->has('regulator_option') ? ' has-error' : ''); ?>">
                                <label class="control-label">Regulator Option</label>
                                <?php echo e(Form::text('regulator_option', null,array('class'=>'form-control'))); ?>

                                <?php if($errors->has('regulator_option')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('regulator_option')); ?></strong>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group <?php echo e($errors->has('manufacturing_process') ? ' has-error' : ''); ?>">
                                <label class="control-label">Manufacturing Process</label>
                                <?php echo e(Form::text('manufacturing_process', null,array('class'=>'form-control'))); ?>

                                <?php if($errors->has('manufacturing_process')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('manufacturing_process')); ?></strong>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group <?php echo e($errors->has('brake_rotor_type') ? ' has-error' : ''); ?>">
                                <label class="control-label">Brake Rotor Type</label>
                                <?php echo e(Form::text('brake_rotor_type', null,array('class'=>'form-control'))); ?>

                                <?php if($errors->has('brake_rotor_type')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('brake_rotor_type')); ?></strong>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group <?php echo e($errors->has('thread_type') ? ' has-error' : ''); ?>">
                                <label class="control-label">Thread Type</label>
                                <?php echo e(Form::text('thread_type', null,array('class'=>'form-control'))); ?>

                                <?php if($errors->has('thread_type')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('thread_type')); ?></strong>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group <?php echo e($errors->has('spark_plug_type') ? ' has-error' : ''); ?>">
                                <label class="control-label">Spark Plug Type</label>
                                <?php echo e(Form::text('spark_plug_type', null,array('class'=>'form-control'))); ?>

                                <?php if($errors->has('spark_plug_type')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('spark_plug_type')); ?></strong>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="meta_information">
                    <div class="row">
                        <div class="form-group <?php echo e($errors->has('meta_title') ? ' has-error' : ''); ?>">
                            <label class="control-label">Meta Title</label>
                            <?php echo e(Form::text('meta_title', null,array('class'=>'form-control'))); ?>

                            <?php if($errors->has('meta_title')): ?>
                            <span class="help-block">
                                <strong><?php echo e($errors->first('meta_title')); ?></strong>
                            </span>
                            <?php endif; ?>
                        </div>
                        <div class="form-group <?php echo e($errors->has('meta_description') ? ' has-error' : ''); ?>">
                            <label class="control-label">Meta Description</label>
                            <?php echo e(Form::text('meta_description', null,array('class'=>'form-control'))); ?>

                            <?php if($errors->has('meta_description')): ?>
                            <span class="help-block">
                                <strong><?php echo e($errors->first('meta_description')); ?></strong>
                            </span>
                            <?php endif; ?>
                        </div>
                        <div class="form-group <?php echo e($errors->has('meta_keyword') ? ' has-error' : ''); ?>">
                            <label class="control-label">Meta Keyword</label>
                            <?php echo e(Form::text('meta_keyword', null,array('class'=>'form-control'))); ?>

                            <?php if($errors->has('meta_keyword')): ?>
                            <span class="help-block">
                                <strong><?php echo e($errors->first('meta_keyword')); ?></strong>
                            </span>
                            <?php endif; ?>
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
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                        <li><input type="checkbox" name="parent_category[]" value="<?php echo e($cat->id); ?>"><?php echo e($cat->name); ?>

                            <?php if(!empty($cat->sub_categories->toArray())): ?>
                            <a href="javascript:void(0);" class="toggleCategory"><span style="font-size: 20px;color: #000;font-weight: bold;" class="fa fa-angle-down"></span></a>
                            <ul class="sub_category" style="list-style: none;display: none;">
                                <?php $__currentLoopData = $cat->sub_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub_cat): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                <li><input type="checkbox" name="sub_category[]" value="<?php echo e($sub_cat->id); ?>"><?php echo e($sub_cat->name); ?>

                                    
                                </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                            </ul>
                            <?php endif; ?>
                        </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <!-- /.row -->
    <?php echo Form::close(); ?>

</div>
<!-- /.container-fluid -->
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin/layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>