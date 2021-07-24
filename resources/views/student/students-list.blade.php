@extends('layouts.app')

@section('title', __('Students'))

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2" id="side-navbar">
            @include('layouts.leftside-menubar')
        </div>
        <div class="col-md-10" id="main-container">
            <div class="panel panel-default">
                <div class="page-panel-title">@lang('List of all students')</div>
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table id="studentslist_datatable" class="table " data-action="{{route('getStudentsList')}}" style="width:100%; ">
                            <thead>
                                <tr>
                                    <th>Student Name</th>
                                    <th>Class</th>
                                    <th>Father name</th>
                                    <th>Status</th>
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
     var dataTable = $('#studentslist_datatable').dataTable({
            "processing":true,
            "serverSide":true,
            "ajax":{
                url:$('#studentslist_datatable').data('action'),
                type:"GET",
                data : function ( d ) {
                    // d.vendor_type = vendor_type;
                    // d.city        = city;
                    // d.state       = state;
                }
            },
            columns: [
                {data: 'studentName'},

                {data: 'class'},

                {data: 'fatherName'},

                {data: 'status'},

                {data: 'action'}
            ],
            "order": [],
            "columnDefs": [ {
              "targets": [4],
              "orderable": false
            } ]
        });
</script>
@endsection
