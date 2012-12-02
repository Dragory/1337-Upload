<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <title>{{ $title }}</title>

    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div id="header">
        <div id="header-wrap">
            {{ $header }}

        </div><!-- id="header-wrap" -->
    </div><!-- id="header" -->

    <div id="content">
        <div id="content-wrap">
            <div id="content-userbar">
                {{ $userbar }}

            </div>

            {{ $status }}

            {{ $content }}

        </div><!-- id="content-wrap" -->
    </div><!-- id="content" -->

    <div id="footer">
        <div id="footer-wrap">
            {{ $footer }}

        </div><!-- id="footer-wrap" -->
    </div><!-- id="footer" -->
</body>
</html>