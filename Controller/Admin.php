<?php

class Controller_Admin extends System_Controller
{
    
    public function indexAction()
    {
        $this->isAdmin();
    }
    public function userAction()
    {
        $this->isAdmin();
        try {
            $allUser = Model_User :: getAllUser();
            $this->view->setParam('allUser', $allUser);
        }
        catch(Exception $e) {
            $this->view->setParam('error', $e->getMessage());
        }
    }
    public function insertAction()
    {
        $this->isAdmin();
    }
    public function updateAction()
    {
        $this->isAdmin();
        
        $args = $this->getArgs();
        $userId = $args['id'];
       
        try {
            $modelUser = Model_User :: getById($userId);
            $this->view->setParam('user', $modelUser);
        }
        catch(Exception $e) {
            $this->view->setParam('error', $e->getMessage());
        }
    }

    public function saveAction()
    {
        $this->isAdmin();
        

        
        $params = $this->prepareParams();
        
        //$params = $this->getParams();
        
        $userModel  = new Model_User();
        try {
            if(!empty($params['id']))
            {
                $userId     = $userModel->register($params, Model_User::MODE_UPDATE);
            }else{
                $userId     = $userModel->register($params);
            }
           
            $this->view->setParam('is_save', true);
        }
        catch(Exception $e) {
            $this->view->setParam('error', $e->getMessage());
        }
       
    }
}

