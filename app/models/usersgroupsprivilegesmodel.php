<?php

namespace Mvc\Models;

class UsersGroupsPrivilegesModel extends AbstractModel {
    public $Id;
    public $GroupId;
    public $PrivilegeId;

    protected static $tableName = 'app_users_groups_privileges';

    protected static $tableSchema = array(
        'Id'                => self::DATA_TYPE_INT,
        'GroupId'           => self::DATA_TYPE_INT,
        'PrivilegeId'       => self::DATA_TYPE_INT,
    );

    protected static $primaryKey = 'Id';

    public function getPrivileges($groupId) {
        $sql = 'SELECT augp.*, aup.Privilege FROM ' . self::$tableName . ' augp';
        $sql .= ' INNER JOIN app_users_privileges aup ON aup.PrivilegeId = augp.PrivilegeId';
        $sql .= ' WHERE augp.GroupId = ' . $groupId;
        $privileges = self::get($sql);
        $extractPrivileges = [];

        if(false != $privileges) {
            foreach($privileges as $privilege) {
                $extractPrivileges[] = $privilege->Privilege;
            }
        }
        return $extractPrivileges;
    }

}