<?php
namespace Mvc\Lib;

trait Validate {
/**
 * @var
 */
  private $_pattern = [
      'num'         => '/^[0-9]+(?:\.[0-9]+)?$/',
      'int'         => '/^[0-9]+$/',
      'float'       => '/^[0-9]+\.[0-9]+$/',
      'alpha'       => '/^[a-z\p{Arabic}]+$/ui',
      'alphanum'    => '/^[a-z\p{Arabic}0-9 ]+$/ui',
      'email'       => '/^([\w\-\.]+)@((\[([0-9]{1,3}\.){3}[0-9]{1,3}\])|(([\w\-]+\.)+)([a-zA-Z]{2,4}))$/',
      'url'         => '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/'
  ];

  public function req($value) {
    return '' != $value || !empty($value) ;
  }
  public function num($value) {
    return (bool) preg_match($this->_pattern['num'],$value);
  }
  public function int($value) {
    return (bool) preg_match($this->_pattern['int'],$value);
  }
  public function float($value) {
    return (bool) preg_match($this->_pattern['float'],$value);
  }
  public function alpha($value) {
    return (bool) preg_match($this->_pattern['alpha'],$value);
  }
  public function alphanum($value) {
    return (bool) preg_match($this->_pattern['alphanum'],$value);
  }
  public function lt($value,$num) {
    if(is_string($value)) {
      return mb_strlen($value) < $num;
    } elseif(is_numeric($value)) {
            return $value < $num;
      } 
  }
  public function gt($value,$num) {
    if(is_string($value)) {
      return mb_strlen($value) > $num;
   } elseif(is_numeric($value)) {
          return $value > $num;
    }
  }
  public function min($value,$min) {
    if(is_string($value)) {
      return mb_strlen($value) >= $min;
    } elseif(is_numeric($value)) {
          return $value >= $min;
    } 
  }
  public function max($value,$max) {
    if(is_string($value)) {
      return mb_strlen($value) <= $max;
    } elseif(is_numeric($value)) {
     return $value <= $max;
    }
  }
  public function between($value,$min,$max) {
    if(is_string($value)) {
        return mb_strlen($value) >= $min && mb_strlen($value) <= $max;;
    } elseif(is_numeric($value)) {
      return $value >= $min && $value <= $max;
    } 
  }
  public function eq($value,$val2) {
    return $value == $val2;
  }
  public function eq_input($value,$val2) {
    return $value == $val2;
  }
  public function email($value) {
    return (bool) preg_match($this->_pattern['email'],$value);
  }
  public function url($value) {
    return (bool) preg_match($this->_pattern['url'],$value);
  }

  public function Valid($roles,$type) {
    $errors = [];
      if(!empty($roles)) {
        foreach($roles as $input => $role) {
          $value = $type[$input];
          $v_roles = explode('|',$role);
          foreach($v_roles as $v_role) {
            if(preg_match_all('/(min)\((\d+)\)/',$v_role,$m)) {
              if(!$this->min($value,$m[2][0])) {
                $this->messenger->add(
                  $this->language->feedKey('text_error_' . $m[1][0],[$this->language->get('text_label_' . $input),$m[2][0]])
                  ,MESSAGE_ERROR);
                  $errors[$input] = true;
              }
            } elseif(preg_match_all('/(max)\((\d+)\)/',$v_role,$m)) {
              if(!$this->max($value,$m[2][0])) {
                $this->messenger->add(
                  $this->language->feedKey('text_error_' . $m[1][0],[$this->language->get('text_label_' . $input),$m[2][0]])
                  ,MESSAGE_ERROR);
                  $errors[$input] = true;
              }
            }
            elseif(preg_match_all('/(lt)\((\d+)\)/',$v_role,$m)) {
              if(!$this->lt($value,$m[2][0])) {
                $this->messenger->add(
                  $this->language->feedKey('text_error_' . $m[1][0],[$this->language->get('text_label_' . $input),$m[2][0]])
                  ,MESSAGE_ERROR);
                  $errors[$input] = true;
              }
            }
            elseif(preg_match_all('/(gt)\((\d+)\)/',$v_role,$m)) {
              if(!$this->gt($value,$m[2][0])) {
                $this->messenger->add(
                  $this->language->feedKey('text_error_' . $m[1][0],[$this->language->get('text_label_' . $input),$m[2][0]])
                  ,MESSAGE_ERROR);
                  $errors[$input] = true;
              }
            }
            elseif(preg_match_all('/(between)\((\d+),(\d+)\)/',$v_role,$m)) {
              if(!$this->between($value,$m[2][0],$m[3][0])) {
                $this->messenger->add(
                  $this->language->feedKey('text_error_' . $m[1][0],[$this->language->get('text_label_' . $input),$m[2][0], $m[3][0]])
                  ,MESSAGE_ERROR);
                  $errors[$input] = true;
              }
            } elseif(preg_match_all('/(eq)\((\w+),(\w+)\)/',$v_role,$m)) {
              if(!$this->eq($value,$m[2][0],$m[3][0])) {
                $this->messenger->add(
                  $this->language->feedKey('text_error_' . $m[1][0],[$this->language->get('text_label_' . $input),$m[2][0], $m[3][0]])
                  ,MESSAGE_ERROR);
                  $errors[$input] = true;
              }
            } elseif(preg_match_all('/(eq_input)\((\w+)/',$v_role,$m)) {
              if(!$this->eq_input($value,$type[$m[2][0]])) {
                $this->messenger->add(
                  $this->language->feedKey('text_error_' . $m[1][0],[$this->language->get('text_label_' . $input),$m[2][0]])
                  ,MESSAGE_ERROR);
                  $errors[$input] = true;
              }
            } else {
              if(!$this->$v_role($value)) {
                $this->messenger->add(
                  $this->language->feedKey('text_error_' . $v_role,[$this->language->get('text_label_' . $input)])
                  ,MESSAGE_ERROR);
                $errors[$input] = true;
              }
            }
          }
        }
      }
      return empty($errors) ? true : false;
  }
}
