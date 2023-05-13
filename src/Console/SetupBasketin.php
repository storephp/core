<?php

namespace Basketin\Console;

use Illuminate\Console\Command;

class SetupBasketin extends Command
{
    protected $signature = 'basketin:setup';

    protected $description = 'Setup the basketin system';

    public function handle()
    {
        $installingCommands = config('basketin.core.commands.installing', []);

        $i = 1;
        $commandCount = count($installingCommands);
        foreach ($installingCommands as $command) {
            $this->info('installation steps [' . $commandCount . '/' . $i . ']');
            $this->call($command);

            $i++;
        }

        $this->info('Installation completed');
    }
}
