<?php


namespace App\Controllers;

use App\Controllers\ControllerBase;
use App\Models\Products;
use App\Models\Categories;
use App\Validations\CreateProductPost;

class ProductsController extends ControllerBase
{
    private $products;
    private $categories;
    private $errName, $errCategory, $errStatus, $errPrice;
    private $pro_name, $pro_category, $pro_status, $pro_price;

    public function initialize()
    {
        $this->products = new Products();
        $this->categories = new Categories();
    }

    public function indexAction()
    {
        $sql = "SELECT p.*, c.name as category_name 
                FROM App\Models\Products AS p
                INNER JOIN App\Models\Categories AS c ON p.category_id = c.id";
        $products = $this->modelsManager->executeQuery($sql);

        $data = [];
        foreach ($products as $product) {
            $data[] = array_merge($product->p->toArray(), array('category_name' => $product->category_name));
        }

        $msgProductOk = $this->session->get('MSG_PRODUCTS_OK');
        $this->session->remove('MSG_PRODUCTS_OK');
        $msgProductErr = $this->session->get('MSG_PRODUCTS_ERR');
        $this->session->remove('MSG_PRODUCTS_ERR');

        $this->view->setVars([
            'msgProductOk' => $msgProductOk,
            'msgProductErr' => $msgProductErr,
            'products' => $data
        ]);
    }

    public function createAction()
    {
        $select_categories = $this->categories->find(['conditions'=>'status = 1']);
        $select_categories = $select_categories->toArray();
        $msgProductErr = null;

        if ($this->request->isPost()) {
            $validation = new CreateProductPost();
            $messages = $validation->validate($_POST);

            $this->pro_name = $this->request->getPost('name');
            $this->pro_category = $this->request->getPost('category_id');
            $this->pro_price = $this->request->getPost('price');
            $this->pro_status = $this->request->getPost('status');

            if (count($messages)) {
                $filteredMsgName = $messages->filter('name');
                foreach ($filteredMsgName as $message) {
                    $this->errName = $message;
                }

                $filteredMsgPrice = $messages->filter('price');
                foreach ($filteredMsgPrice as $message) {
                    $this->errPrice = $message;
                }

                $filteredMsgCate = $messages->filter('category_id');
                foreach ($filteredMsgCate as $message) {
                    $this->errCategory = $message;
                }

                $filteredMsgStatus = $messages->filter('status');
                foreach ($filteredMsgStatus as $message) {
                    $this->errStatus = $message;
                }
            } else {
                $this->products->setProductName($this->pro_name);
                $this->products->setProductCategory($this->pro_category);
                $this->products->setProductStatus($this->pro_status);
                $this->products->setProductPrice($this->pro_price);
                $this->products->setProductCreatedAt(time());

                if (!$this->products->save()) {
                    $msgProductErr = 'Them san pham that bai!!!';
                } else {
                    $this->session->set('MSG_PRODUCTS_OK', 'Them san pham thanh cong!!!');
                    return $this->response->redirect('/products/index');
                }
            }
        }

        $this->view->setVars([
            'select_categories' => $select_categories,
            'msgProductErr' => $msgProductErr,
            'errName' => $this->errName,
            'errCategory' => $this->errCategory,
            'errPrice' => $this->errPrice,
            'errStatus' => $this->errStatus,
            'oldName' => $this->pro_name,
            'oldCate' => $this->pro_category,
            'oldStatus' => $this->pro_status,
            'oldPrice' => $this->pro_price
        ]);
    }

    public function editAction()
    {
        $select_categories = $this->categories->find(['conditions'=>'status = 1']);
        $select_categories = $select_categories->toArray();

        $this->view->setVars([
            'select_categories' => $select_categories,
        ]);
    }

    public function deleteAction($id)
    {
        $product = $this->products->findFirst($id);
        if ($product !== false) {
            if(!$product->delete()) {
                $this->session->set('MSG_PRODUCTS_ERR', 'Xoa that bai');
                return $this->response->redirect('/products/index');
            }

            $this->session->set('MSG_PRODUCTS_OK', 'Xoa thanh cong');
            return $this->response->redirect('/products/index');
        }
    }

}