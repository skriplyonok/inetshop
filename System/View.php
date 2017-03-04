<?php

class System_View
{
    /**
     *
     * @var array
     */
    private $_params = array();
    
    /**
     * 
     * @param string $key
     * @param mixed $value
     */
    public function setParam($key, $value)
    {
        $key = (string)$key;
        $this->_params[$key] = $value;
    }
    
    /**
     * 
     * @param string $key
     * @return mixed
     */
    public function getParam($key)
    {
        $key = (string)$key;
        return (!empty($this->_params[$key])) ? $this->_params[$key] : '';
    }
}

