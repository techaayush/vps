@extends('layouts.app')

@section('title', 'Test Marks Sheet')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2" id="side-navbar">
            @include('layouts.leftside-menubar')
        </div>
        <div class="col-md-10" id="main-container">
            <div class="panel panel-default">
                <div class="page-panel-title"><h1>@lang('Download Test Marks Sheet')</h1></div>
                <div class="col-md-12">
                  @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">{{session('error')}}<button type="button" class="close p-2" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                  @endif
                  <hr>
                </div>
                <div class="panel-body">
                    <div id="message"></div>
                    <form class="form-horizontal" method="post" action="{{url('test-marks-sheet')}}">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                  <label class="col-md-4 control-label">Class:</label>
                                  <div class="col-md-6">
                                      <select id="class" class="form-control" name="class">
                                          <option value="1" selected="">NUR</option>
                                          <option value="2">LKG</option>
                                          <option value="3">UKG</option>
                                          <option value="4">1</option>
                                          <option value="5">2</option>
                                          <option value="6">3</option>
                                          <option value="7">4</option>
                                          <option value="8">5</option>
                                          <option value="9">6</option>
                                          <option value="10">7</option>
                                          <option value="11">8</option>
                                      </select>
                                  </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <button id="downloadButton" class="btn btn-primary">
                                            @lang('Download')
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    
</script>
@endsection
