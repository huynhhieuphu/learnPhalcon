<?php
namespace App\Models;

use Phalcon\Mvc\Model;

class Categories extends Model
{
    protected $id, $name, $parent_id, $status, $created_at, $updated_at;

    public function initialize()
    {
        $this->setSource('categories');
    }

    public function getCategoryId()
    {
        return $this->id;
    }

    public function setCategoryId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getCategoryName()
    {
        return $this->id;
    }

    public function setCategoryName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getCategoryParentId()
    {
        return $this->parent_id;
    }

    public function setCategoryParentId($parent_id)
    {
        $this->parent_id = $parent_id;
        return $this;
    }

    public function getCategoryStatus()
    {
        return $this->status;
    }

    public function setCategoryStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    public function getCategoryCreatedAt()
    {
        return $this->created_at;
    }

    public function setCategoryCreatedAt($created_at)
    {
        $this->created_at = $created_at;
        return $this;
    }

    public function getCategoryUpdatedAt()
    {
        return $this->created_at;
    }

    public function setCategoryUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
        return $this;
    }
}