<?php

namespace Mvc\Lib;

trait InputFilter{ 

public function filt_str($str) {
    return htmlentities(strip_tags(filter_var($str,FILTER_SANITIZE_STRING)),ENT_QUOTES,'UTF-8');
}

public function filt_int($int) {
    return filter_var($int,FILTER_SANITIZE_NUMBER_INT);
}

public function filt_float($int) {
    return filter_var($int,FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
}
    
}
