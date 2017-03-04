<?php

abstract class System_Db_Table
{
   // protected $_name;
    
    /**
     * 
     * @var PDO $_connection
     *  
     */
    protected $_connection;
    
    public function __construct()
    {
        $this->_connection = System_Registry::get('connection');
    }
    
    public function getConnection()
    {
        return $this->_connection;
    }
    public function getName()
    {
        return $this->_name;
    }
}

