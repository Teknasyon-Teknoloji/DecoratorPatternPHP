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
 * We need a singleton class that holds the connection as one for each 
 * individual request, since we are to access same database and redis clients.
 * 
 * You will be available to access all methods of any interface that are defined
 * within the bounds of any interface by having an instance of them. 
 * 
 * Make sure that each your database and cache client classes implements the 
 * same interface.
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

    /**
     * Returns an object that has been decorated via Database and cache clients.
     * {@link DbUsersDao} is responsible of database queries, {@link CacheUsersDao}
     * caches the stream on Redis server. Keep in mind that, first initialized 
     * class has to be connected to a persistent storage for persistency.
     * 
     * @param type $conn
     * @param type $redisConn
     * @return \CacheUsersDao
     */
    public function getUsersDao($conn, $redisConn) {
        $usersDao = new DbUsersDao($conn);
        $usersDao = new CacheUsersDao($usersDao, $redisConn);
        return $usersDao;
    }
}
