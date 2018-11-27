<?php

namespace Mvc\Controllers;

use Mvc\Lib\Helper;


class LanguageController extends AbstractController {
    use Helper;
    public function defaultAction() {
        
        if($_SESSION['lang'] == 'ar') {
            $_SESSION['lang'] = 'en';
        } else {
            $_SESSION['lang'] = 'ar';
        }
            
        $this->Redirect('/');
    }


}