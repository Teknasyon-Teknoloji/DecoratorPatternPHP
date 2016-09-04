<?php

include 'interfaces/UsersDao.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * A simple sql query class that does querying to MySQL server.
 * This class is used as a decorator under {@link DaoFactory} as a persistence
 * provider. If object is not found on redis, than 
 * 
 * @author Ali
 */
class DbUsersDao implements UsersDao {

    // An object that keeps connection to sql server.
    private $dbConn;
    private $BASE_QUERY = "SELECT * FROM users";

    function __construct($dbConn) {
        $this->dbConn = $dbConn;
    }

    /**
     * Queries database for the user that's been specified with an id parameter.
     * 
     * @param type $id
     * @return type
     */
    public function getUser($id) {
        // Construct the query string.
        $sql = $this->BASE_QUERY . " WHERE ID='" . $id . "'";
        
        // Perform query.
        $result = $this->dbConn->query($sql);
        
        // Returns a single row.
        return mysql_fetch_row($result);
    }

    /**
     * 
     *  
     * @return array
     */
    public function listUsers() {
        $results = array();
        
        // Perform query.
        $query = $this->dbConn->query($this->BASE_QUERY);
        
        // Add each row onto array.
        while ($row = $query->fetch_assoc()) {
            array_push($results, $row);
        }

        // Returns resultset.
        return $results;
    }

}
