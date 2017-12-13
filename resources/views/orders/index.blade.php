@extends('layouts.app')
@push('stylesheet')
@endpush
@section('content')
<div class="row">
    <div class="order_progress">
        <div class="circle_tyo_order order_done">
            <span class="label">✓</span>
            <span class="title">Placed</span>
        </div>
        <span class="bar_tyo_order order_done"></span>
        
        <div class="circle_tyo_order active_tyo_order" >
            <span class="label"></span>
            <span class="title">Processed</span>
        </div>
        <span class="bar_tyo_order"></span>
        <div class="circle_tyo_order">
            <span class="label"></span>
            <span class="title">Shipped</span>
        </div>
        <span class="bar_tyo_order"></span>
        <div class="circle_tyo_order">
            <span class="label"></span>
            <span class="title">Completed</span>
        </div>
        <span class="bar_tyo_order"></span>
        <div class="circle_tyo_order">
            <span class="label"></span>
            <span class="title">Cancelled</span>
        </div>
    </div>
</div>
<div class="row">
    <div class="order_track_info">
        <span>Your order is shipped</span>
    </div>
</div>
@endsection
@push('scripts')
<script type="text/javascript">
    $(document).ready(function () {
    });
</script>
@endpush
