<?php
class Model_Order
{
     /**
     *
     * @var int 
     */
    public  $id;
    
    /**
     *
     * @var int 
     */
    public  $user_id;
    
    /**
     *
     * @var string 
     */
    public  $date;
    
    /**
     *
     * @var float 
     */
    public  $sum;
          
    /**
     * 
     * @param mixed $id
     * @return Model_
     * @throws Exception
     */
    public static function getById($id)
    {
        $db     =  new Model_Db_Table_Order();
        $data = $db->getById($id)[0];
        
        if(!empty($data)) {
            $model  = new self();
            $model->id = $data->id;
            $model->user_id = $data->user_id;
            $model->date = $data->date;
            $model->sum = $data->sum;   

            return $model;
        }
        else {
            throw new Exception('Not found', System_Exception::NOT_FOUND);
        }
    }
    
    public static function getAll()
    {
        $db     =  new Model_Db_Table_Order();
        $data = $db->getAll();
               
        if(!empty($data))
        {
            $all = [];
            foreach ($data as $key => $value) {
                $all[$key] = new self();
                $all[$key]->id = $value->id;
                $all[$key]->user_id = $value->user_id;
                $all[$key]->date = $value->date;
                $all[$key]->sum = $value->sum;
            }
            return $all;
        }
    }
    /**
     * 
     * @param array $params
     * @throws Exception
     */
    public function register($params, $mode = Model_User::MODE_INSERT)
    {   
        
        $table = new Model_Db_Table_Order();

        $resIfExists = $table->checkIfExistsUser($params);           
   
        if(empty($resIfExists)) {
            throw new Exception('Such user is not exists.', System_Exception :: ALREADY_EXISTS);
        }
        else {
            if($mode === Model_User::MODE_UPDATE)
            {
                $res = $table->update($params);
            }else{
                $res = $table->create($params);   
            }
            
            if(!$res) {
                throw new Exception('Can\'t create\update order. Try later.', System_Exception :: ERROR_CREATE_USER);
            }
            return $res;
        }
    }
//    /**
//     * 
//     * @param array $params
//     * @return boolean
//     */
//    private function _validate($params)
//    {
//        $sku      = !empty($params['SKU']) ? $params['SKU'] : '';
//        if(!$sku) {
//            return false;
//        }
//        return true;
//    }
}

