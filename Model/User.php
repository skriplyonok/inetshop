<?php
class Model_User
{
    /**
     * Register mode
     */
    const MODE_REGISTER = 1;
    const MODE_LOGIN = 2;
    const ROLE_ADMIN = 5;
    /**
    *Cookie lifetime;
    */
    const LIFETIME_USER_COOKIE = 3600;
     /**
     *
     * @var int 
     */
    public  $id;
    
    /**
     *
     * @var string 
     */
    public  $name;
    
    /**
     *
     * @var string 
     */
    public  $lastName;
    
    /**
     *
     * @var string 
     */
    public  $email;
    
    /**
     *
     * @var string
     */
    private $_password;
    
    /**
     *
     * @var string
     */
    public  $photo;
    
    /**
     *
     * @var int
     */
    public  $role_id;
    
    /**
     *
     * @var int
     */   
    public  $isActive;
    
    /**
     *
     * @var string
     */   
    public  $skills;
    
    /**
     *
     * @var int
     */   
    public  $year;
    /**
     * 
     * @param int $userId
     * @return Model_User
     * @throws Exception
     */
    public static function getById($userId)
    {
        $dbUser     =  new Model_Db_Table_User();
        $userData = $dbUser->getById($userId)[0];
        //$userData   =  !empty($userData[0]) ? array_shift($dbUser->getById($userId)) : '';
        
        if(!empty($userData)) {
            $modelUser  = new self();
            $modelUser->name       = $userData->first_name;
            $modelUser->id          = $userData->id;
            $modelUser->email       = $userData->email;
            //$modelUser->photo       = $userData->photo;
            $modelUser->role_id     = $userData->role_id;

            return $modelUser;
        }
        else {
            throw new Exception('User not found', System_Exception::NOT_FOUND);
        }
    }
    public static function getAllUser()
    {
        $dbUser     =  new Model_Db_Table_User();
        $userData = $dbUser->getAllUser();
        
        if(!empty($userData))
        {
            $allUser = [];
            foreach ($userData as $key => $value) {
                $allUser[$key]  = new self();
                $allUser[$key]->id          = $value->id;
                $allUser[$key]->name       = $value->first_name;
                $allUser[$key]->lastName       = $value->last_name;
                $allUser[$key]->email       = $value->email;                
                $allUser[$key]->isActive       = $value->is_active; 
                $allUser[$key]->skills       = $value->skills; 
                $allUser[$key]->role_id     = $value->role_id;                
                $allUser[$key]->year     = $value->year;                
                $allUser[$key]->photo       = $value->photo;            
            }
            return $allUser;
        }
    }
    /**
     * 
     * @param array $params
     * @throws Exception
     */
    public function register($params)
    {
        if(!$this->_validate($params))
        {
            throw new Exception('The entered data is invalid', System_Exception::VALIDATE_ERROR);
        }
        
        $tableUser = new Model_Db_Table_User();
   
        $resIfExists = $tableUser->checkIfExists($params);
        
        if(!empty($resIfExists)) {
            throw new Exception('Such account is already exists.', System_Exception :: ALREADY_EXISTS);
        }
        else {
            $resCreate = $tableUser->create($params);

            if(!$resCreate) {
                throw new Exception('Can\'t create new user. Try later.', System_Exception :: ERROR_CREATE_USER);
            }
            return $resCreate;
        }
    }
    
    /**
     * 
     * @param array $params
     * @return boolean
     */
    private function _validate($params)
    {
        $login      = !empty($params['email']) ? $params['email'] : '';
        $password   = !empty($params['password']) ? $params['password'] : '';
        
        
        if(!$password || !$login) {
            return false;
        }
        if(strlen($login > 20)) {
            return false;
        }
        if (!filter_var($login, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        return true;
    }
    
     /**
     * 
     * @param array $params
     * @return int userId
     * @throws Exception
     */
    public function login($params)
    {
        if(!$this->_validate($params))
        {
            throw new Exception('The entered data is invalid', System_Exception::VALIDATE_ERROR);
        }
        $tableUser = new Model_Db_Table_User();
        
        $res = $tableUser->checkIfExists($params, Model_User::MODE_LOGIN);
                      
        if(!empty($res)) {
            $user = reset($res);
            return $user; 
        }
        else {
            throw new Exception('Invalid user or password.', System_Exception::INVALID_LOGIN);
        }
    }
}