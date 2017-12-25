<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <title>{{ config('app.name') }}</title>

    <!-- =============== STYLES ===============-->
    <link rel="stylesheet" href="{{ asset('/css/vendor.css') }}">

    <link rel="stylesheet" href="{{ asset('/css/bootstrap.css') }}" id="bscss">
    <link rel="stylesheet" href="{{ asset('/css/app.css') }}" id="maincss">
    <script>
        window.grm =
		<?php echo json_encode( [
			                        'url'      => asset( '/' ),
			                        'currency' => Config::get( 'constants.currencies.USD' )
		                        ] ); ?>
    </script>
</head>
<body>
<div class="wrapper">
    <!-- Page content-->
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12" id="content-layout">
                @yield('content')
            </div>
        </div>
    </div>
</div>
@yield('modals')
<!-- =============== SCRIPTS ===============-->
<script src="{{ asset('/js/vendor.js') }}"></script>
<script src="{{ asset('/js/app.js') }}"></script>
@stack('scripts')
</body>
</html>