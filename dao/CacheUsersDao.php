<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CacheUsersDao
 *
 * @author Ali
 */
class CacheUsersDao implements UsersDao {
    //put your code here
    private $decorator;
    private $redisConn;
    
    function __construct($decorator, $redisConn) {
        $this->decorator = $decorator;
        $this->redisConn = $redisConn;
    }
    
    public function getUser($id) {
        $doesExist = $this->redisConn->exists("test_user.id=".$id);
        
        if ($doesExist) {
            $value = $this->redisConn->get("test_user.id=".$id);
            return $value;
        }
        
        $decoratorValue = $this->decorator->getUser($id);
        $this->redisConn->set("test_user.id=".$id, json_encode($decoratorValue));
        
        return $decoratorValue;
    }

    public function listUsers() {
        $doesExist = $this->redisConn->exists("test_users");
        
        if ($doesExist) {
            $value = $this->redisConn->get("test_users");
            return $value;
        }
        
        $decoratorValue = $this->decorator->listUsers();
        $this->redisConn->set("test_users", json_encode($decoratorValue));
        
        return $decoratorValue;
    }
}
