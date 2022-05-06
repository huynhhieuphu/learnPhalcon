<?php
namespace App\Controllers;

use App\Models\Users;
use Phalcon\Assets\Manager;

class TestController extends ControllerBase
{
    public function indexAction()
    {

    }

    public function loginAction()
    {
        if ($this->request->isPost()) {
            $username = $this->request->getPost('username');
            $username = strip_tags($username);

            $password = $this->request->getPost('password');
            $password = strip_tags($password);

            $user = new Users();
            $check = $user->checkLogin($username, $password);

            var_dump($check);
        }
    }

    public function registerAction()
    {

    }

    public function addAction()
    {
        if ($this->request->isPost()) {
            // Access POST data
            $username = $this->request->getPost('username');
            $username = strip_tags($username);

            $password = $this->request->getPost('password');
            $password = strip_tags($password);


            $user = new Users();
            $success = $user->addUser($username, $password);

            var_dump($success);die;
        }
    }
}
