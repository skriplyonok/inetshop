<?php

class Controller_Product extends System_Controller
{
    public function __construct($action = '')
    {
        parent::__construct();
        if($action)
        {   
            $this->_tableName = substr($action, 0, -6);
            $this->_modelName = 'Model_' . ucfirst($this->_tableName);
        }
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
    
}

