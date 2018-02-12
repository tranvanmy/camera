<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title> @yield('userTitle') </title>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="content-language" content="vi">
    <meta name="description" content="@yield('seoDescription')">
    <meta name="keywords" content="@yield('seoKeyword')">
    <meta name="language" content="vietnamese">
    <link rel="icon" href="/favicon.ico" type="image/vnd.microsoft.icon">
    <link rel="stylesheet" href="/css/user.css" type="text/css">
    
    @yield('addCss')

</head>

<body>
    <div id="container" style="margin-top:25px">

        @include('user.library.header')

        @include('user.library.category')

        @yield('content')

        <div class="clear"></div>

        @include('user.library.footer')

    </div>

    @yield('addJavaScript')
</body>

</html>
