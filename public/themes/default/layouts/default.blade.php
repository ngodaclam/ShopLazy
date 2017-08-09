<!DOCTYPE html>
<html lang="en">
<head>
    <title>{!! Theme::get('title') !!}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="author" content="{!! Theme::get('author') !!}">
    <meta name="keywords" content="{!! Theme::get('keywords') !!}">
    <meta name="description" content="{!! Theme::get('description') !!}">

    <!-- BEGIN PAGE STYLE -->
    {!! Theme::asset()->styles() !!}
    <!-- END PAGE STYLE -->
    {!! Theme::asset()->scripts() !!}

    <script type="text/javascript">
        var LOCALE = '{!! $locale !!}';
    </script>
</head>
<body class="color-default theme-sdtd bg-light-default theme-sdtl fixed-topbar">
<!--[if lt IE 7]>
<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->
<section>
    <!-- BEGIN SIDEBAR -->
    {!! Theme::partial('nav') !!}
    <!-- END SIDEBAR -->
    <div class="main-content">
        <!-- BEGIN TOPBAR -->
        {!! Theme::partial('header') !!}
        <!-- END TOPBAR -->
        <!-- BEGIN PAGE CONTENT -->
        <div class="page-content page-thin">
            {!! Theme::partial('flash.message') !!}
            {!! Theme::content() !!}
            <div class="footer">
                {!! Theme::partial('footer') !!}
            </div>
        </div>
        <!-- END PAGE CONTENT -->
    </div>
    <!-- END MAIN CONTENT -->
</section>
<!-- END QUICKVIEW SIDEBAR -->
<!-- BEGIN SEARCH -->
{!! Theme::partial('morphsearch') !!}
<!-- END SEARCH -->
<!-- BEGIN PRELOADER -->
<div class="loader-overlay">
    <div class="spinner">
        <div class="bounce1"></div>
        <div class="bounce2"></div>
        <div class="bounce3"></div>
    </div>
</div>
<!-- END PRELOADER -->
<a href="#" class="scrollup"><i class="fa fa-angle-up"></i></a>

<!-- BEGIN PAGE SCRIPT -->
{!! Theme::asset()->container('footer')->scripts() !!}
{!! Theme::asset()->container('footer-scripts')->scripts() !!}
<!-- END PAGE SCRIPT -->
</body>
</html>