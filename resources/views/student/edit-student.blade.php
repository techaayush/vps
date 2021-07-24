@extends('layouts.app')

@section('title','Edit Student')

@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css" rel="stylesheet">
<style type="text/css">
    .error{
        color: red;
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2" id="side-navbar">
            @include('layouts.leftside-menubar')
        </div>
        <div class="col-md-8" id="main-container">
            <div class="panel panel-default">
                <div class="page-panel-title">@lang('Edit Student')</div>
                <div class="panel-body">
                    <div id="message"></div>
                    <form class="form-horizontal" method="POST" id="studentUpdateForm" action="{{ route('edit-student-details') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">* @lang('Full Name')</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{$studentDetails->full_name}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="gender" class="col-md-4 control-label">* @lang('Gender')</label>
                            <input type="hidden" name="sid" value="{{base64_encode($studentDetails->studentId)}}">
                            <div class="col-md-6">
                                @if($studentDetails->gender=='M')
                                    <label class="control-label">Male</label>
                                @elseif($studentDetails->gender=='F')
                                    <label class="control-label">Female</label>
                                @else
                                    <label class="control-label">Others</label>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="dob" class="col-md-4 control-label">* @lang('Date of birth')</label>
                            <div class="col-md-6">
                                <label class="control-label">{{date('d/m/Y',strtotime($studentDetails->dob))}}</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="age" class="col-md-4 control-label">* @lang('Age')</label>
                            <div class="col-md-6">
                                <label class="control-label">{{$studentDetails->age}}</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="class" class="col-md-4 control-label">* @lang('Class')</label>
                            <div class="col-md-6">
                                <label class="control-label">{{$studentDetails->className}}</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="admission_date" class="col-md-4 control-label">* @lang('Admission Date')</label>
                            <div class="col-md-6">
                                <label class="control-label">{{date('d/m/Y',strtotime($studentDetails->admission_date))}}</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="religion" class="col-md-4 control-label">* @lang('Religion')</label>
                            <div class="col-md-6">
                                <label class="control-label">{{$studentDetails->religion}}</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="caste" class="col-md-4 control-label">* @lang('Caste')</label>
                            <div class="col-md-6">
                                <label class="control-label">{{$studentDetails->caste}}</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="caste_category" class="col-md-4 control-label">* @lang('Category')</label>
                            <div class="col-md-6">
                                <label class="control-label">{{$studentDetails->caste_category}}</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="address" class="col-md-4 control-label">* @lang('Address')</label>
                            <div class="col-md-6">
                                <input id="address" type="text" class="form-control" name="address" value="{{$studentDetails->address}}" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="place" class="col-md-4 control-label">* @lang('Place')</label>
                            <div class="col-md-6">
                                <input id="place" type="text" class="form-control" name="place" value="{{$studentDetails->place}}" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="contact_1" class="col-md-4 control-label">* @lang('Contact 1')</label>
                            <div class="col-md-6">
                                <input id="contact_1" type="text" class="form-control" name="contact_1" value="{{$studentDetails->phone_one}}" >
                                
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="contact_2" class="col-md-4 control-label">@lang('Contact 2')</label>
                            <div class="col-md-6">
                                <input id="contact_2" type="text" class="form-control" name="contact_2" value="{{$studentDetails->phone_two}}" >
                                
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="previous_school" class="col-md-4 control-label">@lang('Previous School')</label>
                            <div class="col-md-6">
                                <input id="previous_school" type="text" class="form-control" name="previous_school" value="{{$studentDetails->previous_school_name}}" >
                                
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="previous_school_class" class="col-md-4 control-label">@lang('Previous School Class')</label>
                            <div class="col-md-6">
                                <input id="previous_school_class" type="text" class="form-control" name="previous_school_class" value="{{$studentDetails->previous_school_class}}" >
                                
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="aadhar_no" class="col-md-4 control-label">@lang('Aadhar Number')</label>
                            <div class="col-md-6">
                                <input id="aadhar_no" type="text" class="form-control" name="aadhar_no" value="{{$studentDetails->aadhar_number}}" >
                                
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="samagra_id" class="col-md-4 control-label">@lang('Samagra Id')</label>
                            <div class="col-md-6">
                                <input id="samagra_id" type="text" class="form-control" name="samagra_id" value="{{$studentDetails->samagra_id}}" >
                                
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="bank_account" class="col-md-4 control-label">@lang('Bank Account No.')</label>
                            <div class="col-md-6">
                                <input id="bank_account" type="text" class="form-control" name="bank_account" value="{{$studentDetails->bank_account_number}}" >
                                
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ifsc" class="col-md-4 control-label">@lang('IFSC')</label>
                            <div class="col-md-6">
                                <input id="ifsc" type="text" class="form-control" name="ifsc" value="{{$studentDetails->ifsc}}" >
                                
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="status" class="col-md-4 control-label">* @lang('Status')</label>
                            <div class="col-md-6">
                                <select id="status" class="form-control" name="status">
                                    <option value="1" @if($studentDetails->status) {{ 'selected' }} @endif >@lang('Available')</option>
                                    <option value="0" @if(!$studentDetails->status) {{ 'selected' }} @endif >@lang('Left')</option>
                                </select>
                                @if ($errors->has('status'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('status') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="scholar_no" class="col-md-4 control-label">* @lang('Scholar Number')</label>
                            <div class="col-md-6">
                                <label class="control-label">{{$studentDetails->scholar_number}}</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="family_code" class="col-md-4 control-label">* @lang('Family Code')</label>
                            <div class="col-md-6">
                                <label class="control-label">{{$studentDetails->family_id}}</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="father_name" class="col-md-4 control-label">@lang('Father Name')</label>
                            <div class="col-md-6">
                                <input id="father_name" type="text" class="form-control" name="father_name" value="{{$studentDetails->father_name}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="father_occupation" class="col-md-4 control-label">@lang('Father Occupation')</label>
                            <div class="col-md-6">
                                <input id="father_occupation" type="text" class="form-control" name="father_occupation" value="{{$studentDetails->father_occupation}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="mother_name" class="col-md-4 control-label">@lang('Mother Name')</label>
                            <div class="col-md-6">
                                <input id="mother_name" type="text" class="form-control" name="mother_name" value="{{$studentDetails->mother_name}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="mother_occupation" class="col-md-4 control-label">@lang('Mother Occupation')</label>
                            <div class="col-md-6">
                                <input id="mother_occupation" type="text" class="form-control" name="mother_occupation" value="{{$studentDetails->mother_occupation}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" id="updateBtn" class="btn btn-primary">
                                    @lang('Update')
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
<script src="{{asset('js/jquery.validate.min.js')}}"></script>
<script>
    $('#dob,#admission_date').datepicker({
        format: "dd/mm/yyyy",
    });

    $('#studentUpdateForm').validate({
        rules:{
            name: {
                required:true
            },
            address: {
                required:true
            },
            place: {
                required:true
            },
            contact_1: {
                required:true
            },
            status: {
                required:true
            }
        },
        errorPlacement: function(error, element)
        {
            if (element.is(":radio") )
            {
                error.insertAfter( element.parents('.m-radio-inline') );
            }
            else
            { 
                error.insertAfter( element.parent() );
            }
        },
        submitHandler: function(form) {
            $('#updateBtn').attr('disabled', true);    
            $('#message').empty();
            $.ajax({
                type: 'POST',
                url: $("#studentUpdateForm").attr('action'),
                data: $("#studentUpdateForm").serialize(),
                success: function (response) {
                    $('#updateBtn').attr('disabled', false);
                    if(response.success!=undefined){
                        $('html, body').animate({
                            scrollTop: 0
                        }, 1000);
                        $('#message').append('<div class="alert alert-success alert-dismissible fade show" role="alert">'+response.success+'<button type="button" class="close p-2" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                        
                    }else if(response.error!=undefined){
                        $('html, body').animate({
                            scrollTop: 0
                        }, 1000);
                        $('#message').append('<div class="alert alert-danger alert-dismissible fade show" role="alert">'+response.error+'<button type="button" class="close p-2" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    }
                },
            });
        }
    });
</script>
@endsection
