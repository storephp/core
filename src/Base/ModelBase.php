<?php

namespace Store\Base;

use Illuminate\Database\Eloquent\Model;

abstract class ModelBase extends Model
{
    /**
     * Create a new instance of the Model.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if ($connection = ModelConnection::getConnection()) {
            $this->setConnection($connection);
        }

        $this->setTable(config('store.database.table_prefix') . $this->getTable());
    }
}
