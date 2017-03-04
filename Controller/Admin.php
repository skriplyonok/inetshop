<?php

class Controller_Admin extends System_Controller
{
    public function indexAction()
    {
        $userRole = $this->_getSessParam('userRole');
        if($userRole == Model_User::ROLE_ADMIN) {
            
        }
        else {
            header('Location: /');
        }       
    }
    public function userAction(){
        try {
            $allUser = Model_User :: getAllUser();
            $this->view->setParam('allUser', $allUser);
        }
        catch(Exception $e) {
            $this->view->setParam('error', $e->getMessage());
        }
    }
    public function insertAction(){}

    public function saveAction()
    {
      //  header('Content-Type: application/json');
      
        $params = $this->getParams();
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

