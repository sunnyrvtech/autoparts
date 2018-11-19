@extends('layouts.app')
@section('content')
<div class="container">
    <form class="form-horizontal" role="form" method="post" action="{{ route('cart.addresses') }}">
        {{ csrf_field() }}
        <h3>Please confirm your shipping and billing address before proceed to checkout: </h3>
        <div class="addresses-container">
            <div class="col-md-12">
                <div class="col-md-6" style="border-right: 1px solid #C5C5C5;">
                    <h4>Billing address:</h4>
                    @if(Auth::check())
                    <label class="checkbox-inline"></label>
                    @endif
                    <div class="address-area">
                        <div class="form-group">
                            <label >First name:</label>
                            <input type="text" class="form-control" id="billing_first_name" name="billing_first_name" placeholder="First name" value="{{ isset($billing_address->first_name)?$billing_address->first_name:'' }}" required>
                        </div>
                        <div class="form-group">
                            <label >Last name:</label>
                            <input type="text" class="form-control" id="billing_last_name" name="billing_last_name" placeholder="Last name" value="{{ isset($billing_address->last_name)?$billing_address->last_name:'' }}" required>
                        </div>
                        @if(!Auth::check())
                        <div class="form-group">
                            <label>Email:</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{ Session::get('customer_email') }}" required>
                        </div>
                        @else
                        <input type="hidden" class="form-control" id="email" name="email" placeholder="Email" value="{{ Auth::user()->email }}" required>
                        @endif
                        <div class="form-group">
                            <label >Address1:</label>
                            <input type="text" class="form-control" id="billing_address1" name="billing_address1" placeholder="Address1" value="{{ isset($billing_address->address1)?$billing_address->address1:'' }}" required>
                        </div>
                        <div class="form-group">
                            <label>Address2:</label>
                            <input class="form-control" id="billing_address2" name="billing_address2" type="text" value="{{ isset($billing_address->address2)?$billing_address->address2:'' }}" placeholder="Address2">
                        </div>
                        <div class="form-group">
                            <label>Country:</label>
                            <select name="billing_country_id" id="billing_country_id" required="" class="form-control country_sel">
                                <option value="">Please select country</option>
                                @foreach($countries as $val)
                                @if(isset($billing_address->country_id) && $val->id == $billing_address->country_id)
                                <?php $selected = 'selected'; ?>
                                @else
                                <?php $selected = ''; ?>
                                @endif
                                <option {{ $selected }} value="{{ $val->id }}">{{ $val->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>State:</label>
                            <select name="billing_state_id" id="billing_state_id" required="" class="form-control states">
                                <option value="">Please select state</option>
                                @if(isset($billing_states))
                                @foreach($billing_states as $val)
                                <option @if($val->id == $billing_address->state_id) selected @endif value="{{ $val->id }}">{{ $val->name }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label>City:</label>
                            <input class="form-control" id="billing_city" name="billing_city" type="text" value="{{ isset($billing_address->city)?$billing_address->city:'' }}" required>
                        </div>
                        <div class="form-group">
                            <label>Post Code:</label>
                            <input type="text" class="form-control" id="billing_zip" name="billing_zip" placeholder="Post code" value="{{ isset($billing_address->zip)?$billing_address->zip:'' }}">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <h4>Shipping address:</h4>
                    <div class="address-area">
                        <div class="form-group">
                            <label class="checkbox-inline">
                                <input type="checkbox" name="same_billing"><span>Same as billing address</span>
                            </label>
                        </div>
                        <div class="form-group">
                            <label >First name:</label>
                            <input type="text" class="form-control" id="shipping_first_name" name="shipping_first_name" placeholder="First name" value="{{ isset($shipping_address->first_name)?$shipping_address->first_name:'' }}" required>
                        </div>
                        <div class="form-group">
                            <label >Last name:</label>
                            <input type="text" class="form-control" id="shipping_last_name" name="shipping_last_name" placeholder="Last name" value="{{ isset($shipping_address->last_name)?$shipping_address->last_name:'' }}" required>
                        </div>
                        <div class="form-group">
                            <label >Address1:</label>
                            <input type="text" class="form-control" id="shipping_address1" name="shipping_address1" placeholder="Address1" value="{{ isset($shipping_address->address1)?$shipping_address->address1:'' }}" required>
                        </div>
                        <div class="form-group">
                            <label>Address2:</label>
                            <input class="form-control" id="shipping_address2" name="shipping_address2" type="text" value="{{ isset($shipping_address->address2)?$shipping_address->address2:'' }}" placeholder="Address2">
                        </div>
                        <div class="form-group">
                            <label>Country:</label>
                            <select name="shipping_country_id" id="shipping_country_id" required="" class="form-control country_sel">
                                <option value="">Please select country</option>
                                @foreach($countries as $val)
                                @if(isset($shipping_address->country_id) && $val->id == $shipping_address->country_id)
                                <?php $selected = 'selected'; ?>
                                @else
                                <?php $selected = ''; ?>
                                @endif
                                <option {{ $selected }} value="{{ $val->id }}">{{ $val->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>State:</label>
                            <select name="shipping_state_id" id="shipping_state_id" required="" class="form-control states">
                                <option value="">Please select state</option>
                                @if(isset($shipping_states))
                                @foreach($shipping_states as $val)
                                <option @if($val->id == $shipping_address->state_id) selected @endif value="{{ $val->id }}">{{ $val->name }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label>City:</label>
                            <input class="form-control" id="shipping_city" name="shipping_city" type="text" value="{{ isset($shipping_address->city)?$shipping_address->city:'' }}" required>
                        </div>
                        <div class="form-group">
                            <label>Post Code:</label>
                            <input type="text" class="form-control" id="shipping_zip" name="shipping_zip" placeholder="Post code" value="{{ isset($shipping_address->zip)?$shipping_address->zip:'' }}">
                        </div>
                    </div>
                    <div class="btn-wrp text-right">
                        <button type="submit" class="btn am-orange">Continue</button>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </form>
</div>
@endsection
@push('scripts')
<script type="text/javascript">
    $(document).ready(function () {
        $(document).on('click', 'input[name="same_billing"]', function () {
            if ($(this).is(':checked')) {
                $('#shipping_first_name').val($('#billing_first_name').val());
                $('#shipping_last_name').val($('#billing_last_name').val());
                $('#shipping_address1').val($('#billing_address1').val());
                $('#shipping_address2').val($('#billing_address2').val());
                $('#shipping_country_id').val($('#billing_country_id').val());
                $('#shipping_state_id').html($('#billing_state_id').html());
                $('#shipping_state_id').val($('#billing_state_id').val());
                $('#shipping_city').val($('#billing_city').val());
                $('#shipping_zip').val($('#billing_zip').val());
            } else {
                $('#shipping_first_name').val('');
                $('#shipping_last_name').val('');
                $('#shipping_address1').val('');
                $('#shipping_address2').val('');
                $('#shipping_country_id').val('');
                $('#shipping_state_id').html('');
                $('#shipping_city').val('');
                $('#shipping_zip').val('');
            }
        });

        $(document).on('change', '.country_sel', function () {
            var $this = $(this).parent().parent().find('.states');
            $this.html('');
            $.ajax({
                url: "{{ route('get_state') }}",
                type: 'POST',
                data: {_token: window.Laravel.csrfToken, 'id': $(this).val()},
                success: function (data) {
                    $.each(data, function (index, value) {
                        //alert(value.id);
                        $this.append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                }
            });
        });
    });
</script>
@endpush