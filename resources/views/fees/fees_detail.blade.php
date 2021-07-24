@extends('layouts.app')

@section('title', __('Student Fees Detail'))

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2" id="side-navbar">
            @include('layouts.leftside-menubar')
        </div>
        <div class="col-md-10" id="main-container">
            <div class="panel panel-default">
                <div class="page-panel-title">@lang('Student Payment Details')</div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table id="student_payments_datatable" class="table " data-action="{{route('getStudentPaymentDetails',$familyId)}}" style="width:100%; ">
                            <thead>
                                <tr>
                                    <th>Receipt</th>
                                    <th>Payment Amount</th>
                                    <th>Payment Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
     var dataTable = $('#student_payments_datatable').DataTable({
            "processing":true,
            "serverSide":true,
            "ajax":{
                url:$('#student_payments_datatable').data('action'),
                type:"GET",
                data : function ( d ) {
                    // d.vendor_type = vendor_type;
                    // d.city        = city;
                    // d.state       = state;
                }
            },
            columns: [
                {data: 'receipt'},

                {data: 'amount'},

                {data: 'date'},

                {data: 'action'}
            ],
            "order": [],
            "columnDefs": [ {
              "targets": [3],
              "orderable": false
            } ]
        });
</script>
@endsection
