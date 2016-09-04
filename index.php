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

$factory = DaoFactory::getInstance();
$users = $factory
        ->getUserList($conn, $redis)
        ->listUsers();

echo json_encode($users);
