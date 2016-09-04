<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
include 'util/DBConn.php';
include 'util/RedisConn.php';
include 'util/DaoFactory.php';

/**
 * Get Factory instance as singleton. Since we will use this factory 
 * once and for every single request.
 */
$factory = DaoFactory::getInstance();

/**
 * We specify which objects' source would like to access to. In the case of 
 * getUser($id) is desired, just pass that method accordingly.
 */
$users = $factory
        ->getUsersDao($conn, $redis)
        ->listUsers();

/**
 * Show the result as encoded in json.
 */
echo json_encode($users);
