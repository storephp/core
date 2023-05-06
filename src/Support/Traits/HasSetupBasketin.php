<?php

namespace Store\Support\Traits;

trait HasSetupBasketin
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
