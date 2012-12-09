<?php if ($user): ?>
    <div id="userbar">
        <a href="{{ URL::to_route('profile') }}">{{ $user->user_username }}</a>
    </div>
<?php else: ?>
    <div id="userbar">
        <div id="userbar-login">
            {{ Form::start(URL::to_route('login_post')) }}
                <input id="login-user" class="form-field" type="text" name="username" title="Username" placeholder="{{ __('front.login_username') }}"><input id="login-pass" class="form-field" type="password" name="password" title="Password" placeholder="{{ __('front.login_password') }}">
                <input id="login-submit" type="submit" value="{{ __('front.login_submit') }}">
            {{ Form::end() }}
        </div>
    </div>
    <div id="blogbar">
        <a href="">{{ __('front.link_register') }}</a>
    </div>
<?php endif; ?>