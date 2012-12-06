<?php

class Listing
{
    private function __construct() {}

    /**
     * Generates the query string to sort a listing
     * by a certain column.
     * 
     * The column doesn't (and really shouldn't) actually
     * match a database column. The conversion from the public
     * column name to the "real" one should be done in the model
     * in which the data is gotten (so a controller doesn't have
     * to know about the database column names). A controller should
     * pass the input value to the model, though.
     */
    public static function order($column, $direction = null)
    {
        // Get previous values (if any)
        $page = Input::get('page');
        $col  = Input::get('order');
        $dir  = Input::get('dir');

        // If we're sorting by the same column as previously,
        // invert the direction.
        if ($col == $column)
        {
            if ($dir == null || $dir == 'DESC') $dir = 'ASC';
            else $dir = 'DESC';
        }
        // Otherwise default to ascending
        else
        {
            $dir = 'ASC';
        }

        // If we had a direction specified, use that
        // instead of whatever was decided above.
        if ($direction) $dir = $direction;

        // Set the new column (if it was changed)
        $col = $column;

        // Return the query string
        return http_build_query(['page' => $page, 'order' => $col, 'dir' => $dir]);
    }
}