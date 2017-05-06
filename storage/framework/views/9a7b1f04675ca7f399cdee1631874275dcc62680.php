<div class="row ymm-con">
    <div class="col-md-0"></div>
    <div class="col-md-12 material" elevation="1">
        <div class="am-ymm horizontal hide-header full-width">
            <h2>Select your vehicle</h2>
            <?php
            $minYear = date('Y', strtotime('-50 year'));
            $maxYear = date('Y', strtotime('+1 year'));
            // set start and end year range
            $yearArray = range($maxYear, $minYear);
            ?>
            <div class="am-ymm-inner">
                <h3 id="ymm-header">Find parts for your car</h3>
                <form id="am-ymm-home-form">
                    <div class="btn-group year-select ymm-select">
                        <button class="btn btn-default dropdown-toggle input-xlg" data-toggle="dropdown" type="button">
                            <span class="select-text" id="vehicle_year">Select Vehicle Year</span><span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu scrollable-menu">
                            <li><a role="button">Select Vehicle Year</a></li>
                            <?php $__currentLoopData = $yearArray; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                            <li><a data-id="<?php echo e($val); ?>" data-method="vehicle_year" data-url="<?php echo e(url('products/vehicle')); ?>" role="button"><?php echo e($val); ?></a></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                        </ul>
                    </div>

                    <div class="btn-group make-select ymm-select">
                        <button class="btn btn-default dropdown-toggle input-xlg" data-toggle="dropdown" type="button">
                            <span class="select-text" id="vehicle_make">Select Vehicle Make</span><span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu scrollable-menu">
                            <li><a role="button">Select Vehicle Make</a></li>
                            <li ng-repeat="x in result_vehicle_company"><a data-id="<%x.get_vehicle_company.id%>" data-method="vehicle_company" data-url="<?php echo e(url('products/vehicle_model')); ?>" role="button"><%x.get_vehicle_company.name%></a></li>
                        </ul>
                    </div>

                    <div class="btn-group model-select ymm-select">
                        <button class="btn btn-default dropdown-toggle input-xlg" data-toggle="dropdown" type="button">
                            <span class="select-text" id="vehicle_model">Select Vehicle Model</span><span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu scrollable-menu">
                            <li><a role="button">Select Vehicle Model</a></li>
                            <li ng-repeat="x in result_vehicle_model"><a data-id="<%x.get_vehicle_model.id%>" data-method="vehicle_model"  role="button"><%x.get_vehicle_model.name%></a></li>
                        </ul>
                    </div>
                    <button class="btn btn-xlg am-orange hover material ymm-submit" elevation="1" ng-click="searchProduct()" type="submit">Search</button>
                    <br class="clearfix" />
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-0"></div>
</div>