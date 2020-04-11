@extends('layouts.app')

@section('title','Edit Class')

@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css" rel="stylesheet">
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2" id="side-navbar">
            @include('layouts.leftside-menubar')
        </div>
        <div class="col-md-8" id="main-container">
            @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
                @if (session('register_school_id'))
                    <a href="{{ url('school/admin-list/' . session('register_school_id')) }}" target="_blank" class="text-white pull-right">@lang('View Admins')</a>
                @endif
            </div>
            @endif
            <div class="panel panel-default">
                <div class="page-panel-title">Edit Class</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" id="" action="{{url('edit_class')}}">
                        {{ csrf_field() }}
                        @if(!empty($classes) && count($classes)>0)
                            @foreach($classes as $class)
                                <input type="hidden" name="id[]" value="{{$class->id}}">
                                <label for="name" class="col-md-4 control-label">{{$class->name}}</label>
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <input id="yearly_fees" type="text" class="form-control" name="yearly_fees[]" value="{{ $class->yearly_fees}}"
                                            required>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" id="registerBtn" class="btn btn-primary">
                                    Update
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
