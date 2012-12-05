<div id="header-logo">
    <a href="{{ URL::to_route('upload') }}"><img src="{{ asset('images/logo.png') }}" alt="1337 Upload"></a>
</div>
<div id="header-search">
    <form action="{{ URL::to_route('search') }}" method="get" accept-encoding="UTF-8">
        <input type="text" name="search" value="" placeholder="{{ __('front.search_placeholder') }}">
        <input type="submit" value="{{ __('front.search_submit') }}">
    </form>
</div>
<div id="header-menu">
    <ul id="menu">
        <li>
            <a href="{{ URL::to_route('upload') }}">{{ __('front.link_upload') }}</a>
        </li><li>
            <a href="{{ URL::to_route('blog') }}">{{ __('front.link_blog') }}</a>
        </li><li>
            <a href="{{ URL::to_route('filelist') }}">{{ __('front.link_filelist') }}</a>
        </li><li>
            <a href="{{ URL::to_route('support') }}">{{ __('front.link_support') }}</a>
        </li><li>
            <a href="{{ URL::to_route('misc') }}">{{ __('front.link_misc') }}</a>
        </li>

        {{ ($user && $user->group_is_admin) ? '<li><a href="'.URL::to_route('admin').'">'.__('front.link_admin').'</a></li>' : '' }}

    </ul>
</div>