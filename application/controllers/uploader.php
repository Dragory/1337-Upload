<?php

Class Uploader_Controller extends Base_Controller
{
    public function action_upload()
    {
        return json_encode(['success' => true]);
    }
}