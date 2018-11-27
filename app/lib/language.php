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


    public function getDictionary() {
        return $this->_dic;
    }


}