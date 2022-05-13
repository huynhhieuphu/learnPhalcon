<?php

namespace App\Controllers;


use App\Models\Categories;
use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Mvc\Model\Manager;

class CategoriesController extends ControllerBase
{
    const NOT_EXISTS_CHILD = 0;
    private $errName, $errParentId, $errStatus = null;

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
        $message_create = null;
        $cate_name = null;
        $cate_parent_id = null;
        $cate_status = null;

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
                    $this->errName = $message;
                }
                $filteredMessagesParentId = $messages->filter('parent_id');
                foreach ($filteredMessagesParentId as $message) {
                    $this->errParentId = $message;
                }
                $filteredMessagesStatus = $messages->filter('status');
                foreach ($filteredMessagesStatus as $message) {
                    $this->errStatus = $message;
                }
            } else {
                $category = new Categories();
                $category->setCategoryName($cate_name);
                $category->setCategoryParentId($cate_parent_id);
                $category->setCategoryStatus($cate_status);
                $category->setCategoryCreatedAt(time());// var_dump(date('Y-m-d H:i:s', time()));die;

//                ECHO "<PRE>";
//                var_dump($category->toArray());die;

                if (!$category->save()) {
                    $message_create = 'insert fail';
                } else {
                    $this->session->set('MESSAGE_CATEGORIES', 'Them thanh cong');
                    return $this->response->redirect('/categories/index');
                }
            }
        }

        $this->view->setVars([
            'select_categories' => $select_categories,
            'cate_name' => $cate_name,
            'cate_parent_id' => $cate_parent_id,
            'cate_status' => $cate_status,
            'errName' => $this->errName,
            'errParentId' => $this->errParentId,
            'errStatus' => $this->errStatus,
            'message_create' => $message_create
        ]);
    }

    public function editAction($id)
    {
        $select_categories = Categories::find();
        $select_categories = $select_categories->toArray();
        $self_category = Categories::findFirst($id);
        $category = $self_category->toArray();
        $message_update = null;
        $cate_name = null;
        $cate_parent_id = null;
        $cate_status = null;

        if (!$category) {
            $this->session->set('MESSAGE_CATEGORIES_ERR', 'Khong ton tai');
            return $this->response->redirect('/categories/index');
        }

        if($this->request->isPost()){
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
                    $this->errName = $message;
                }
                $filteredMessagesParentId = $messages->filter('parent_id');
                foreach ($filteredMessagesParentId as $message) {
                    $this->errParentId = $message;
                }
                $filteredMessagesStatus = $messages->filter('status');
                foreach ($filteredMessagesStatus as $message) {
                    $this->errStatus = $message;
                }
            }else{
                $self_category->setCategoryName($cate_name);
                $self_category->setCategoryParentId($cate_parent_id);
                $self_category->setCategoryStatus($cate_status);
                $self_category->setCategoryUpdatedAt(time());// var_dump(date('Y-m-d H:i:s', time()));die;

                if (!$self_category->save()) {
                    $message_update = 'update fail';
                } else {
                    $this->session->set('MESSAGE_CATEGORIES', 'Cap nhat thanh cong');
                    return $this->response->redirect('/categories/index');
                }
            }
        }

        //1652319320

        $this->view->setVars([
            'select_categories' => $select_categories,
            'category' => $category,
            'errName' => $this->errName,
            'errParentId' => $this->errParentId,
            'errStatus' => $this->errStatus,
            'message_update' => $message_update
        ]);
    }

    public function deleteAction($id)
    {
        $category = Categories::findFirst($id);
//        $count = Categories::count([
//            'parent_id = :parent_id:',
//            'bind'=>[
//                'parent_id' => $id
//            ]
//        ]);

        $sql = "SELECT count(*) AS count_child FROM App\Models\Categories WHERE parent_id = :parent_id:";
        $params = ['parent_id' => $id];
        $count = $this->modelsManager->executeQuery($sql,$params)->getFirst();

        if ($category !== false) {
            if((int) $count['count_child'] == self::NOT_EXISTS_CHILD) {
                if(!$category->delete()) {
                    $this->session->set('MESSAGE_CATEGORIES_ERR', 'Xoa that bai');
                    return $this->response->redirect('/categories/index');
                }else{
                    $this->session->set('MESSAGE_CATEGORIES', 'Xoa thanh cong');
                    return $this->response->redirect('/categories/index');
                }
            }else{
                $this->session->set('MESSAGE_CATEGORIES_ERR', 'Xoa that bai, ton tai con');
                return $this->response->redirect('/categories/index');
            }
        }
    }
}

