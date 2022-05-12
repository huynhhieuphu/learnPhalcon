<?php

namespace App\Controllers;


use App\Models\Categories;
use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;

class CategoriesController extends ControllerBase
{

    public function indexAction()
    {
        $categories = Categories::find();
        $categories = $categories->toArray();

        $msgCategories = $this->session->get('MESSAGE_CATEGORIES');
        $this->session->remove('MESSAGE_CATEGORIES');
        $msgCategoriesErr = $this->session->get('MESSAGE_CATEGORIES_ERR');
        $this->session->remove('MESSAGE_CATEGORIES_ERR');

        $this->view->setVars([
            'categories' => $categories,
            'msgCategories' => $msgCategories,
            'msgCategoriesErr' => $msgCategoriesErr
        ]);
    }

    public function createAction()
    {
        $msgValiName = null;
        $msgValiParentId = null;
        $msgValiStatus = null;
        $message_create = null;

        $select_categories = Categories::find(['conditions' => 'status = 1']);
        $select_categories = $select_categories->toArray();

        if ($this->request->isPost()) {
            $cate_name = $this->request->getPost('name');
            $cate_name = strip_tags($cate_name);
            $cate_parent_id = $this->request->getPost('parent_id');
            $cate_parent_id = strip_tags($cate_parent_id);
            $cate_status = $this->request->getPost('status');
            $cate_status = strip_tags($cate_status);

            $validation = new Validation();
            $validation->add(['name'], new PresenceOf());
            $validation->add(['parent_id'], new PresenceOf());
            $validation->add(['status'], new PresenceOf());

            $messages = $validation->validate($_POST);

            if (count($messages)) {
                $filteredMessagesName = $messages->filter('name');
                foreach ($filteredMessagesName as $message) {
                    $msgValiName = $message;
                }
                $filteredMessagesParentId = $messages->filter('parent_id');
                foreach ($filteredMessagesParentId as $message) {
                    $msgValiParentId = $message;
                }
                $filteredMessagesStatus = $messages->filter('status');
                foreach ($filteredMessagesStatus as $message) {
                    $msgValiStatus = $message;
                }
            } else {
                $category = new Categories();
                $category->setCategoryName($cate_name);
                $category->setCategoryParentId($cate_parent_id);
                $category->setCategoryStatus($cate_status);
                $category->setCategoryCreatedAt(time());// var_dump(date('Y-m-d H:i:s', time()));die;

                if (!$category->save()) {
                    $message_create = 'insert fail';
                } else {
                    $this->session->set('MESSAGE_CATEGORIES', 'Them thanh cong');
                    $this->response->redirect('/categories/index');
                }
            }
        }

        $this->view->setVars([
            'select_cate' => $select_categories,
            'cate_name' => $cate_name,
            'cate_parent_id' => $cate_parent_id,
            'cate_status' => $cate_status,
            'errName' => $msgValiName,
            'errParentId' => $msgValiParentId,
            'errStatus' => $msgValiStatus,
            'message_create' => $message_create
        ]);
    }

    public function editAction($id)
    {
        $category = Categories::findFirst($id);

        if (!$category) {
            $this->session->set('MESSAGE_CATEGORIES_ERR', 'Khong ton tai');
            $this->response->redirect('/categories/index');
        } else {

        }

        $this->view->setVars([

        ]);
    }

    public function deleteAction()
    {

    }
}

