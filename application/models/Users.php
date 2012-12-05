<?php

class Users
{
    public function getUser($id)
    {
        return DB::table('users')
            ->where('id_user', '=', intval($id))
            ->left_join('groups', 'users.id_group', '=', 'groups.id_group')
            ->first();
    }
}