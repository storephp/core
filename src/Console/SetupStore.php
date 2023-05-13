<?php

namespace Store\Console;

use Illuminate\Console\Command;

class SetupStore extends Command
{
    protected $signature = 'store:setup';

    protected $description = 'Setup the store system';

    public function handle()
    {
        $installingCommands = config('store.core.commands.installing', []);

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
