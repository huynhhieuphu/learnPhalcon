<?php

namespace App\Controllers;

use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Uniqueness;
use App\Models\Users;

use Phalcon\Flash\Direct as FlashDirect;

class TestController extends ControllerBase
{
    public $validation;
    public $user;

    public function initialize()
    {
        $this->validation = new Validation();
        $this->user = new Users();
    }

    public function indexAction()
    {
        $loginMsg = $this->session->get('LOGIN_MESSAGE');
        $this->session->remove('LOGIN_MESSAGE');

        $valiUser = $this->session->get('VALIDATION_USERNAME') ?? '';
        $this->session->remove('VALIDATION_USERNAME');

        $valiPass = $this->session->get('VALIDATION_PASSWORD') ?? '';
        $this->session->remove('VALIDATION_PASSWORD');

        $this->view->setVars(array(
           'valiUser' => $valiUser, 'valiPass' => $valiPass, 'loginMsg' => $loginMsg
        ));
    }

    public function loginAction()
    {
        $messages = null;
        if ($this->request->isPost()) {
            $this->validation->add(
                'username',
                new PresenceOf(
                    [
                        'message' => 'The username is required',
                    ]
                )
            );

            $this->validation->add(
                'password',
                new PresenceOf(
                    [
                        'message' => 'The password is required',
                    ]
                )
            );

            $messages = $this->validation->validate($_POST);

            if(count($messages)){
                //$this->session->set('LOGIN_MESSAGE', $messages);

                $fliterUser = $messages->filter('username');
                foreach ($fliterUser as $message) {
                    $this->session->set('VALIDATION_USERNAME', $message);
                }

                $fliterPass = $messages->filter('password');
                foreach ($fliterPass as $message) {
                    $this->session->set('VALIDATION_PASSWORD', $message);
                }

                $this->dispatcher->forward(
                    [
                        'controller' => 'test',
                        'action'     => 'index',
                    ]
                );
            }else{
                $username = $this->request->getPost('username') ?? '';
                $username = strip_tags($username);

                $password = $this->request->getPost('password') ?? '';
                $password = strip_tags($password);

                $check = $this->user->checkLogin($username, $password);

                if($check) {
                    //SESSION USER
                    $this->session->set('username', $check['username']);
//                    $this->dispatcher->forward(['controller' => 'test','action' => 'dashboard']);

                    $this->response->redirect('/test/dashboard');
                }else{
                    $this->session->set('LOGIN_MESSAGE', 'Login Fail');
                    $this->dispatcher->forward(['controller' => 'test','action' => 'index']);
                }
            }
        }
    }


    public function registerAction()
    {
        $loginMsg = $this->session->get('REGISTER_MESSAGE');
        $this->session->remove('REGISTER_MESSAGE');

        $valiUser = $this->session->get('VALIDATION_USERNAME') ?? '';
        $this->session->remove('VALIDATION_USERNAME');

        $valiPass = $this->session->get('VALIDATION_PASSWORD') ?? '';
        $this->session->remove('VALIDATION_PASSWORD');

        $this->view->setVars(array(
            'valiUser' => $valiUser,
            'valiPass' => $valiPass,
            'loginMsg' => $loginMsg
        ));
    }

    public function addAction()
    {
        if ($this->request->isPost()) {
            $this->validation->add(
                'username',
                new PresenceOf(
                    [
                        'message' => 'The username is required',
                    ]
                )
            );

            $this->validation->add(
                'username',
                new Uniqueness(
                    [
                        "model"   => new Users(),
                        "message" => ":field must be unique",
                    ]
                )
            );

            $this->validation->add(
                'password',
                new PresenceOf(
                    [
                        'message' => 'The password is required',
                    ]
                )
            );

            $messages = $this->validation->validate($_POST);

            if(count($messages)){
                $fliterUser = $messages->filter('username');
                foreach ($fliterUser as $message) {
                    $this->session->set('VALIDATION_USERNAME', $message);
                }

                $fliterPass = $messages->filter('password');
                foreach ($fliterPass as $message) {
                    $this->session->set('VALIDATION_PASSWORD', $message);
                }

                $this->dispatcher->forward(['controller' => 'test', 'action' => 'register']);
            }else{
                $username = $this->request->getPost('username') ?? '';
                $username = strip_tags($username);

                $password = $this->request->getPost('password') ?? '';
                $password = strip_tags($password);

                $this->user->username = $username;
                $this->user->password = $this->security->hash($password);

                if(!$this->user->save()) {
                    $this->session->set('REGISTER_MESSAGE', 'Register Fail');
                    $this->dispatcher->forward(['controller' => 'test','action' => 'register']);
                }else{
//                    return $this->dispatcher->forward(['controller' => 'test','action' => 'index']);
                    $this->response->redirect('/test');
                }

            }
        }
    }

    public function dashboardAction()
    {
        $keyword = $this->request->get('keywords') ?? '';

        $users = Users::find([
            'conditions' => "username LIKE '%{$keyword}%'",
            'columns' => 'id, username'
        ]);

        $this->view->users = $users->toArray();
    }

    public function logoutAction()
    {
        $this->session->remove('username');
        $this->response->redirect('/test');
    }
}
