@extends('layouts.app')

@section('title', ('Add Fees'))

@section('content')
<style type="text/css">
  label {
    /*display: inline-block;*/
    /*max-width: 100%;*/
    margin-bottom: 20px !important;
    /*font-weight: bold;*/

}

</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2" id="side-navbar">
            @include('layouts.leftside-menubar')
        </div>
        <div class="col-md-10" id="main-container">
            <div class="panel panel-default">
                <div class="page-panel-title"><h1>@lang('Fees Entry')</h1></div>
                <div class="col-md-12"><hr></div>
                <div class="panel-body">
                    <div id="message"></div>
                    <form class="form-horizontal" method="POST" action="{{route('add-fees')}}" id="add_fees_form">
                        {{ csrf_field() }}
                        <input type="hidden" name="fid" value="{{$result->family_id}}">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                  <label class="col-md-4">Student Name:</label>
                                  <label class="col-md-8">{{$result->name}}</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                  <label class="col-md-4">Class:</label>
                                  <label class="col-md-4">{{$result->class}}</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                  <label class="col-md-4">Father Name:</label>
                                  <label class="col-md-8">{{$result->father_name}}</label>
                                </div>
                            </div>
                            <div class="col-md-12"><hr></div>
                            <div class="col-md-6">
                                <div class="form-group">
                                  <label class="col-md-4">Old Remaining:</label>
                                  <label id="old_remaining" class="col-md-4">{{$result->old_remaining}}</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                  <label class="col-md-5">Fee for session {{$result->session}}:</label>
                                  <label id="session_fees" class="col-md-4">{{$result->session_fees}}</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                  <label class="col-md-4">Previous Deposited:</label>
                                  <label id="previous" class="col-md-4">{{$result->paid_fees}}</label>
                                </div>
                            </div>
                            @if($result->discount == 0)
                              <div class="col-md-6">
                                  <div class="form-group">
                                    <label class="col-md-2">Discount:</label>
                                    <div class="col-md-3">
                                        <input type="text" id="discount" class="form-control">
                                    </div>

                                    <label class="col-md-4">Total Balance Rs:</label>
                                    <label id="total_balance" class="col-md-2">{{$result->balance}}</label>
                                  </div>
                              </div>
                            @else
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label class="col-md-4">Total Balance Rs:</label>
                                  <label id="total_balance" class="col-md-4">{{$result->balance}}</label>
                                </div>
                              </div>
                            @endif
                            <div class="col-md-6">
                                <div class="form-group">
                                  <label class="col-md-4">Received Fee:</label>
                                  <div class="col-md-4">
                                      <input type="text" name="received_fee" id="received_fee" class="form-control">
                                  </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                  <label class="col-md-2">Remaining Fee:</label>
                                  <label id="remaining_fees" class="col-md-10"></label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <button type="submit" id="addFeesBtn" class="btn btn-primary">
                                            @lang('Add Fees')
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
    $(document).ready(function(){
        $('#remaining_fees').text(parseInt($('#total_balance').text()));
        $('#discount').change(function(){
          var totalBalance = parseInt($('#old_remaining').text()) + parseInt($('#session_fees').text()) - parseInt($('#previous').text());
          if(!isNaN(parseInt($('#old_remaining').text())) && !isNaN(parseInt($('#session_fees').text())) && !isNaN(parseInt($('#previous').text())) && !isNaN(parseInt($(this).val()))){
                if(totalBalance >= parseInt($(this).val())){
                    $('#total_balance').text(totalBalance  - parseInt($(this).val()));
                }
          }else{
            $('#total_balance').text(totalBalance);
          }
          $('#received_fee').trigger('change');
        });

        $('#received_fee').change(function(){
          if(!isNaN(parseInt($(this).val())) && !isNaN(parseInt($('#total_balance').text()))){
                var receivedFee = parseInt($(this).val());
                var totalBalance = parseInt($('#total_balance').text());
                if(totalBalance >= receivedFee){
                  $('#remaining_fees').text(totalBalance  - receivedFee);
                }else{
                    $('#remaining_fees').text(totalBalance);
                }
          }else{
            $('#remaining_fees').text(parseInt($('#total_balance').text()));
          }
        });

        $('#add_fees_form').validate({
          rules: {
            received_fee: {
              required: true
            },
            messages: {
              received_fee: "Please enter fee"
            }
          },
          submitHandler: function(form,e){
              e.preventDefault();
              var formData = {
                'oldRemaining':$('#old_remaining').text(),
                'sessionFees':$('#session_fees').text(),
                'previous':$('#previous').text(),
                'discount':$('#discount').val(),
                'totalBalance':$('#total_balance').text(),
                'receivedFee':$('#received_fee').val(),
                'fid':$('input[name="fid"]').val(),
                '_token':$('input[name="_token"]').val()
              };
              $('#addFeesBtn').attr('disabled', true); 
              $('#message').empty();
              $.ajax({
                  type: 'POST',
                  url: $(form).attr('action'),
                  data: formData,
                  success: function (response) {
                        $('#addFeesBtn').attr('disabled', false);   
                        if(response.success!=undefined){
                            $('html, body').animate({
                                scrollTop: 0
                            }, 1000);
                            $('#message').append('<div class="alert alert-success alert-dismissible fade show" role="alert">'+response.success+'<button type="button" class="close p-2" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                            setTimeout(function(){
                                open(response.link);
                                location.reload();
                            },2000);
                            
                        }else if(response.error!=undefined){
                            $('html, body').animate({
                                scrollTop: 0
                            }, 1000);
                            $('#message').append('<div class="alert alert-danger alert-dismissible fade show" role="alert">'+response.error+'<button type="button" class="close p-2" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                        }
                  }
              });
          }

        });
    });
</script>
@endsection
