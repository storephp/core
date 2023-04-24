<?php

namespace Basketin\EAV\Traits;

trait HasStoreView
{
    private $storeViewId = null;

    /**
     * Get the value of storeViewId
     */
    public function getStoreViewId()
    {
        return $this->storeViewId;
    }

    /**
     * Set the value of storeViewId
     *
     * @return  self
     */
    public function setStoreViewId($storeViewId)
    {
        $this->storeViewId = $storeViewId;

        return $this;
    }
}
