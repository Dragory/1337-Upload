<h1>Update your password</h1>
<p>
    Along with the rewrite of the website's backend, we changed the way we store passwords in our system.
    <br>
    The new method should be significantly safer than the previous one.
    <br><br>
    However, we can't update existing passwords automatically. We only have their crypted versions, which can not be decrypted easily.
    <br>
    So, to update your profile to the new system, we need you to enter your previous password, or a new one, that we can then store in the new format.
</p>
{{ Form::start(URL::to_route('legacy_password_post')) }}
    <p>
        <label for="password_prev">Your current password</label><br>
        <input class="form-field" type="password" name="password_prev">
        <br><br>
        <label for="password_new">Your new password</label><br>
        <input class="form-field" type="password" name="password_new">
        <br><br>
        <label for="password_new2">Your new password again</label><br>
        <input class="form-field" type="password" name="password_new2">
        <br><br>
        <input type="submit" value="Update my password">
    </p>
{{ Form::end() }}