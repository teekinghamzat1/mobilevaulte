<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FixDatabaseAutoIncrement extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:fix-autoincrement';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ensure all database tables have PRIMARY KEY and AUTO_INCREMENT on their id column';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $databaseName = DB::getDatabaseName();
        $this->info("Scanning database '{$databaseName}' for tables with missing AUTO_INCREMENT on 'id'...");

        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        try {
            // Find all tables that have an integer column named 'id' without AUTO_INCREMENT
            $columns = DB::select("
                SELECT TABLE_NAME, COLUMN_NAME, COLUMN_TYPE, DATA_TYPE
                FROM INFORMATION_SCHEMA.COLUMNS
                WHERE TABLE_SCHEMA = ?
                  AND COLUMN_NAME = 'id'
                  AND DATA_TYPE IN ('bigint', 'int', 'mediumint', 'smallint', 'tinyint')
                  AND EXTRA NOT LIKE '%auto_increment%'
            ", [$databaseName]);

            if (empty($columns)) {
                $this->info('All tables already have AUTO_INCREMENT properly configured!');
                DB::statement('SET FOREIGN_KEY_CHECKS=1');
                return 0;
            }

            $this->info('Found ' . count($columns) . ' table(s) needing update:');

            foreach ($columns as $col) {
                $table = $col->TABLE_NAME;
                $type = $col->COLUMN_TYPE;

                $this->line("Processing table: <comment>{$table}</comment> ({$type})...");

                // Check existing primary keys
                $pks = DB::select("SHOW KEYS FROM `{$table}` WHERE Key_name = 'PRIMARY'");

                try {
                    if (empty($pks)) {
                        // Check if there are duplicate IDs
                        $dupes = DB::select("SELECT id, COUNT(*) as c FROM `{$table}` GROUP BY id HAVING c > 1");
                        if (!empty($dupes)) {
                            $this->warn("  Resolving duplicate IDs in {$table}...");
                            $rows = DB::table($table)->get();
                            $seq = 1;
                            foreach ($rows as $row) {
                                DB::table($table)->where('id', $row->id)->limit(1)->update(['id' => $seq++]);
                            }
                        }

                        // Add primary key and auto_increment
                        DB::statement("ALTER TABLE `{$table}` MODIFY `id` {$type} NOT NULL AUTO_INCREMENT PRIMARY KEY");
                        $this->info("  [OK] Added PRIMARY KEY & AUTO_INCREMENT to {$table}.id");
                    } else {
                        $pkCol = $pks[0]->Column_name ?? null;
                        if ($pkCol === 'id') {
                            DB::statement("ALTER TABLE `{$table}` MODIFY `id` {$type} NOT NULL AUTO_INCREMENT");
                            $this->info("  [OK] Enabled AUTO_INCREMENT on {$table}.id");
                        } else {
                            DB::statement("ALTER TABLE `{$table}` ADD INDEX (`id`)");
                            DB::statement("ALTER TABLE `{$table}` MODIFY `id` {$type} NOT NULL AUTO_INCREMENT");
                            $this->info("  [OK] Added INDEX and enabled AUTO_INCREMENT on {$table}.id");
                        }
                    }
                } catch (\Exception $e) {
                    $this->error("  [FAILED] Could not update {$table}: " . $e->getMessage());
                }
            }

            $this->info('Database auto-increment fix completed successfully!');
        } finally {
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        }

        return 0;
    }
}
