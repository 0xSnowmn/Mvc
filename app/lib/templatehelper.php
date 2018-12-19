<?php

namespace Mvc\Lib;

trait TemplateHelper {
    public function showValue($input,$object = null) {
        return isset($_POST[$input]) ? $_POST[$input] : is_null($object) ? '' : $object->$input;
    }
    public function labelFloat($fieldName, $object = null)
    {
        return isset($_POST[$fieldName]) && !empty($_POST[$fieldName]) || (null !== $object && $object->$fieldName !== null) ? ' class="floated"' : '';
    }
}
