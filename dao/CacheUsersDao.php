<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CacheUsersDao
 * 
 * A specialized class that keeps connection to redis server, and handles 
 * all the requests by firstly checking redis server. If response is not cached
 * before, it uses previously sent $decorator object to access database.
 * 
 * As it fetches the data, then it firstly caches on Redis, and immediately 
 * returns the result set. In the case of the same result set is requested,
 * it fetches the cached data and returns.
 *
 * @author Ali
 */
class CacheUsersDao implements UsersDao {
    // A decorator object that holds database connection.
    private $decorator;
    
    // An object to access redis.
    private $redisConn;
    
    // A redis key to fetch all users value on server.
    private $ALL_USERS_REDIS_KEY = "test_users";
    
    // A redis key to fetch an user with a specified id.
    private $USER_BY_ID_REDIS_KEY = "test_user.id=";
    
    function __construct($decorator, $redisConn) {
        $this->decorator = $decorator;
        $this->redisConn = $redisConn;
    }
    
    /**
     * Returns the user which is specified by an id.
     * 
     * @param type $id
     * @return type
     */
    public function getUser($id) {
        $doesExist = $this->redisConn->exists($this->USER_BY_ID_REDIS_KEY.$id);
        
        if ($doesExist) {
            $value = $this->redisConn->get($this->USER_BY_ID_REDIS_KEY.$id);
            return $value;
        }
        
        $decoratorValue = $this->decorator->getUser($id);
        $this->redisConn->set($this->USER_BY_ID_REDIS_KEY.$id, json_encode($decoratorValue));
        
        return $decoratorValue;
    }

    /**
     * Returns list of users as an array.
     * 
     * @return type
     */
    public function listUsers() {
        $doesExist = $this->redisConn->exists($this->ALL_USERS_REDIS_KEY);
        
        if ($doesExist) {
            $value = $this->redisConn->get($this->ALL_USERS_REDIS_KEY);
            return $value;
        }
        
        $decoratorValue = $this->decorator->listUsers();
        $this->redisConn->set($this->ALL_USERS_REDIS_KEY, json_encode($decoratorValue));
        
        return $decoratorValue;
    }
}
