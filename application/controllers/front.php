<?php

class Front_Controller extends Base_Controller
{
    protected $currentUser = null;
    public $layout = '__layout', $title = [];

    public function __construct()
    {
        parent::__construct();

        $auth = new Authentication;
        $users = new Users;

        $id_user = $auth->getCurrentUser();
        if ($id_user != null) $this->currentUser = $users->getUser($id_user);

        $this->title = ['1337 Upload'];
        $this->layout->user = $this->currentUser;
    }

    protected function loadPage($view, Array $title = null, $data = null)
    {
        if ($title)
            foreach ($title as $part)
                $this->title[] = $part;

        $this->layout->title = implode(' &raquo; ', $this->title);

        $this->layout->nest('header',  '__header',  ['user' => $this->currentUser]);  // Logo, search, menu
        $this->layout->nest('userbar', '__userbar', ['user' => $this->currentUser]); // User actions, login, blog, etc.
        $this->layout->nest('footer',  '__footer');  // Credits, quick links, etc.

        $this->layout->nest('status',  '__status', Status::getMessages(true)); // Status messages i.e. errors, successes and possibly other messages too

        $this->layout->nest('content', $view, $data);
    }

    public function action_login_post()
    {
        $username   = Input::get('username');
        $password   = Input::get('password');
        $stayLogged = (Input::get('stayLogged') ? true : false);

        if (!$username || !$password)
        {
            Status::addError(__('error.login_empty_fields'));
            return Redirect::to_route('index');
        }

        $auth = new Authentication;
        $login = $auth->login($username, $password, $stayLogged);

        if ($login)
        {
            Status::addSuccess(__('success.login_successful'));
            return Redirect::to_route('upload');
        }
        else
        {
            Status::addError(__('error.login_failed'));
            return Redirect::to_route('index');
        }
    }

    /**
     * The index/landing page for users that
     * are not logged in.
     */
    public function action_index()
    {
        // Only allow users to access this page if they are not logged in
        if ($this->currentUser != null) return Redirect::to_route('upload');

        $this->loadPage('index');
    }

    /**
     * The "Upload" page
     */
    public function action_upload()
    {
        // Only allow logged in users to access this
        if ($this->currentUser == null) return Redirect::to_route('index');

        // Prompt the user to update their password to the new "method"
        if ($this->currentUser && !$this->currentUser->user_updated_pass) return Redirect::to_route('legacy_password');

        $this->loadPage('upload');
        // $this->layout->nest('content', 'upload');
    }

    /**
     * The "Blog" page
     */
    public function action_blog()
    {

    }

    /**
     * The file listing page (called "Files" in the menu).
     * If no ID is passed, this should show files from all users.
     */
    public function action_filelist($id = 0)
    {
        $files = new Files;

        // If we're getting the files of a specific
        // user, get those.
        if ($id > 0)
            $list = $files->getPaginated([
                ['id_user', '=', intval($id)]
            ],
            [Input::get('order'), Input::get('dir')]);
        // Otherwise go for all of them.
        else
            $list = $files->getPaginated([], [Input::get('order'), Input::get('dir')]);

        // Make sure the pagination links have the sorting column and direction
        $list->appends(['order' => Input::get('order'), 'dir' => Input::get('dir')]);

        // Check which files we should hide from the viewer
        $list->results = $files->markVisibility($list->results, $this->currentUser);

        $this->loadPage('filelist', ['File listing'], array('files' => $list));
    }

    /**
     * The "Support" page
     */
    public function action_support()
    {

    }

    /**
     * The "Misc" page
     */
    public function action_misc($subPage = null)
    {

    }

    /**
     * The "Profile" page.
     * If no ID is passed, get the current user's profile.
     * If the current user is not logged in, return to index.
     */
    public function action_profile($id = 0)
    {

    }

    /**
     * Profile editing. No ID -> current user.
     * No login -> return to index.
     * No permissions -> return to index.
     */
    public function action_profile_edit($id = 0)
    {

    }

    /**
     * The post action for saving a profile's information.
     * This includes passwords, E-Mails, avatars and even ranks.
     */
    public function action_profile_edit_post($id = 0)
    {

    }

    /**
     * The "Messages" page
     */
    public function action_messages()
    {

    }

    public function action_messages_read($id = null)
    {

    }

    public function action_messages_send()
    {

    }

    public function action_messages_send_post()
    {

    }

    /**
     * The "Search" page
     */
    public function action_search($string = null)
    {
        
    }
}