<?php

namespace Mvc\Lib;

class Language {
    private $_dic = [];



    public function load($path) {
        $default_lang = DEFAULT_LANGUAGE;
        if(isset($_SESSION['lang'])) {
            $default_lang = $_SESSION['lang'];
        }
        $langPathFile = LANGUAGE_PATH . $default_lang . '/' . str_replace('|','/',$path) . '.lang.php';
        if(file_exists($langPathFile)) {
            require $langPathFile;
            if(is_array($_) && !empty($_)) {
                foreach($_ as $key => $value) {
                    $this->_dic[$key] = $value;
                }
            }  
        } else {
            trigger_error('Sorry Language File "' . $langPathFile . '" Not Found',E_USER_ERROR);
        }
       

    }

    public function get($key) {
        if(array_key_exists($key,$this->_dic)) {
            return $this->_dic[$key];
        }
    }

    public function feedKey($key,$data) {
        if(array_key_exists($key,$this->_dic)) {
            array_unshift($data,$this->_dic[$key]);
            return call_user_func_array('sprintf',$data);
        }
    }


    public function getDictionary() {
        return $this->_dic;
    }


}