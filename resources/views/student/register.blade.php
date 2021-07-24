@extends('layouts.app')

@section('title','Register Student')

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
                <div class="page-panel-title">@lang('Register Student')</div>
                <div class="panel-body">
                    <div id="message"></div>
                    <form class="form-horizontal" method="POST" id="studentRegisterForm" action="{{ url('register') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">* @lang('Full Name')</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}">
                                @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="gender" class="col-md-4 control-label">* @lang('Gender')</label>
                            <div class="col-md-6">
                                <select id="gender" class="form-control" name="gender">
                                    <option value="M" selected="">@lang('Male')</option>
                                    <option value="F">@lang('Female')</option>
                                    <option value="O">@lang('Others')</option>
                                </select>
                                @if ($errors->has('gender'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('gender') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="dob" class="col-md-4 control-label">* @lang('Date of birth')</label>
                            <div class="col-md-6">
                                <input id="dob" type="text" class="form-control" name="dob" value="{{ old('dob') }}" autocomplete="off">
                                @if ($errors->has('dob'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('dob') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="age" class="col-md-4 control-label">* @lang('Age')</label>
                            <div class="col-md-6">
                                <input id="age" type="text" class="form-control" name="age" value="{{ old('age') }}">
                                @if ($errors->has('age'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('age') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="class" class="col-md-4 control-label">* @lang('Class')</label>
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
                                @if ($errors->has('class'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('class') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        @if(isset($sessions))
                        <div class="form-group">
                            <label for="session" class="col-md-4 control-label">* @lang('Admission Session')</label>
                            <div class="col-md-6">
                                <select id="session" class="form-control" name="session">
                                    @foreach ($sessions as $session)
                                        @if ($loop->first)
                                            <option value="{{$session}}" selected>{{$session}}</option>
                                        @else
                                            <option value="{{$session}}">{{$session}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @if ($errors->has('session'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('session') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        @endif
                        <div class="form-group">
                            <label for="admission_date" class="col-md-4 control-label">* @lang('Admission Date')</label>
                            <div class="col-md-6">
                                <input id="admission_date" type="text" class="form-control" name="admission_date" value="{{ old('admission_date') }}" autocomplete="off">
                                @if ($errors->has('admission_date'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('admission_date') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="religion" class="col-md-4 control-label">* @lang('Religion')</label>
                            <div class="col-md-6">
                                <select id="religion" class="form-control" name="religion">
                                    <option value="islam" selected="selected">@lang('Islam')</option>
                                    <option value="hinduism">@lang('Hinduism')</option>
                                    <option value="sikhism">@lang('Sikhism')</option>
                                    <option value="christianism">@lang('Christianism')</option>
                                    <option value="buddhism">@lang('Buddhism')</option>
                                    <option value="other">@lang('Other')</option>
                                </select>
                                @if ($errors->has('religion'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('religion') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="caste" class="col-md-4 control-label">* @lang('Caste')</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="caste" value="{{ old('caste') }}">
                                @if ($errors->has('caste'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('caste') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="caste_category" class="col-md-4 control-label">* @lang('Category')</label>
                            <div class="col-md-6">
                                <select id="caste_category" class="form-control" name="caste_category">
                                    <option value="G" selected="selected">@lang('GENERAL')</option>
                                    <option value="O">@lang('OBC')</option>
                                    <option value="SC">@lang('SC')</option>
									<option value="ST">@lang('ST')</option>
                                </select>
                                @if ($errors->has('caste_category'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('caste_category') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="address" class="col-md-4 control-label">* @lang('Address')</label>
                            <div class="col-md-6">
                                <input id="address" type="text" class="form-control" name="address" value="{{ old('address') }}" >
                                @if ($errors->has('address'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('address') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="place" class="col-md-4 control-label">* @lang('Place')</label>
                            <div class="col-md-6">
                                <input id="place" type="text" class="form-control" name="place" value="{{ old('place') }}" >
                                @if ($errors->has('place'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('place') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="contact_1" class="col-md-4 control-label">* @lang('Contact 1')</label>
                            <div class="col-md-6">
                                <input id="contact_1" type="text" class="form-control" name="contact_1" value="{{ old('contact_1') }}" >
                                @if ($errors->has('contact_1'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('contact_1') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="contact_2" class="col-md-4 control-label">@lang('Contact 2')</label>
                            <div class="col-md-6">
                                <input id="contact_2" type="text" class="form-control" name="contact_2" value="{{ old('contact_2') }}" >
                                @if ($errors->has('contact_2'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('contact_2') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="previous_school" class="col-md-4 control-label">@lang('Previous School')</label>
                            <div class="col-md-6">
                                <input id="previous_school" type="text" class="form-control" name="previous_school" value="{{ old('previous_school') }}" >
                                @if ($errors->has('previous_school'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('previous_school') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="previous_school_class" class="col-md-4 control-label">@lang('Previous School Class')</label>
                            <div class="col-md-6">
                                <input id="previous_school_class" type="text" class="form-control" name="previous_school_class" value="{{ old('previous_school_class') }}" >
                                @if ($errors->has('previous_school_class'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('previous_school_class') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="aadhar_no" class="col-md-4 control-label">@lang('Aadhar Number')</label>
                            <div class="col-md-6">
                                <input id="aadhar_no" type="text" class="form-control" name="aadhar_no" value="{{ old('aadhar_no') }}" >
                                @if ($errors->has('aadhar_no'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('aadhar_no') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="samagra_id" class="col-md-4 control-label">@lang('Samagra Id')</label>
                            <div class="col-md-6">
                                <input id="samagra_id" type="text" class="form-control" name="samagra_id" value="{{ old('samagra_id') }}" >
                                @if ($errors->has('samagra_id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('samagra_id') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="samagra_id" class="col-md-4 control-label">@lang('Bank Account No.')</label>
                            <div class="col-md-6">
                                <input id="bank_account" type="text" class="form-control" name="bank_account" value="{{ old('bank_account') }}" >
                                @if ($errors->has('bank_account'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('bank_account') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ifsc" class="col-md-4 control-label">@lang('IFSC')</label>
                            <div class="col-md-6">
                                <input id="ifsc" type="text" class="form-control" name="ifsc" value="{{ old('ifsc') }}" >
                                @if ($errors->has('ifsc'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('ifsc') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="scholar_no" class="col-md-4 control-label">* @lang('Scholar Number')</label>
                            <div class="col-md-6">
                                <input id="scholar_no" type="text" class="form-control" name="scholar_no" value="{{ old('scholar_no') }}" >
                                @if ($errors->has('scholar_no'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('scholar_no') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="family_code" class="col-md-4 control-label">* @lang('Family Code')</label>
                            <div class="col-md-6">
                                <input id="family_code" type="text" class="form-control" name="family_code" value="{{$familyDetails?$familyDetails->id:old('family_code') }}" >
                                @if ($errors->has('family_code'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('family_code') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="father_name" class="col-md-4 control-label">@lang('Father Name')</label>
                            <div class="col-md-6">
                                <input id="father_name" type="text" class="form-control" name="father_name" value="{{$familyDetails?$familyDetails->father_name:old('father_name') }}">
                                @if ($errors->has('father_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('father_name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="father_occupation" class="col-md-4 control-label">@lang('Father Occupation')</label>
                            <div class="col-md-6">
                                <input id="father_occupation" type="text" class="form-control" name="father_occupation"
                                    value="{{$familyDetails?$familyDetails->father_occupation:old('father_occupation') }}">
                                @if ($errors->has('father_occupation'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('father_occupation') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="mother_name" class="col-md-4 control-label">@lang('Mother Name')</label>
                            <div class="col-md-6">
                                <input id="mother_name" type="text" class="form-control" name="mother_name" value="{{$familyDetails?$familyDetails->mother_name:old('mother_name') }}">
                                @if ($errors->has('mother_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('mother_name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="mother_occupation" class="col-md-4 control-label">@lang('Mother Occupation')</label>
                            <div class="col-md-6">
                                <input id="mother_occupation" type="text" class="form-control" name="mother_occupation"
                                    value="{{$familyDetails?$familyDetails->mother_occupation:old('mother_occupation') }}">
                                @if ($errors->has('mother_occupation'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('mother_occupation') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" id="registerBtn" class="btn btn-primary">
                                    @lang('Register')
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

    $('#studentRegisterForm').validate({
        rules:{
            name: {
                required:true
            },
            Gender: {
                required:true
            },
            dob: {
                required:true
            },
            age: {
                required:true
            },
            class: {
                required:true
            },
            admission_date: {
                required:true
            },
            session: {
                required:true
            },
            religion: {
                required:true
            },
            caste: {
                required:true
            },
            caste_category: {
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
            scholar_no: {
                required:true
            },
            family_code: {
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
            $('#registerBtn').attr('disabled', true);    
            $('#message').empty();
            $.ajax({
                type: 'POST',
                url: $("#studentRegisterForm").attr('action'),
                data: $("#studentRegisterForm").serialize(),
                success: function (response) {
                    $('#registerBtn').attr('disabled', false);
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
