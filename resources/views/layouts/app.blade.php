<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <!-- <meta name="csrf-token" content="{{ csrf_token() }}"> -->

    <title>@yield('title')</title>
    <link rel="stylesheet" type="text/css" href="{{asset('css/all.min.css')}}">
    <link rel="stylesheet" href="{{ url('css/loader.css') }}">
    <link rel="stylesheet" href="{{ url('css/vendors.css') }}" id="bootswatch-print-id">
    <link rel="stylesheet" href="{{ url('css/application.css') }}">
    <script src="{{ url('js/vendors.js') }}"></script>
</head>
<body>
    @include('components.loader')
    <div id="app">
        @include('components.navbar-top')
        @yield('content')
    </div>
    
    <script src="{{ url('js/jquery.validate.min.js') }}"></script>
    <script src="{{ url('js/application.js') }}"></script>
    <script type="text/javascript">
        $(function () {
            $("#loginForm").validate({
                rules: {
                    email: {
                        required: true
                    },
                    password: {
                        required: true
                    }
                },
                errorPlacement: function (error, element) {
                    error.insertAfter(element);
                }
            });

            $('.nav-item.active').removeClass('active');
            $('a[href="' + window.location.href + '"]').closest('li').closest('ul').closest('li').addClass('active');
            $('a[href="' + window.location.href + '"]').closest('li').addClass('active');
        });
    </script>
</body>
</html>
