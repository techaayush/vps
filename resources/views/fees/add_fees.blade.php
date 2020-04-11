@extends('layouts.app')

@section('title', __('Register'))

@section('content')
<style type="text/css">
  label {
    display: inline-block;
    max-width: 100%;
    margin-bottom: 40px !important;
    font-weight: bold;
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
                    <h2>Fees Entry</h2>
                    <form class="form-inline" method="post" action="{{route('add-fees')}}" id="add_fees_form">
                      @csrf
                      <input type="hidden" name="fid" value="{{$result->family_id}}">
                      <div class="col-md-10">
                        <div class="col-md-6">
                          <label style="margin-right: 50px;">Old Remaining:</label>
                          <label id="old_remaining">{{$result->old_remaining}}</label>
                        </div>
                        <div class="col-md-6">
                          <label style="margin-right: 50px;">Fee for session {{$result->session}}:</label>
                          <label id="session_fees">{{$result->yearly_fees}}</label>
                        </div>
                      </div>
                      <div class="col-md-10">
                        <div class="col-md-6">
                          <label style="margin-right: 50px;">Previous Deposited:</label>
                          <label id="previous">{{$result->paid_fees}}</label>
                        </div>
                        <div class="col-md-6">
                          <label style="margin-right: 50px;">Discount:</label>
                          <input type="text" id="discount">
                        </div>
                      </div>
                      <div class="col-md-10">
                        <div class="col-md-6">
                          <label style="margin-right: 50px;">Total Fee Rs:</label>
                          <label id="total_fee">{{$result->old_remaining + $result->yearly_fees - $result->paid_fees}}</label>
                        </div>
                        <div class="col-md-6">
                          <label style="margin-right: 50px;">Received Fee:</label>
                          <input type="text" id="received_fee">
                        </div>
                      </div>
                      <div class="col-md-10">
                        <div class="col-md-6">
                          <label style="margin-right: 50px;">Remaining Fee:</label>
                          <label id="remaining_fees"></label>
                        </div>
                        <div class="col-md-6">
                          <button class="btn btn-primary">Add</button>
                        </div>
                      </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    $('#discount').change(function(){
      if(!isNaN(parseInt($('#old_remaining').text())) && !isNaN(parseInt($('#session_fees').text())) && !isNaN(parseInt($('#previous').text())) && !isNaN(parseInt($(this).val()))){

          var totalFee = parseInt($('#old_remaining').text()) + parseInt($('#session_fees').text()) - parseInt($('#previous').text());
            if(totalFee >= parseInt($(this).val())){
                $('#total_fee').text(totalFee  - parseInt($(this).val()));
            }
      }else{
        var totalFee = parseInt($('#old_remaining').text()) + parseInt($('#session_fees').text()) - parseInt($('#previous').text());
        $('#total_fee').text(totalFee);
      }
      $('#received_fee').trigger('change');
    });

    $('#received_fee').change(function(){
      if(!isNaN(parseInt($(this).val())) && !isNaN(parseInt($('#total_fee').text()))){
            var receivedFee = parseInt($(this).val());
            var totalFee = parseInt($('#total_fee').text());
            if(totalFee >= receivedFee){
              $('#remaining_fees').text(totalFee  - receivedFee);
            }else{
                $('#remaining_fees').text('');
            }
      }else{
        $('#remaining_fees').text('');
      }
    });

    $('form').submit(function(e){
      e.preventDefault();
      var formData = {
        'oldRemaining':$('#old_remaining').text(),
        'sessionFees':$('#session_fees').text(),
        'previous':$('#previous').text(),
        'discount':$('#discount').val(),
        'totalFee':$('#total_fee').text(),
        'receivedFee':$('#received_fee').val(),
        'fid':$('input[name="fid"]').val()
      };
      $.ajax({
          type: 'POST',
          url: $(this).attr('action'),
          data: formData,
          success: function (response) {
              // $('#message').empty();
              // if(response.status){
              //   $('#student_name').val('');
              //   location.href = '{{url("fees_entry")}}/'+response.id;
              // }
              // else{
              //   $('#message').append('<div class="alert alert-danger alert-dismissible fade show" role="alert">No Record Found<button type="button" class="close p-2" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
              // }
          }
      });
    });
    
</script>
@endsection
