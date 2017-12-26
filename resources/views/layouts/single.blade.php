<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <title>{{ config('app.name') }}</title>
    <link rel="icon" href="{{ asset('/img/favicon.png') }}" sizes="30x30" type="image/png">

    <!-- =============== STYLES ===============-->
    <link rel="stylesheet" href="{{ asset('css/vendor.css') }}">

    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link id="autoloaded-stylesheet" rel="stylesheet" href="{{ asset('/css/grm.css') }}">
    <style>
        .middle-block {
            display: flex;
            align-items: center;
            min-height: 100vh;
        }

        body {
            background: url({{ asset('img/background.png') }}) no-repeat center fixed;
            background-size: cover;
        }
    </style>
    @yield('style')
</head>
<body class="single-block">
<div class="wrapper">
    <div class="middle-block">
        @yield('content')
    </div>
</div>

<!-- =============== SCRIPTS ===============-->
<script src="js/vendor.js"></script>
<script src="js/app.js"></script>
@stack('scripts')
</body>
</html>
