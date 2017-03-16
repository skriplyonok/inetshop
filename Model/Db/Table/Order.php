<?php

class Model_Db_Table_Order extends System_Db_Table
{
    /**
     * 
     * @param array $params
     * @param int $mode
     * @return array
     */
    public function checkIfExistsUser($params)
    {

        $sku      = trim($params['user_id']);
        
        $requestParams = array($sku);
        
        $sql = 'select * from `user` where id = ? ';

        $sth = $this->getConnection()->prepare($sql);
        $sth->execute($requestParams);
        $result = $sth->fetchAll(PDO::FETCH_OBJ);        
        
        return $result;
    }
}