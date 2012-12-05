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

if ($argv < 7) exit('USAGE: php database_convert.php USERNAME PASSWORD DATABASE USERNAME2 PASSWORD2 DATABASE2');

$origAddress = 'dellingr.net';
$newAddress  = 'localhost';

$origUsername = $argc[1];
$origPassword = $argc[2];
$origDatabase = $argc[3];

$newUsername = $argc[1];
$newPassword = $argc[2];
$newDatabase = $argc[3];

// Try to connect to the first database
try
{
    $old = new PDO('mysql:host='.$origAddress.';dbname='.$origDatabase, $origUsername, $origPassword);
    $old->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $old->setAttribute(MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');
}
catch (PDOException $e)
{
    exit('PDOException: '.$e->getMessage());
}

// Try to connect to the second database
try
{
    $new = new PDO('mysql:host='.$newAddress.';dbname='.$newDatabase, $newUsername, $newPassword);
    $new->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $new->setAttribute(MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');
}
catch (PDOException $e)
{
    exit('PDOException: '.$e->getMessage());
}

// All fine, let's start converting
// USERS
$query = $old->prepare("SELECT * FROM leetup_users");
$query->execute();

$insertValues = array();
$insertQuery = 'INSERT INTO leet_users (id_user, id_group, id_inviter, user_username, user_hash, user_hash_prev, user_email, user_time_reg, user_time_act, user_avatar, user_ip, user_seen_blog, user_updated_pass, user_banned, user_ban_lifted) VALUES ';

while ($row = $query->fetch(PDO::FETCH_OBJ))
{
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