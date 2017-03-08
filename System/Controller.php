<?php

abstract class System_Controller
{
    
    /**
     *
     * @var System_View
     */
    public $view;
    
    /**
     * 
     * @param array $args
     */
    //public $args;
    
    /**
     *
     * @var int
     */
    protected $_userId;


    public function setArgs($args)
    {
        $this->args = $args;
    }
    
    /**
     * 
     * @return array
     */
    public function getArgs()
    {
        $tempArgs = array();
        $count = count($this->args);
        for($i = 0; $i < $count - 1; $i += 2)
        {
            $tempArgs[$this->args[$i]] = $this->args[$i+1];
        }
        //$this->args=$tempArgs;
        return $tempArgs;
    }
    public function __construct() {
        session_start();
//        if( isset($_COOKIE[session_name()]) /*&& $this->_getSessParam('is_save')*/) {
//            setcookie(session_name(), session_id(), time() + Model_User::LIFETIME_USER_COOKIE, '/');
//        }
        $this->view = new System_View();
        $this->_userId = $this->_getSessParam('currentUser');
    }
    public function getParams()
    {
        return $_REQUEST;
    }
    /**
     * 
     * Save session's data
     * 
     * @param string $key
     * @param mixed $value
     */
    protected function _setSessParam($key, $value)
    {
        $_SESSION[$key] = $value;
    }
    /**
     * Retrieve data from session
     * 
     * @param string $key
     * @return mixed
     */
    protected function _getSessParam($key)
    {   
        if(!empty($_SESSION)) {
            return array_key_exists($key, $_SESSION) ? $_SESSION[$key] : NULL;
        }
        return NULL;
    }
    /**
     * 
     * @return int
     */
    public function getUserId() {
        return $this->_userId;
    }
    /**
     * 
     * @param type $key
     * @return mixed
     */
    public function getParamByKey($key)
    {
        return !empty($_REQUEST[$key]) ? $_REQUEST[$key] : NULL;
    }
    public function isAdmin()
    {
         $userRole = $this->_getSessParam('userRole');
        if($userRole == Model_User::ROLE_ADMIN) {
            
        }
        else {
            header('Location: /');
        }          
    }
    public function prepareParams()
    {
       $requestParams = $this->getParams();
       $params = [];
       foreach ($requestParams as $key => $value) {
           if( ($key != 'route') && ($key != 'MAX_FILE_SIZE') && ($key != 'insert') )
           {
               $params[$key] = $value;
           }
       }
       if(isset($params['skills']))
       {
           $params['skills'] = implode(',', $params['skills']);
       }
       

           $filePath = $this->loadFile();
           $params['photo'] = $filePath;

       
       return $params;
    }
    public function loadFile() {
        if(!$_FILES['photo']['name'])
        {
            return '';
        }
        $relativedir = 'upload' . DS;
        $relativefile = $relativedir . basename($_FILES['photo']['name']);
        $uploadfile = SITE_PATH . $relativefile;
        if (!(move_uploaded_file($_FILES['photo']['tmp_name'], $uploadfile))) {
            echo "Ошибка загрузки!\n";
        }
        return $relativefile;
    }

}
