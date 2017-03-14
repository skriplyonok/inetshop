<?php

class Model_Db_Table_Product extends System_Db_Table
{
    /**
     * 
     * @param array $params
     * @param int $mode
     * @return array
     */
    public function checkIfExists($params)
    {

        $sku      = trim($params['SKU']);
        
        $requestParams = array($sku);
        
        $sql = 'select * from ' . $this->getTable() . ' where SKU = ? ';

        $sth = $this->getConnection()->prepare($sql);
        $sth->execute($requestParams);
        $result = $sth->fetchAll(PDO::FETCH_OBJ);        
        
        return $result;
    }
}