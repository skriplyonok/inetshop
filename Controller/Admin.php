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
        $params = $this->getParams();
        
        echo '<pre>';
        print_r($_FILES);
        echo '</pre>';die;    
        $userModel  = new Model_User();
        try {
            $userId     = $userModel->register($params);
            $userData = array(
                'id'    =>  $userId,
                'email' =>  trim($params['email'])
            );
           
            echo json_encode($userData);
            die();
        }
        catch(Exception $e) {
            echo json_encode(array('error' => $e->getMessage()));
            die();
        }
       
    }
}

