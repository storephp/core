<?php

/**
 * This command usless for now.
 */
namespace Store\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CreateEAVTableView extends Command
{
    protected $signature = 'store:eav:tableview';

    protected $description = 'Setup the store system';

    public function handle()
    {
        $prefix = config('store.database.table_prefix');
        $name = $prefix . 'view_eav_attributes';

        DB::statement($this->dropView($name));
        $this->info('dropView...');

        DB::statement($this->createView($name, $prefix));
        $this->info('createView');
    }

    private function dropView($name): string
    {
        return <<<SQL
            DROP VIEW IF EXISTS `$name`;
        SQL;
    }

    private function createView($name, $prefix): string
    {
        return <<<SQL
            CREATE VIEW `$name` AS
            SELECT
                `{$prefix}eav_models`.`model_type` AS `model_type`,
                `{$prefix}eav_models`.`id` AS `model_id`,
                `{$prefix}eav_entities`.`id` AS `entity_id`,
                `{$prefix}eav_values`.`id` AS `value_id`,
                `{$prefix}eav_values`.`store_view_id`,
                `{$prefix}eav_entities`.`entity_key` AS `attribute_key`,
                `{$prefix}eav_values`.`attribute_value` AS `attribute_value`
            FROM
                `{$prefix}eav_models`
            INNER JOIN `{$prefix}eav_attributes` ON `{$prefix}eav_attributes`.`model_id` = `{$prefix}eav_models`.`id`
            INNER JOIN `{$prefix}eav_entities` ON `{$prefix}eav_entities`.`id` = `{$prefix}eav_attributes`.`entity_id`
            INNER JOIN `{$prefix}eav_values` ON `{$prefix}eav_values`.`attribute_id` = `{$prefix}eav_attributes`.`id`
            ORDER BY `store_view_id` DESC
        SQL;
    }
}
