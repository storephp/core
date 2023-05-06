<?php

namespace Store\Support\Repositories;

class ProductRepository
{
    private $model;

    public function __construct()
    {
        $productModel = config('store.catalog.products.model');
        $this->model = new $productModel;
    }

    public function configurableOnly()
    {
        return $this->model::configurableOnly();
    }

    public function query()
    {
        return $this->model::query();
    }

    public function all()
    {
        return $this->model->get();
    }

    public function getById($id)
    {
        return $this->model->find($id);
    }

    public function getBySku($sku)
    {
        return $this->model->where('sku', $sku)->first();
    }

    public function create($data)
    {
        return $this->model->create($data);
    }
}
