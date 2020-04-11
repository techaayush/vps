@extends('layouts.app')

@section('title', __('Register'))

@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css" rel="stylesheet">
<style>

/*the container must be positioned relative:*/
.autocomplete {
  position: relative;
  display: inline-block;
}

input {
  border: 1px solid transparent;
  background-color: #f1f1f1;
  padding: 10px;
  font-size: 16px;
}

input[type=text] {
  background-color: #f1f1f1;
  width: 100%;
}

input[type=submit] {
  background-color: DodgerBlue;
  color: #fff;
  cursor: pointer;
}

.autocomplete-items {
  position: absolute;
  border: 1px solid #d4d4d4;
  border-bottom: none;
  border-top: none;
  z-index: 99;
  /*position the autocomplete items to be the same width as the container:*/
  top: 100%;
  left: 0;
  right: 0;
}

.autocomplete-items div {
  padding: 10px;
  cursor: pointer;
  background-color: #fff; 
  border-bottom: 1px solid #d4d4d4; 
}

/*when hovering an item:*/
.autocomplete-items div:hover {
  background-color: #e9e9e9; 
}
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2" id="side-navbar">
            @include('layouts.leftside-menubar')
        </div>
        <div class="col-md-10" id="main-container">
            @if (session('status'))
            <div class="alert alert-success">
                @if (session('register_school_id'))
                    <a href="{{ url('school/admin-list/' . session('register_school_id')) }}" target="_blank" class="text-white pull-right">@lang('View Admins')</a>
                @endif
            </div>
            @endif
            <div class="panel panel-default">
                <div class="card-body mt-3">
                    <div id="message"></div>
                      <h4>Find Student</h4>
                      <div class="autocomplete" style="width:800px;">
                        <input id="student_name" type="text" name="student_name" placeholder="Search student" data-id>
                        <div id="searchResult" class="autocomplete-items"></div>
                      </div>
                      <input type="submit" value="Search">
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var route = "{{url('search_student_autocomplete')}}";
    $('#student_name').keyup(function(){
        var searchText = $(this).val();
        if(searchText != ""){
            $.ajax({
                url:route,
                data:{student_name:searchText},
                success: function (response) {
                    var len = response.length;
                    $("#searchResult").empty();
                    for( var i = 0; i<len; i++){
                        var id = response[i]['id'];
                        var name = response[i]['name'];
                        var father_name = response[i]['father_name'];
                        $("#searchResult").append("<div><span value="+id+">"+name+" ( "+father_name+" )</span></div>");
                    }
                }
            });
        }
    });

    $("#searchResult").on('click','span',function(){
        var value = $(this).text();
        var id = $(this).attr('value');
        $("#student_name").val(value);
        $('#student_name').attr('data-id',id);
        $("#searchResult").empty();
    });

    $('input[type="submit"]').click(function(e){
        if($("#student_name").val())
          $.ajax({
              type: 'GET',
              url: "{{url('search_student_details')}}",
              data: {id:$('#student_name').attr('data-id')},
              success: function (response) {
                  $('#message').empty();
                  if(response.status){
                    $('#student_name').val('');
                    location.href = '{{url("fees_entry")}}/'+response.id;
                  }
                  else{
                    $('#message').append('<div class="alert alert-danger alert-dismissible fade show" role="alert">No Record Found<button type="button" class="close p-2" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                  }
              }
          });
     });
    
</script>
@endsection
