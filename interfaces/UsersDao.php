<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of newPHPClass
 *
 * @author Ali
 */
interface UsersDao {
    //put your code here
    public function listUsers();
    
    public function getUser($id);
}
