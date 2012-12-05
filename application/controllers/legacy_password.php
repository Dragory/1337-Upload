<?php

/**
 * This controller handles the page that asks the
 * user to update their password from the previous "format"
 * (sha1(strtolower($username).$password)) to the new one
 * (password_hash()).
 */

class Legacy_Password_Controller extends Base_Controller
{
    protected $currentUser = null;
    public $layout = 'legacy_password.__layout';

    public function __construct()
    {
        parent::__construct();

        $auth = new Authentication;
        $users = new Users;

        $id_user = $auth->getCurrentUser();
        if ($id_user) $this->currentUser = $users->getUser($id_user);

        $this->layout->nest('status',  '__status', Status::getMessages(true));
    }

    public function action_index()
    {
        if ($this->currentUser == null) return Redirect::to_route('index');

        $this->layout->nest('content', 'legacy_password.index');
    }

    public function action_post()
    {
        if ($this->currentUser == null) return Redirect::to_route('index');

        $password_prev = Input::get('password_prev');
        $password_new  = Input::get('password_new');
        $password_new2 = Input::get('password_new2');

        if (!$password_prev || !$password_new || !$password_new2)
        {
            Status::addError('error.legacy_password_missing_fields');
            return Redirect::to_route('legacy_password');
        }

        $auth = new Authentication;
        $check = $auth->checkLegacyPassword($this->currentUser->user_username, $password_prev);

        if (!$check)
        {
            Status::addError('error.legacy_password_incorrect_legacy_password');
            return Redirect::to_route('legacy_password');
        }

        if ($password_new != $password_new2)
        {
            Status::addError('error.legacy_password_incorrect_match');
            return Redirect::to_route('legacy_password');
        }

        $auth->changePassword($this->currentUser->id_user, $password_new);

        Status::addSuccess('success.legacy_password_change_successful');
        Redirect::to_route('upload');
    }
}