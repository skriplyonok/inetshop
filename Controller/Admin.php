<?php

class Controller_Admin extends System_Controller
{
    private $_mode = 0;
    
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
        $_mode = Model_User::MODE_INSERT;
    }
    public function updateAction()
    {
        $this->isAdmin();
        $_mode = Model_User::MODE_UPDATE;
        
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
        if($params['id'])
        {
            $_mode = Model_User::MODE_UPDATE;
        }

        
        //$params = $this->getParams();
        
        $userModel  = new Model_User();
        try {
            if($_mode === Model_User::MODE_UPDATE)
            {
                $userId     = $userModel->register($params, $_mode);
                        echo '<pre>';
        print_r($params);
        echo '</pre>';die;
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

