@extends('admin/layouts.master')

@section('content')
<div class="container-fluid">
    <div class="row form-group">
        <div class="col-md-12">
            <h3>All Orders :-</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="ui celled table" id="order-table">
                <thead>
                    <tr>
                        <th>Order Id</th>
                        <th>Customer Name</th>
                        <th>Customer Email</th>
                        <th>Shipping Price</th>
                        <th>Total Price</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@push('scripts')
<script type="text/javascript">
    $(function () {
        $('#order-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('orders.index') }}",
            order: [[ 6, "desc" ]],
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name',orderable: false, searchable: false,  render: function (data, type, row) {
                        return row.get_customer.first_name+' '+row.get_customer.last_name;
                    }
                },
                {data: 'email',orderable: false, searchable: false, render: function (data, type, row) {
                        return row.get_customer.email;
                    }
                },
                {data: 'ship_price', name: 'ship_price'},
                {data: 'total_price',  render: function (data, type, row) {
                        return row.total_price;
                    }
                },
                {data: 'order_status',render: function (data, type, row) {
                        return row.status;
                    }
                },
                {data: 'created_at', name: 'created_at'},
                {data: 'Action', orderable: false, searchable: false, render: function (data, type, row) {
                        //console.log(row.id);
                        return row.action;
                    }

                }
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
                window.location.reload();
//                var HTML = '<div class="alert alert-success fade in">';
//                HTML += '<a href="javascript:void(0);" onclick="$(this).parent().remove();" class="close" title="close">×</a>';
//                HTML += '<strong>Success! </strong>' + data.messages + '</div>';
//                $("#page-wrapper .container-fluid").before(HTML);
//                $(window).scrollTop(0);
            }).fail(function (data) {
                window.location.reload();
//                var HTML = '<div class="alert alert-danger fade in">';
//                HTML += '<a href="javascript:void(0);" onclick="$(this).parent().remove();" class="close" title="close">×</a>';
//                HTML += '<strong>Error! </strong>' + data.responseJSON.messages + '</div>';
//                $("#page-wrapper .container-fluid").before(HTML);
//                $(window).scrollTop(0);
            });
        });
    });
</script>
@endpush
@endsection
