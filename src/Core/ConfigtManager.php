<?php

namespace OutMart\Core;

use OutMart\Models\Config as ModelConfig;

class ConfigtManager
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

    /**
     * Add new config
     *
     * @var $path <string>
     * @var $value <string>
     *
     */
    public function set($path, $value)
    {
        if ($config = ModelConfig::where('store_view_id', $this->getStoreViewId())->where('path', $path)->first()) {
            return $config->value;
        }

        if ($config = ModelConfig::whereNull('store_view_id')->where('path', $path)->first()) {
            return $config->value;
        }

        $config = ModelConfig::create([
            'store_view_id' => $this->getStoreViewId(),
            'path' => $path,
            'value' => $value,
        ]);

        return $config->value;
    }

    /**
     * Get exist config
     */
    public function get($path, $deflut = null)
    {
        if ($config = ModelConfig::where('store_view_id', $this->getStoreViewId())->where('path', $path)->first()) {
            return $config->value;
        }

        if ($config = ModelConfig::whereNull('store_view_id')->where('path', $path)->first()) {
            return $config->value;
        }

        if ($overwriteConfig = $this->overwrite($path)) {
            return $overwriteConfig;
        }

        return $deflut;
    }

    /**
     * Update exist config
     */
    public function put($path, $value)
    {
        $config = ModelConfig::where('path', $path)->first();

        if ($config) {
            $config->value = $value;
            $config->save();

            return $config->value;
        }

        return null;
    }

    private function overwrite($path)
    {
        return config('outmart.core.config.' . $path);
    }
}
