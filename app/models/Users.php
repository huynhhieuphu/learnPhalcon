<?php
namespace App\Models;

use Phalcon\Mvc\Model;
use Phalcon\Security;

class Users extends Model
{
    protected $username;
    protected $password;

    public function initialize()
    {
        $this->setSource('users');
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    public function checkLogin($username, $password)
    {

//        $users = Users::find([
//            'username = :username: AND password = :password:',
//            'bind' => [
//                'username' => $username,
//                'password' => $password,
//            ]
//        ]);
//        return $users->toArray();

//        $users = Users::query()
//            ->where('username = :username:')
//            ->andWhere('password = :password:')
//            ->bind(['username' => $username, 'password' => $password])
//            ->execute();

        $user = Users::findFirst(
            [
                'conditions' => 'username = :username:',
                'bind'       => [
                    'username' => $username,
                ],
            ]
        );

        $security = new Security();
        if (false !== $user) {

            $check = $security->checkHash($password, $user->password);

            if (true === $check) {
                return true;
            }
        }
        return false;
    }

}