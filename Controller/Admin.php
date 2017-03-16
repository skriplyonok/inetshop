<?php

class Controller_Admin extends System_Controller
{

    public function __construct($action = '') {
        parent::__construct();
        $this->isAdmin();
        if($action)
        {   
            $this->_tableName = substr($action, 0, -6);
            $this->_modelName = 'Model_' . ucfirst($this->_tableName);
        }
    }
    public function indexAction()
    {
        
    }
       
    public function selectAction()
    {          
        try {
            $modelName = $this->_modelName;
            $all = $modelName :: getAll();
            $this->view->setParam('all', $all);
            $this->view->setParam('table', $this->_tableName);
        }
        catch(Exception $e) {
            $this->view->setParam('error', $e->getMessage());
        }
    }
       
    public function insertAction()
    {     
            $this->view->setParam('table', $this->_tableName);
    }
    public function updateAction()
    {
        
        $args = $this->getArgs();
        $id = $args['id'];
        
        try {
            $modelName = $this->_modelName;
            $model = $modelName :: getById($id);
            $this->view->setParam('model', $model);
            $this->view->setParam('table', $this->_tableName);
        }
        catch(Exception $e) {
            $this->view->setParam('error', $e->getMessage());
        }
    }

    public function saveAction()
    {
            
        if($this->_tableName == 'order')
        {
            $params = $this->getParams();
        }else{
            $params = $this->prepareParams();
        }
               
        $modelName = $this->_modelName;
        $model = new $modelName();
        
        $update = array_key_exists('update', $this->getParams()) ? true : false;
        try {
            if ($update) {
                $this->view->setParam('mode', Model_User::MODE_UPDATE);
                $id = $model->register($params, Model_User::MODE_UPDATE);
            } else {
                $this->view->setParam('mode', Model_User::MODE_INSERT);
                $id = $model->register($params);
            }
            $this->view->setParam('is_save', true);
        } catch (Exception $e) {
            $this->view->setParam('error', $e->getMessage());
        }
        $this->view->setParam('table', $this->_tableName);
       
    }
    
    public function deleteAction() 
    {

        $params = $this->getParams();
        
        $table = $this->_tableName;
        $modelName = 'Model_Db_Table_' . ucfirst($this->_tableName);
        $model  = new $modelName();
        try {
            
            $result = $model->delete($params);
            
            if($result)
            {
                echo json_encode(array('result' => 'Удалено!', 'table' => $table));
                die(); 
            }
            throw new Exception('Ошибка!');
        }
        catch(Exception $e) {
            echo json_encode(array('error' => $e->getMessage()));
            die();
        }
    }
    
}

