<?php

namespace Mvc\Models;

class PrivilegeModel extends AbstractModel {
    public $PrivilegeId;
    public $PrivilegeTitle;
    public $Privilege;

    protected static $tableName = 'app_users_privileges';

    protected static $tableSchema = array(
        'PrivilegeId'       => self::DATA_TYPE_INT,
        'Privilege'         => self::DATA_TYPE_STR,
        'PrivilegeTitle'    => self::DATA_TYPE_STR
    );

    protected static $primaryKey = 'PrivilegeId';


}