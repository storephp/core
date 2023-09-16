<?php

namespace Store\Support\Repositories;

class ProductRepository
{
    private $productModel;

    public function __construct()
    {
        $this->productModel = config('store.catalog.products.model');
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
        return $this->productModel::whereSku($sku)->first();
    }

    public function create(array $data = [], array $eavData = [])
    {
        $created = $this->productModel::create($data);

        foreach ($eavData as $key => $value) {
            $created->{$key} = $value;
        }

        $created->save();

        return $created;
    }
}
