<?php

namespace Basketin\Support\Traits;

trait HasSetupBasketin
{
    public function appendCommandToSetup($command)
    {
        config([
            'basketin.core.commands.installing' => array_merge([
                $command,
            ], config('basketin.core.commands.installing', [])),
        ]);
    }
}
