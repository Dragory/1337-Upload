<?php

class Front_Controller extends Base_Controller
{
    protected $currentUser = null;
    public $layout = '__layout';

    public function __contruct()
    {
        $auth = new Authentication;
        $users = new Users;

        $id_user = $auth->getCurrentUser();
        if ($id_user != null) $this->currentUser = $users->getUser($id_user);

        $this->layout->nest('header',  '__header');  // Logo, search, menu
        $this->layout->nest('userbar', '__userbar', ['user' => $this->currentUser]); // User actions, login, blog, etc.
        $this->layout->nest('footer',  '__footer');  // Credits, quick links, etc.

        $this->layout->nest('status',  '__status', Status::getMessages(true)); // Status messages i.e. errors, successes and possibly other messages too
    }

    /**
     * The index/landing page for users that
     * are not logged in.
     */
    public function action_index()
    {
        // Only allow users to access this page if they are not logged in
        if ($this->currentUser != null) return Redirect::to_route('upload');
    }

    /**
     * The "Upload" page
     */
    public function action_upload()
    {
        // Only allow logged in users to access this
        if ($this->currentUser == null) return Redirect::to_route('index');

        $this->layout->nest('content', 'upload');
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