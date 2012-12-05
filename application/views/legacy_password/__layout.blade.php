<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <title>{{ __('front.legacy_password_title') }}</title>

    <link rel="stylesheet" type="text/css" href="{{ asset('css/normalize.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div id="content">
        <div id="content-wrap">
            <div id="content-password-wrap">
                {{ $status }}

                {{ $content }}

            </div>
        </div>
    </div>
    <div id="footer">
        <br><br><br>
    </div>
</body>
</html>