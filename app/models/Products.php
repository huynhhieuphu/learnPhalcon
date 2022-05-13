<?php


namespace App\Models;

use Phalcon\Mvc\Model;

class Products extends Model
{
    protected $id, $name, $category_id, $status, $price, $created_at, $updated_at;

    public function initialize()
    {
        $this->setSource('products');
    }

    public function getProductId()
    {
        return $this->id;
    }

    public function setProductId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getProductName()
    {
        return $this->name;
    }

    public function setProductName($name)
    {
        $this->name = $name;
//        return $this;
    }

    public function getProductCategory()
    {
        return $this->category_id;
    }

    public function setProductCategory($category_id)
    {
        $this->category_id = $category_id;
        return $this;
    }

    public function getProductPrice()
    {
        return $this->price;
    }

    public function setProductPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    public function getProductStatus()
    {
        return $this->status;
    }

    public function setProductStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    public function getProductCreatedAt()
    {
        return $this->created_at;
    }

    public function setProductCreatedAt($created_at)
    {
        $this->created_at = $created_at;
        return $this;
    }

    public function getProductUpdatedAt()
    {
        return $this->updated_at;
    }

    public function setProductUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
        return $this;
    }

}