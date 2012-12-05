<?php

/**
 * Database converting script for 1337 Upload.
 * Running this via CLI enables you to convert previous
 * 1337 Upload tables to the new format. Fun.
 */

if (substr(php_sapi_name(), 0, 3) != 'cli') exit('Please run this from the command line.');

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
    $db1 = new PDO('mysql:host='.$origAddress.';dbname='.$origDatabase, $origUsername, $origPassword);
    $db1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db1->setAttribute(MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');
}
catch (PDOException $e)
{
    exit('PDOException: '.$e->getMessage());
}

// Try to connect to the second database
try
{
    $db2 = new PDO('mysql:host='.$newAddress.';dbname='.$newDatabase, $newUsername, $newPassword);
    $db2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db2->setAttribute(MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');
}
catch (PDOException $e)
{
    exit('PDOException: '.$e->getMessage());
}

// All fine, let's start converting
