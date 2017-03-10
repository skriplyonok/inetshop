<?php

abstract class System_Db_Table
{
    protected $_table;
    
    /**
     * 
     * @var PDO $_connection
     *  
     */
    protected $_connection;
    
    public function __construct()
    {
        $this->_connection = System_Registry::get('connection');
        
        $modelName = get_class($this);
        $arrExp = explode('_', $modelName);
        $tableName = strtolower($arrExp[count($arrExp) - 1]);
        $this->_table = $tableName;
    }
    
    public function getConnection()
    {
        return $this->_connection;
    }
    
    public function getTable()
    {
        return $this->_table;
    }
    
    public function getAll()
    {
        $sql    = 'select * from ' . $this->getTable();
        
        $sth    = $this->getConnection()->prepare($sql);
        
        $sth->execute();
        
        $result = $sth->fetchAll(PDO::FETCH_OBJ);
                       
        return $result;       
    }
    public function getById($id)
    {
        $sql    = 'select * from ' . $this->getTable() . ' where id = ?';
        
        $sth    = $this->getConnection()->prepare($sql);
        
        $sth->execute(array($id));
        
        $result = $sth->fetchAll(PDO::FETCH_OBJ);
               
        return $result;
    }
    
    /**
     * @param array $params
     * @return int 
     */
        public function create($params)
    {
        
        $arrayAllFields = array_keys($params);
        $arraySetFields = array();
        $arrayData = array();
        foreach($arrayAllFields as $field){
            if(!empty($params[$field]) && $field != 'route' && $field != 'save'){
                $arraySetFields[] = $field;
                if($field == 'password')
                {
                    $arrayData[] = sha1($params[$field]);
                } else {
                    $arrayData[] = $params[$field];
                }
            }
        }
        $forQueryFields =  implode(', ', $arraySetFields);
        $rangePlace = array_fill(0, count($arraySetFields), '?');
        $forQueryPlace = implode(', ', $rangePlace);
        
        try {
            $sth = $this->getConnection()->prepare('INSERT INTO ' . $this->getTable() . ' ('.$forQueryFields.') values ('.$forQueryPlace.')');

            $result = $sth->execute($arrayData);
            
        }catch(PDOException $e){
            echo 'Error : '.$e->getMessage();
            exit();
        }
        
        if($result)
        {
            return $this->getConnection()->lastInsertId();          
        }
    }
    
    public function update($params) 
    {

        $arrayAllFields = array_keys($params);
        $arraySetFields = array();
        $arrayData = array();
        foreach ($arrayAllFields as $field) {
            if (!empty($params[$field]) && $field != 'route' && $field != 'save' && $field != 'id') {
                $arraySetFields[] = $field;
                if ($field == 'password') {
                    $arrayData[] = sha1($params[$field]);
                } else {
                    $arrayData[] = $params[$field];
                }
            }
        }
        $arrayData[] = $params['id'];;
        $forQueryPlace = implode('=?, ', $arraySetFields);
        $forQueryPlace = $forQueryPlace . '=? where id=?';
        
   
        try {
            $sth = $this->getConnection()->prepare('update ' . $this->getTable() . ' set ' . $forQueryPlace);

            $result = $sth->execute($arrayData);
        } catch (PDOException $e) {
            echo 'Error : ' . $e->getMessage();
            exit();
        }
        return $result;  
    }
        
    public function delete($params)
    {
        $id = $params['id'];
        
        try {
            
            $sth = $this->getConnection()->prepare('delete from ' . $this->getTable() . ' where id=' . $id);
            $result = $sth->execute();
            
        } catch (PDOException $e) {
            echo 'Error : ' . $e->getMessage();
            exit();
        }

        return $result;
    }
}

