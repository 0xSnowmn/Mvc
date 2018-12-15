<?php

namespace Mvc\Lib;

class Template {
    protected $tpl_parts;
    protected $view;
    protected $data;
    protected $_registry;

    public function __construct(array $parts) {
        $this->tpl_parts = $parts;
    }

    public function __get($key)
    {
        return $this->_registry->$key;
    }

    public function setView($v) {
        $this->view = $v;
    }

    public function setData($dat) {
        $this->data = $dat;
    }

    public function setRegistry($registry) {
        $this->_registry = $registry;
    }

    public function renderTplStart() {
        extract($this->data);
        require_once TEMPLATE_PATH . 'tpl_start.php';
    }
    public function renderTplBody() {
        extract($this->data);
        require_once TEMPLATE_PATH . 'b_start.php';
    }
    public function renderTplEnd() {
        extract($this->data);
        require_once TEMPLATE_PATH . 'tpl_end.php';
    }

    public function render_Tpl() {
        if(!array_key_exists('tpl',$this->tpl_parts)) {
            echo 'not Found';
        } else {
            $parts = $this->tpl_parts['tpl'];
            if(!empty($parts)) {
                extract($this->data);
                foreach($parts as $part => $file) {
                    if($part == ':view') {
                        require_once $this->view;
                    } else {
                       
                            require_once $file;
                        
                    }
                }
            }
        }
    }

        public function render_h_srcs() {
            $output = '';
            $srcs = $this->tpl_parts['H_srcs'];

            // Css
            $css = $srcs['CSS'];

            if(!empty($css)) {
                foreach($css as $key => $file) {
                    $output .= '<link rel="stylesheet" href="' . $file . '">';
                }
            }

            // Css
            $js = $srcs['JS'];

            if(!empty($js)) {
                foreach($js as $key => $file) {
                    $output .= '<script src="'.  $file . '"></script>';
                }
            }
            echo $output;
        }
        public function render_F_srcs() {
            $output = '';
            if(!array_key_exists('F_srcs',$this->tpl_parts)) {
                trigger_error('Not Found Files',E_USER_WARNING);
            } else {
                $srcs = $this->tpl_parts['F_srcs'];
                // JS 
                
                if(!empty($srcs)) {
                    foreach($srcs as $src => $path) {
                                $output .= '<script src="'.  $path . '"></script>';
                        }
                    }
                }
                
                echo $output;
            }
        public function render() {
            extract($this->data);
            ob_start();
            $this->renderTplStart();
            $this->render_h_srcs();
            $this->renderTplBody();
            $this->render_Tpl();
            $this->render_F_srcs();
            $this->renderTplEnd();
            ob_get_contents();
            ob_flush();
        }
    }

