<!DOCTYPE html>
<html lang="en">
<?php
    $user = Dashboard::user();
    $user_setting = Dashboard::user_setting();
    $navigations = Dashboard::navigations();
    $active_navigation = Dashboard::active_navigation();
?>
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
   <link id="autoloaded-stylesheet" rel="stylesheet" href="{{ asset('/css/'. $user_setting->theme.'.css') }}">
   <script>
       window.grm =
       <?php echo json_encode([
           'csrfToken' => csrf_token(),
           'url' => asset('/'),
       ]); ?>
   </script>
</head>
<body class="@if($user_setting->fixed) layout-fixed @endif @if($user_setting->boxed) layout-boxed @endif @if($user_setting->collapsed) aside-collapsed @endif @if($user_setting->collapsed_text) aside-collapsed-text @endif @if($user_setting->float) aside-float @endif @if($user_setting->hover) aside-hover @endif @if($user_setting->show_scrollbar) aside-show-scrollbar @endif ">
   <div class="wrapper">
       @include ('layouts.nav')
       <!-- Main section-->
       <section>
          <!-- Page content-->
          <div class="content-wrapper">

              <h3>{{ Dashboard::title() }}</h3>
              <div class="unwrap" id="content-layout">
                 @yield('content')
              </div>
          </div>
       </section>
       <!-- Page footer-->
       <footer>
          <span>&copy; {{ date('Y') }} - BYU Marketing</span>
       </footer>
   </div>
   @yield('modals')
   <!-- =============== SCRIPTS ===============-->
   <script src="{{ asset('/js/vendor.js') }}"></script>
   <script src="{{ asset('/js/app.js') }}"></script>
   @stack('scripts')
</body>
</html>
