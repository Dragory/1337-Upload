<div id="header-logo">
    <a href="{{ URL::to_route('index') }}"><img src="{{ asset('images/logo.png') }}" alt="1337 Upload"></a>
</div>
<div id="header-search">
    <form action="{{ URL::to_route('search') }}" method="get">
        {{ Form::token() }}

        <input type="text" name="search" value="" placeholder="Search...">
        <input type="submit" value="Search">
    </form>
</div>
<div id="header-menu">
    <ul id="menu">
        <li><a href="{{ URL::to_route('upload') }}">Upload</a></li>
        <li><a href="{{ URL::to_route('blog') }}">Blog</a></li>
        <li><a href="{{ URL::to_route('files') }}">Files</a></li>
        <li><a href="{{ URL::to_route('support') }}">Support</a></li>
        <li><a href="{{ URL::to_route('misc') }}">Misc</a></li>

        {{ ($currentUser != null && $currentUser->group_is_admin) ? '<li><a href="'.URL::to_route('admin').'">Admin</a></li>' : '' }}

    </ul>
</div>