<!DOCTYPE html>
<html lang="en">
<?php
$user = Dashboard::user();
$navigations = Dashboard::navigations();
$active_navigation = Dashboard::active_navigation();
?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>

    <!-- =============== STYLES ===============-->
    <link rel="stylesheet" href="{{ asset('/css/vendor.css') }}">

    <link rel="stylesheet" href="{{ asset('/css/bootstrap.css') }}" id="bscss">
    <link rel="stylesheet" href="{{ asset('/css/app.css') }}" id="maincss">
    <link id="autoloaded-stylesheet" rel="stylesheet" href="{{ asset('/css/theme-a.css') }}">
    <script>
        window.byuapp =
		<?php echo json_encode( [
			                        'csrfToken' => csrf_token(),
			                        'url'       => asset( '/' ),
			                        'currency'  => Config::get( 'constants.currencies.USD' )
		                        ] ); ?>
    </script>
</head>
<body class="aside-collapsed"><!--layout-fixed aside-collapsed-texta aside-hover aside-show-scrollbar-->
<div class="wrapper">
@include ('layouts.nav')
<!-- Main section-->
    <section>
        <!-- Page content-->
        <div class="content-wrapper">
            <h3>{{ Dashboard::title() }}
                <div class="pull-right" id="top-layout">@yield('top')</div>
            </h3>
            <div class="row">
                <div class="col-lg-12" id="content-layout">
                    @yield('content')
                </div>
            </div>
        </div>
    </section>
    <!-- Page footer-->
    <footer>
        <span>&copy; {{ date('Y') }} - {{ config('app.name') }}</span>
    </footer>
</div>
@yield('modals')
<!-- =============== SCRIPTS ===============-->
<script src="{{ asset('/js/vendor.js') }}"></script>
<script src="{{ asset('/js/app.js') }}"></script>
<script>
    Pusher.log = function (m) {
        console.log(m);
    };

    var userid = {{ $user->id }};

    var pusher = new Pusher("{{env("PUSHER_KEY")}}");
    var channel = pusher.subscribe('user.' + userid);

    channel.bind("notification.created", function (data) {
        window.byuapp.addNotification(data);
    });

    $("body").on("click", function (e) {
        $target = $(e.target);

        $button_clicked = ($target.hasClass('ColVis_MasterButton') || $target.hasClass('ColVis_catcher') || $target.parents('.ColVis_MasterButton').length > 0 || $target.parents('.ColVis_collection').length > 0);
        $is_opened = $('.ColVis_collection').is(':visible');

        if (!$button_clicked && $is_opened)
            $('.ColVis_catcher').trigger('click');
    });
</script>
@stack('scripts')
</body>
</html>
