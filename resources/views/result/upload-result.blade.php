@extends('layouts.app')

@section('title', 'Result Upload')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2" id="side-navbar">
            @include('layouts.leftside-menubar')
        </div>
        <div class="col-md-10" id="main-container">
            <div class="panel panel-default">
                <div class="page-panel-title"><h1>@lang('Upload Results')</h1></div>
                <div class="col-md-12"><hr></div>
                <div class="panel-body">
                    @if(session('error'))
                      <div class="alert alert-danger alert-dismissible fade show" role="alert">{{session('error')}}<button type="button" class="close p-2" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      </div>
                    @endif
                    @if(session('success'))
                      <div class="alert alert-success alert-dismissible fade show" role="alert">{{session('success')}}<button type="button" class="close p-2" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      </div>
                    @endif
                    <form class="form-horizontal" method="post" action="{{url('result/upload')}}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row">
                            <!-- <div class="col-md-4">
                                <div class="form-group">
                                  <label class="col-md-4 control-label">Class Group:</label>
                                  <div class="col-md-6">
                                      <select id="class" class="form-control" name="class">
                                          <option value="Pre-Primary" selected="">Pre-Primary</option>
                                          <option value="Primary">Primary</option>
                                          <option value="Middle">Middle</option>
                                      </select>
                                  </div>
                                </div>
                            </div> -->
                            <div class="col-md-4">
                                <div class="form-group">
                                  <label class="col-md-4 control-label">Class:</label>
                                  <div class="col-md-6">
                                      <select id="class" class="form-control" name="class">
                                        @foreach($classes as $class)
                                          @if ($loop->first)
                                            <option value="{{$class->id}}" selected="">{{$class->name}}</option>
                                          @else
                                            <option value="{{$class->id}}">{{$class->name}}</option>
                                          @endif
                                        @endforeach
                                      </select>
                                  </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                  <div class="col-md-6">
                                    <label>Select Excel File</label>
                                    <input type="file" name="file" id="file" required accept=".xls, .xlsx" />
                                  </div>
                                  <div class="col-md-6">
                                      <button id="uploadButton" class="btn btn-primary" name="upload">
                                          @lang('Upload')
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
