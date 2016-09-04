<?php

include 'util/DBConn.php';
include 'dao/database/DbUsersDao.php';
include 'dao/CacheUsersDao.php';

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DaoFactory
 *
 * @author Ali
 */
class DaoFactory {

    private static $inst = null;

    /**
     * Call this method to get singleton
     *
     * @return UserFactory
     */
    public static function getInstance() {
        if (!self::$inst) {
            self::$inst = new self();
        }
        return self::$inst;
    }

    public function getUserList($conn, $redisConn) {
        $usersDao = new DbUsersDao($conn);
        $usersDao = new CacheUsersDao($usersDao, $redisConn);
        return $usersDao;
    }

}
