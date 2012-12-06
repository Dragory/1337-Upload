<?php

class Files
{
    public function getPaginated($where = array(), $perPage = 80)
    {
        $query = DB::table('files');

        foreach ($where as $line) $query->where($line[0], $line[1], $line[2]);

        return $query->paginate($perPage);
    }
}