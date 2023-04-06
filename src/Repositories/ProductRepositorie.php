<?php

namespace Basketin\Repositories;

class ProductRepositorie
{
    private $model;

    public function __construct()
    {
        $this->model = config('basketin.catalog.products.model');
    }

    public function all()
    {
        return $this->model::all();
    }

    public function getById($id)
    {
        return $this->model::find($id);
    }

    public function create($data)
    {
        return $this->model::create($data);
    }

    public function query()
    {
        return $this->model::query();
    }
}
