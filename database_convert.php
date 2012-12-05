<?php

/**
 * Database converting script for 1337 Upload.
 * Running this via CLI enables you to convert previous
 * 1337 Upload tables to the new format. Fun.
 */

if (substr(php_sapi_name(), 0, 3) != 'cli') exit('Please run this from the command line.');

function timestampToDatetime($timestamp)
{
    return date('Y-m-d H:i:s', $timestamp);
}

if ($argc < 7) exit('USAGE: php database_convert.php OLDUSERNAME OLDPASSWORD OLDDATABASE NEWUSERNAME NEWPASSWORD NEWDATABASE');

$origAddress = 'localhost';
$newAddress  = 'localhost';

$origUsername = $argv[1];
$origPassword = $argv[2];
$origDatabase = $argv[3];

$newUsername = $argv[4];
$newPassword = $argv[5];
$newDatabase = $argv[6];

// Try to connect to the first database
try
{
    $old = new PDO('mysql:host='.$origAddress.';dbname='.$origDatabase, $origUsername, $origPassword, array(
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
    ));
    $old->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e)
{
    exit('PDOException (1): '.$e->getMessage());
}

// Try to connect to the second database
try
{
    $new = new PDO('mysql:host='.$newAddress.';dbname='.$newDatabase, $newUsername, $newPassword, array(
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
    ));
    $new->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e)
{
    exit('PDOException (2): '.$e->getMessage());
}

// All fine, let's start converting
// USERS
echo '[STATUS] Converting users...'.PHP_EOL;
$query = $old->prepare("SELECT * FROM leetup_users");
$query->execute();

$insertValues = array();
$insertQuery = 'INSERT INTO leet_users (id_user, id_group, id_inviter, user_username, user_hash, user_hash_prev, user_email, user_time_reg, user_time_act, user_avatar, user_ip, user_seen_blog, user_updated_pass, user_banned, user_ban_lifted) VALUES ';

while ($row = $query->fetch(PDO::FETCH_OBJ))
{
    if ($row->id <= 0) continue;

    $insertValues[] = "(
        {$row->id},
        {$row->rank},
        {$row->inviter},
        '{$row->username}',
        '',
        '{$row->password}',
        '{$row->email}',
        '".timestampToDatetime($row->regdate)."',
        '".timestampToDatetime($row->lastaction)."',
        '{$row->avatar}',
        '{$row->lastip}',
        {$row->seenBlog},
        0,
        0,
        NOW()
    )";
}

$query = $new->prepare($insertQuery.implode(',', $insertValues));
$query->execute();
echo '[STATUS] Users converted.'.PHP_EOL;

// GROUPS
echo '[STATUS] Converting groups...'.PHP_EOL;
$query = $old->prepare("SELECT * FROM leetup_ranks");
$query->execute();

$insertValues = array();
$insertQuery = 'INSERT INTO leet_groups (id_group, group_name, group_colour, group_req_files, group_default, group_is_mod, group_is_admin, group_hidden) VALUES ';

while ($row = $query->fetch(PDO::FETCH_OBJ))
{
    if ($row->id <= 0) continue;

    $insertValues[] = "(
        {$row->id},
        '{$row->rank_title}',
        '{$row->rank_colour}',
        {$row->rank_upLimit},
        0,
        0,
        0,
        {$row->hidden}
    )";
}

$query = $new->prepare($insertQuery.implode(',', $insertValues));
$query->execute();
echo '[STATUS] Groups converted.'.PHP_EOL;

