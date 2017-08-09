<!DOCTYPE html>
<html>
<head>
    <title>{!! theme()->get('title') !!}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="{!! theme()->get('author') !!}">
    <meta name="keywords" content="{!! theme()->get('keywords') !!}">
    <meta name="description" content="{!! theme()->get('description') !!}">
    <link rel="shortcut icon" href="{{ url('themes/default/assets/img/favicon.png') }}">
    {!! theme()->asset()->styles() !!}
    {!! theme()->asset()->container('header-styles')->styles() !!}
    {!! theme()->asset()->scripts() !!}
    {!! theme()->asset()->container('header-scripts')->scripts() !!}
</head>
<body class="account2 no-social" data-page="login">
<!-- BEGIN LOGIN BOX -->

{!! theme()->content() !!}

<!-- END LOCKSCREEN BOX -->
{!! theme()->partial('footer') !!}
{!! theme()->asset()->container('footer')->scripts() !!}
{!! theme()->asset()->container('footer-scripts')->scripts() !!}
</body>
</html>