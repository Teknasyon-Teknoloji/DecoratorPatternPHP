<?php

include 'interfaces/UsersDao.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author Ali
 */
class DbUsersDao implements UsersDao {

    private $dbConn;

    function __construct($dbConn) {
        $this->dbConn = $dbConn;
    }

    public function getUser($id) {
        $sql = "SELECT * FROM users WHERE ID='" . $id . "'";
        $result = $this->dbConn->query($sql);
        return mysql_fetch_row($result);
    }

    public function listUsers() {
        $results = array();
        $query = $this->dbConn->query("SELECT * FROM users");
        
        while ($row = $query->fetch_assoc()) {
            array_push($results, $row);
        }
        
        return $results;
    }

}
