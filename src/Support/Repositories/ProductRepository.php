<?php

namespace Store\Support\Repositories;

class ProductRepository
{
    private $productModel;

    public function __construct()
    {
        $this->productModel = config('store.catalog.products.model');
    }

    // public function configurableOnly()
    // {
    //     return $this->model::configurableOnly();
    // }

    public function query()
    {
        return $this->productModel::query();
    }

    public function all($where = null)
    {
        return $this->productModel::where($where)->get();
    }

    public function getById($id)
    {
        return $this->productModel::find($id);
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
