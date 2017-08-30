@extends('admin/layouts.master')
@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row form-group">
        <div class="col-lg-12">
            <h1 class="page-header">
                Add New Tax Rate
            </h1>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <form class="form-horizontal" method="post" action="{{ route('tax_rates.store')}}">
            {{ csrf_field()}}
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group {{ $errors->has('country_id') ? ' has-error' : ''}}">
                        <label class="col-sm-3 col-md-3 control-label" for="country_id">Country:</label>
                        <div class="col-sm-9 col-md-9">
                            <select required="" name="country_id" id="country_id" class="form-control">
                                @foreach($countries as $key=>$value)
                                <option @if($value->id == 231) selected @endif value="{{ $value->id }}">{{ $value->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('country_id'))
                            <span class="help-block">
                                <strong>{{ $errors->first('country_id')}}</strong>
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
                    <div class="form-group {{ $errors->has('price') ? ' has-error' : ''}}">
                        <label class="col-sm-3 col-md-3 control-label" for="price">Price:</label>
                        <div class="col-sm-9 col-md-9">
                            <input type="text" required="" name="price" value="" class="form-control" placeholder="Price">
                            @if ($errors->has('price'))
                            <span class="help-block">
                                <strong>{{ $errors->first('price')}}</strong>
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
    $(document).ready(function () {
        $('#states').multiselect({
            includeSelectAllOption: true,
            numberDisplayed: 6,
            maxHeight: 400
        });
        
        $("#country_id").change(function(){
             $.ajax({
                url: "{{ url('/my-account/getState') }}",
                type: 'POST',
                data: {'id': $(this).val()},
                success: function (data) {
                     $("#states").html('');
                   $.each(data, function(key,val) {
                       $("#states").append($("<option></option>").val(val.id).html(val.name));
                   });
                   $('#states').multiselect('rebuild');
                },
                error: function (error) {
                    alert('Something went wrong,please try again later!');
                }
            });
        });
        
        
        
        
    });
</script>
@endpush

