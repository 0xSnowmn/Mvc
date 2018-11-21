<?php

namespace Mvc\Lib;

trait Helper {
    public function Redirect($path = '/') {
        session_write_close();
            header('Location:' . $path);
        exit();
    }
}