@extends('admin/layouts.master')
@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row form-group">
        <div class="col-lg-12">
            <h1 class="page-header">
                Add New Zone/Region
            </h1>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <form class="form-horizontal" method="post" enctype="multipart/form-data" action="{{ route('zones.store')}}">
            {{ csrf_field()}}
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group {{ $errors->has('zone_name') ? ' has-error' : ''}}">
                        <label class="col-sm-3 col-md-3 control-label" for="zone_name">Zone Name:</label>
                        <div class="col-sm-9 col-md-9">
                            <input type="text" required="" name="zone_name" class="form-control" placeholder="Zone Name">
                            @if ($errors->has('zone_name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('zone_name')}}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('states') ? ' has-error' : ''}}">
                        <label class="col-sm-3 col-md-3 control-label" for="states">States:</label>
                        <div class="col-sm-9 col-md-9">
                            <select required="" name="states[]" class="form-control" id="states" multiple="multiple">
                                @foreach($states as $key=>$value)
                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('states'))
                            <span class="help-block">
                                <strong>{{ $errors->first('states')}}</strong>
                            </span>
                            @endif
                        </div>  
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <button type="submit" class="btn btn-success btn-block btn-lg">Submit</button>
                </div>
            </div>
        </form>
    </div>
    <!-- /.row -->
</div>
<!-- /.container-fluid -->
@endsection
@push('scripts')
<!-- Initialize the plugin: -->
<script type="text/javascript">
    $(document).ready(function() {
        $('#states').multiselect({
            numberDisplayed:6,
            maxHeight: 400
        });
    });
</script>
@endpush

