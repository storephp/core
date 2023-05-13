<?php

namespace Store\Support\Traits;

trait HasSetupStore
{
    public function appendCommandToSetup($command)
    {
        config([
            'store.core.commands.installing' => array_merge([
                $command,
            ], config('store.core.commands.installing', [])),
        ]);
    }
}
