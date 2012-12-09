<!doctype html>
<html>
<head>
    <meta charset="UTF-8">

    <title>{{ $title }}</title>

    <link rel="stylesheet" type="text/css" href="{{ asset('css/normalize.css') }}">
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
            <div id="content-userbar" class="cf">
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

    <script type="text/javascript">
        var baseUrl   = '{{ URL::base() }}';
        var uploadUrl = '{{ URL::to_route('upload_post') }}';

        var csrf_token = '{{ Session::token() }}';

        var loggedIn = {{ $user ? 'true' : 'false' }};

<?php if ($user): ?>
        var token  = '{{ str_replace("'", null, $user->user_token) }}';
<?php endif; ?>
    </script>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/uploader/fineuploader-3.0.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/uploader.js') }}"></script>
</body>
</html>