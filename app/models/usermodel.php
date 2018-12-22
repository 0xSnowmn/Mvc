<?php

namespace Mvc\Models;

class UserModel extends AbstractModel {
    public $UserId;
    public $Username;
    public $Password;
    public $Email;
    public $PhoneNumber;
    public $SubscriptionDate;
    public $LastLogin;
    public $GroupId;
    public $Status;
    /**
     * @var UserProfileModel
     */
    public $profile;
    public $privileges;
    protected static $tableName = 'app_users';
    protected static $tableSchema = array(
        'UserId'            => self::DATA_TYPE_INT,
        'Username'          => self::DATA_TYPE_STR,
        'Password'          => self::DATA_TYPE_STR,
        'Email'             => self::DATA_TYPE_STR,
        'PhoneNumber'       => self::DATA_TYPE_STR,
        'SubscriptionDate'  => self::DATA_TYPE_DATE,
        'LastLogin'         => self::DATA_TYPE_STR,
        'GroupId'           => self::DATA_TYPE_INT,
        'Status'            => self::DATA_TYPE_INT,
    );
    protected static $primaryKey = 'UserId';

    public function cryptPass($password) {
      $password = crypt($password,SALT);
       return $password;
    }

    public static function getUsers(UserModel $user) {
        return SELF::get(
            'SELECT au.*,aug.GroupName AS GroupName From ' . self::$tableName . ' au INNER JOIN app_users_groups aug on aug.GroupId = au.GroupId WHERE au.UserId != ' . $user->UserId
        );
    }

    public static function UserExists($username) {
        return self::getBy(['Username' => $username]);
    }
    public static function EmailExists($email) {
        return self::getBy(['Username' => $email]);
    }

    public static function auth($username,$pass,$session) {
        $pass = self::cryptPass($pass);
        //$found = self::getBy(['Username' => $username ,'Password' => $pass]);
        $sql = 'SELECT *, (SELECT GroupName FROM app_users_groups WHERE app_users_groups.GroupId = ' . self::$tableName . '.GroupId) GroupName From ' . self::$tableName .  ' WHERE Username = "' . $username . '" AND Password = "' .  $pass . '"';
        $foundUser = self::getOne($sql);
        if(false !== $foundUser) {
            if($foundUser->Status == 2) {
                return 2;
            }
            $foundUser->LastLogin = date('Y-m-d H:i:s');
            $foundUser->save();
            $foundUser->profile = UsersProfileModel::getByPK($foundUser->UserId);
            $foundUser->privileges = UsersGroupsPrivilegesModel::getPrivileges($foundUser->GroupId);
            $session->u = $foundUser;
            return 1;
        }
        return false;
    }
}