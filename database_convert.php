<?php

ini_set('MAX_EXECUTION_TIME', -1);

/**
 * Database converting script for 1337 Upload.
 * Running this via CLI enables you to convert previous
 * 1337 Upload tables to the new format. Fun.
 */

if (substr(php_sapi_name(), 0, 3) != 'cli') exit('Please run this from the command line.');

set_time_limit(0);

/**
 * Helpers
 */

class MicrotimeCounter
{
    private $start;

    public function start()
    {
        $this->start = microtime(true);
    }

    public function end($multiplier = 1000)
    {
        return (microtime(true) - $this->start) * $multiplier;
    }
}

function timestampToDatetime($timestamp)
{
    return date('Y-m-d H:i:s', $timestamp);
}

/**
 * CLI settings
 */

if ($argc < 7) exit('USAGE: php database_convert.php OLDUSERNAME OLDPASSWORD OLDDATABASE NEWUSERNAME NEWPASSWORD NEWDATABASE');

$origAddress = 'localhost';
$newAddress  = 'localhost';

$origUsername = $argv[1];
$origPassword = $argv[2];
$origDatabase = $argv[3];

$newUsername = $argv[4];
$newPassword = $argv[5];
$newDatabase = $argv[6];

/**
 * Databases
 */

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
    $new->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $new->query("SET wait_timeout=1200;");
}
catch (PDOException $e)
{
    exit('PDOException (2): '.$e->getMessage());
}

// All fine, let's start converting
$counter = new MicrotimeCounter;

/**
 * USERS
 */

echo '[STATUS] Converting users...'.PHP_EOL;
$counter->start();

$query = $old->prepare("SELECT * FROM leetup_users");
$query->execute();

$insertQuery = $new->prepare('INSERT INTO leet_users
    (id_user, id_group, id_inviter, user_username, user_hash, user_hash_prev, user_email, user_time_reg, user_time_act, user_avatar, user_ip, user_seen_blog, user_updated_pass, user_banned, user_ban_lifted)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())');

while ($row = $query->fetch(PDO::FETCH_OBJ))
{
    set_time_limit(0);
    if ($row->id <= 0) continue;

    $insertQuery->execute([
        $row->id,
        $row->rank,
        $row->inviter,
        $row->username,
        '',
        $row->password,
        $row->email,
        timestampToDatetime($row->regdate),
        timestampToDatetime($row->lastaction),
        $row->avatar,
        $row->lastip,
        $row->seenBlog,
        0,
        0
    ]);
}

echo '[STATUS] Users converted in ~'.$counter->end().' milliseconds.'.PHP_EOL;

/**
 * GROUPS
 */

echo '[STATUS] Converting groups...'.PHP_EOL;
$counter->start();

$query = $old->prepare("SELECT * FROM leetup_ranks");
$query->execute();

$insertQuery = $new->prepare('INSERT INTO leet_groups
    (id_group, group_name, group_colour, group_req_files, group_is_default, group_is_mod, group_is_admin, group_is_hidden)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)');

while ($row = $query->fetch(PDO::FETCH_OBJ))
{
    set_time_limit(0);
    if ($row->id <= 0) continue;

    $insertQuery->execute([
        $row->id,
        $row->rank_title,
        $row->rank_colour,
        $row->rank_upLimit,
        0,
        0,
        0,
        $row->hidden
    ]);

    /*$insertValues[] = "(
        {$row->id},
        '{$row->rank_title}',
        '{$row->rank_colour}',
        {$row->rank_upLimit},
        0,
        0,
        0,
        {$row->hidden}
    )";*/
}

/*$query = $new->prepare($insertQuery.implode(',', $insertValues));
$query->execute();*/
echo '[STATUS] Groups converted in ~'.$counter->end().' milliseconds.'.PHP_EOL;

/**
 * FILES
 */

echo '[STATUS] Converting files...'.PHP_EOL;
$counter->start();

$query = $old->prepare("SELECT * FROM leetup_files");
$query->execute();

$insertQuery = $new->prepare('INSERT INTO leet_files
    (id_file, id_user, file_name, file_size, file_type, file_downloads, file_is_hidden, file_upload_ip, file_upload_time, file_upload_name)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');

while ($row = $query->fetch(PDO::FETCH_OBJ))
{
    set_time_limit(0);
    if ($row->id <= 0) continue;

    $insertQuery->execute([
        $row->id,
        ($row->userid > 0) ? $row->userid : null,
        $row->filename,
        $row->filesize,
        '',
        $row->dls,
        $row->hidden,
        $row->upip,
        timestampToDatetime($row->uptime),
        ''
    ]);

    /*$insertValues[] = "(
        {$row->id},
        ".($row->userid > 0 ? $row->userid : 'NULL').",
        '{$row->filename}',
        {$row->filesize},
        '',
        {$row->dls},
        {$row->hidden},
        '{$row->upip}',
        '".timestampToDatetime($row->uptime)."',
        ''
    )";*/
}

/*$query = $new->prepare($insertQuery.implode(',', $insertValues));
$query->execute();*/
echo '[STATUS] Files converted in ~'.$counter->end().' milliseconds.'.PHP_EOL;