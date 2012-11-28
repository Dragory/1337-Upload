<?php

class Profile_Controller extends Base_Controller
{
    protected $currentUser = null;
    public $layout = '__layout';

    public function __contruct()
    {
        $this->layout->nest('menu', '__menu');     // The main menu
        $this->layout->nest('header', '__header'); // User actions, login, blog, etc.
        $this->layout->nest('footer', '__footer'); // Credits, quick links, etc.
    }

    public function action_profile($id = 0)
    {

    }

    public function action_profile_edit($id = 0)
    {

    }
}