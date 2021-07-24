@extends('layouts.app')

@section('title','Edit Class')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2" id="side-navbar">
            @include('layouts.leftside-menubar')
        </div>
        <div class="col-md-8" id="main-container">
            <div class="panel panel-default">
                <div class="page-panel-title">Edit Class</div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="col-md-2" style="margin-left: 83px;">Class</label>
                            <label class="col-md-4" style="margin-left: 83px;">Yearly Fees</label>
                        </div>
                        <div class="col-md-12"><hr></div>
                    </div>
                    <form class="form-horizontal" method="POST" id="" action="{{url('edit_class')}}">
                        {{ csrf_field() }}
                        @if(!empty($classes) && count($classes)>0)
                            @foreach($classes as $class)
                                <div class="form-group">
                                    <label class="control-label col-md-2">{{$class->name}}:</label>
                                    <div class="col-md-4">
                                      <input id="yearly_fees" type="text" class="form-control" name="yearly_fees[{{$class->id}}]" value="{{$class->yearly_fees}}"
                                            required>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                              <button type="submit" id="registerBtn" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
