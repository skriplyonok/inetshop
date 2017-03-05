<?php

class Model_Db_Table_User extends System_Db_Table
{
    protected $_name = 'user';
    
    public function getById($id)
    {
        $sql    = 'select * from ' . $this->getName() . ' where id = ?';
        
        $sth    = $this->getConnection()->prepare($sql);
        
        $sth->execute(array($id));
        
        $result = $sth->fetchAll(PDO::FETCH_OBJ);
               
        return $result;
    }
    public function getAllUser()
    {
        $sql    = 'select * from ' . $this->getName();
        
        $sth    = $this->getConnection()->prepare($sql);
        
        $sth->execute();
        
        $result = $sth->fetchAll(PDO::FETCH_OBJ);
                       
        return $result;       
    }
    /**
     * @param array $params
     * @return int 
     */
    public function create($params)
    {
        
//        if ($params['photo']) {
//            $uploaddir = '/upload/';
//            $uploadfile = $uploaddir . basename($_FILES['photo']['name']);
//            $params['photo'] = $uploadfile;
//            if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
//                echo "Файл успешно загружен.\n";
//            } else {
//                echo "Ошибка загрузки!\n";
//            }
 //       }
        
        $arrayAllFields = array_keys($params);
        $arraySetFields = array();
        $arrayData = array();
        foreach($arrayAllFields as $field){
            if(!empty($params[$field]) && $field != 'route'){
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
            $sth = $this->getConnection()->prepare('INSERT INTO ' . $this->getName() . ' ('.$forQueryFields.') values ('.$forQueryPlace.')');

            $result = $sth->execute($arrayData);

        }catch(PDOException $e){
            echo 'Error : '.$e->getMessage();
            exit();
        }
         
        return $result;
    }
    /**
     * 
     * @param array $params
     * @param int $mode
     * @return array
     */
    public function checkIfExists($params, $mode = Model_User::MODE_REGISTER)
    {
        $login      = trim($params['email']);
        $password   = trim($params['password']);
        
        $requestParams = array($login);
        
        $sql = 'select * from ' . $this->getName() . ' where email = ? ';
        if($mode == Model_User::MODE_LOGIN) {
            $sql .= 'AND password = ?';
            array_push($requestParams, sha1($password));
        }
        
        /**
         * @var PDOStatement $sth 
         */
        $sth = $this->getConnection()->prepare($sql);
        $sth->execute($requestParams);
        $result = $sth->fetchAll(PDO::FETCH_OBJ);        
        
        return $result;
    }
    
}