<?php

namespace Basketin\Console;

use Basketin\Models\Order\State;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class FillStateStatusOrders extends Command
{
    public function handle()
    {
        $states = ['New', 'Pendding', 'On Hold', 'Complete', 'Closed', 'Canceled'];

        foreach ($states as $state) {
            $key = Str::slug($state, '_');

            if (!State::where('state_key', $key)->exists()) {
                State::create([
                    'state_key' => $key,
                    'state_label' => $state,
                ])->status()->create([
                    'status_key' => $key,
                    'status_label' => $state,
                ]);
            }
        }

        $this->info('Has been filled status');
    }
}
