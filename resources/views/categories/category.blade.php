@extends('layouts.app')
@section('content')
<div class="container">
    <div>
        <section><div id="breadcrumb"><a href="{{ url('/') }}">Home</a>{!! $bredcrum !!}</div>
            <br></section>
        <div>
            <div class="container-fluid">
                <div class="row">
                    <h1 class="onea-page-header">{{ $filter_title }}</h1>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="catalog-list row">
                            @foreach($filter_data as $value)
                            <div class="col-xs-4">
                                <div class="row">
                                    <div class="col-xs-12 catalog-list-item">
                                        @if(isset($sub_categories->slug) && !isset($value->get_vehicle_model->name))
                                        <a href="{{ url('/'.$value->get_vehicle_company->slug.'/'.$sub_categories->slug) }}"><span class="fa fa-angle-double-right"></span> {{ $value->get_vehicle_company->name.' '.$sub_categories->name }}</a>
                                        @elseif(isset($sub_categories->slug) && isset($value->get_vehicle_model->name))
                                        <a href="{{ url('/'.$value->get_vehicle_company->slug.'/'.$value->get_vehicle_model->slug.'/'.$sub_categories->slug) }}"><span class="fa fa-angle-double-right"></span> {{ $value->get_vehicle_company->name.' '.$value->get_vehicle_model->name.' '.$sub_categories->name }}</a>
                                        @elseif(isset($value->get_sub_category->name))
                                        @if(isset($year))
                                        <a href="{{ url('/'.$year.'/'.$value->get_vehicle_company->slug.'/'.$value->get_vehicle_model->slug.'/'.$value->get_sub_category->slug) }}"><span class="fa fa-angle-double-right"></span> {{ $value->get_sub_category->name }}</a>
                                        @else
                                        <a href="{{ url('/'.$value->get_vehicle_company->slug.'/'.$value->get_vehicle_model->slug.'/'.$value->get_sub_category->slug) }}"><span class="fa fa-angle-double-right"></span> {{ $value->get_sub_category->name }}</a>
                                        @endif
                                        @else
                                        <a href="{{ url('/'.$value->get_vehicle_company->slug.'/'.$value->get_vehicle_model->slug) }}"><span class="fa fa-angle-double-right"></span> {{ $value->get_vehicle_model->name.' '.$value->get_vehicle_company->name }}</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
@endpush
