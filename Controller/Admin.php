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

    public function saveAction()
    {
        $this->isAdmin();
      //  header('Content-Type: application/json');
        
        $params = $this->prepareParams();
        

        
        //$params = $this->getParams();
        
        $userModel  = new Model_User();
        try {
            $userId     = $userModel->register($params);
           
            //header('Location: /admin/insert');
           // die();
            $this->view->setParam('is_save', true);
        }
        catch(Exception $e) {
            $this->view->setParam('error', $e->getMessage());
        }
       
    }
}

