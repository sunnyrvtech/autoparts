@extends('layouts.app')
@section('content')
<div class="container">
    <div>
        <section><div id="breadcrumb">
                <a href="{{ url('/') }}">Home</a>
                <span class="divider"> &gt; </span><span>{{ $sub_categories->name }}</span></div>
            <br></section>
        <div>
            <div class="container-fluid">
                <div class="row">
                    <h1 class="onea-page-header">{{ $sub_categories->name }}</h1>
                </div>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="catalog-list row">
                                @foreach($sub_categories->sub_sub_categories as $value)
                                <div class="col-xs-4">
                                    <div class="row">
                                        <div class="col-xs-12 catalog-list-item">
                                            <a href="{{ url('/'.$value->get_vehicle_company_name->name.'/'.$sub_categories->slug) }}"><span class="fa fa-angle-double-right"></span> {{ $sub_categories->name.' '.$value->get_vehicle_company_name->name }}</a>
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
</div>
@endsection
@push('scripts')
@endpush
