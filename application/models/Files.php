<?php

class Files
{
    public function getPaginated($where = array(), Array $order = [null, null], $perPage = 80)
    {
        $realOrder = ['file_upload_time', 'desc'];

        // Get the "real" order column
        switch (strtolower($order[0]))
        {
            case 'name':
                $realOrder[0] = 'file_name';
                break;
            case 'time':
                $realOrder[0] = 'file_upload_time';
                break;
            case 'uploader':
                $realOrder[0] = 'user_username';
                break;
            case 'downloads':
                $realOrder[0] = 'file_downloads';
                break;
        }

        // Get the "real" order direction
        switch (strtolower($order[1]))
        {
            case 'asc':
                $realOrder[1] = 'asc';
                break;
            case 'desc':
                $realOrder[1] = 'desc';
                break;
        }

        $query = DB::table('files')
            ->left_join('users', 'files.id_user', '=', 'users.id_user');

        foreach ($where as $line) $query->where($line[0], $line[1], $line[2]);

        $query->order_by($realOrder[0], $realOrder[1]);

        $return = $query->paginate($perPage);
        $return->order = $order;

        return $return;
    }

    /**
     * Marks which files should and should not be visible
     * to the given user.
     * Sets the value in $results[...]->hide
     */
    public function markVisibility($results, $user)
    {
        foreach ($results as &$file)
        {
            $file->hide = true;

            // If the file was not hidden in the first place,
            // it should always be visible.
            if (!$file->file_is_hidden) $file->hide = false;

            // If the file is hidden, only moderators and admins should
            // see it.
            if ($file->file_is_hidden)
            {
                if ($user && ($user->group_is_mod || $user->group_is_admin)) $file->hide = false;
            }
        }

        return $results;
    }
}