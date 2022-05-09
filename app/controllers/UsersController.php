<?php

namespace App\Controllers;

use App\Controllers\ControllerBase;
use App\Models\Users;
use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;

class UsersController extends ControllerBase
{
    public function indexAction()
    {

    }

    public function editAction($id)
    {
        $valiPass = $this->session->get('VALIDATION_PASSWORD');
        $this->session->remove('VALIDATION_PASSWORD');

        $user = Users::findFirst($id);
//        die(json_encode($user));
        $this->view->setVars([
            'user' => $user->toArray(),
            'valiPass' => $valiPass
        ]);
    }

    public function updateAction()
    {
        if ($this->request->isPost()) {
            $userId = $this->request->getPost('userId');
            $userId = is_numeric($userId) ? $userId : 0;
            $user = Users::findFirst($userId);

            if ($user) {
                $validation = new Validation();
                $validation->add('password', new PresenceOf(
                        [
                            'message' => 'The password is required',
                        ]
                    )
                );
                $messages = $validation->validate($_POST);

                if (count($messages)) {
                    $fliterPass = $messages->filter('password');
                    foreach ($fliterPass as $message) {
                        $this->session->set('VALIDATION_PASSWORD', $message);
                    }

                    $this->dispatcher->forward(
                        [
                            'controller' => 'users',
                            'action' => 'edit',
                            'id' => $userId
                        ]
                    );
                } else {
                    //update user
                    $user->setPassword($this->request->getPost('password'));
                    $updated = $user->update();

                    if ($updated) {
                        die('update success');
                    } else {
                        die('update fail');
                    }
                }
            } else {
                $this->response->redirect('found404');
            }
        }
    }

    public function deleteAction($id)
    {

    }
}