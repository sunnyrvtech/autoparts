@extends('admin/layouts.master')

@section('content')
<div class="container-fluid">
    <div class="row form-group">
        <div class="col-md-12">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="ui celled table" id="brand-table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Product Name</th>
                        <th>Customer Name</th>
                        <th>Customer Email</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                        <th>Discount</th>
                        <th>Status</th>
                        <th>Created At</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@push('scripts')
<script type="text/javascript">
    $(function () {
        $('#brand-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('orders.index') }}",
            order: [[ 8, "desc" ]],
            columns: [
                {data: 'id', name: 'id'},
                {data: 'product_name',orderable: false, searchable: false, render: function (data, type, row) {
                        return row.get_order_details.get_product.product_name;
                    }
                },
                {data: 'name',orderable: false, searchable: false,  render: function (data, type, row) {
                        return row.get_customer.first_name+' '+row.get_customer.last_name;
                    }
                },
                {data: 'email',orderable: false, searchable: false, render: function (data, type, row) {
                        return row.get_customer.email;
                    }
                },
                {data: 'quantity',orderable: false, searchable: false,  render: function (data, type, row) {
                        return row.get_order_details.quantity;
                    }
                },
                {data: 'total_price',orderable: false, searchable: false,  render: function (data, type, row) {
                        return row.get_order_details.total_price;
                    }
                },
                {data: 'discount',orderable: false, searchable: false,  render: function (data, type, row) {
                        return row.get_order_details.discount;
                    }
                },
                {data: 'order_status', render: function (data, type, row) {
                        return row.status;
                    }
                },
                {data: 'created_at', name: 'created_at'}
            ]
        });
        
        $(document).on('change', '#order_status', function (e) {
            e.preventDefault(); // does not go through with the link.
            $(".alert-danger").remove();
            $(".alert-success").remove();
            var $this = $(this);

            $.post({
                data: {'id': $this.data('id'), 'status': $this.val()},
                url: "{{ route('orders-status') }}"
            }).done(function (data) {
                var HTML = '<div class="alert alert-success fade in">';
                HTML += '<a href="javascript:void(0);" onclick="$(this).parent().remove();" class="close" title="close">×</a>';
                HTML += '<strong>Success! </strong>' + data.messages + '</div>';
                $("#page-wrapper .container-fluid").before(HTML);
                $(window).scrollTop(0);
            }).fail(function (data) {
                var HTML = '<div class="alert alert-danger fade in">';
                HTML += '<a href="javascript:void(0);" onclick="$(this).parent().remove();" class="close" title="close">×</a>';
                HTML += '<strong>Error! </strong>' + data.responseJSON.error + '</div>';
                $("#page-wrapper .container-fluid").before(HTML);
                $(window).scrollTop(0);
            });
        });
    });
</script>
@endpush
@endsection
