<?php

namespace Basketin\EAV\Contracts;

interface MultipleStoreViews
{
    /**
     * Get the value of storeViewId
     */
    public function getStoreViewId();

    /**
     * Set the value of storeViewId
     *
     * @return  self
     */
    public function setStoreViewId($storeViewId);
}
