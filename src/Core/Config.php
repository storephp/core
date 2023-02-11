<?php

namespace OutMart\Core;

use OutMart\Models\Config as ModelConfig;

class Config
{
    /**
     * Add new config
     *
     * @var $path <string>
     * @var $value <string>
     *
     */
    public function set($path, $value)
    {
        $config = ModelConfig::where('path', $path)->first();

        if ($config) {
            return $config->value;
        }

        $config = ModelConfig::create([
            'path' => $path,
            'value' => $value,
        ]);

        return $config->value;
    }

    /**
     * Get exist config
     */
    public function get($path, $deflut)
    {
        if ($config = ModelConfig::where('path', $path)->first()) {
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
