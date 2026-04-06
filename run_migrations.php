<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    // Run all pending migrations
    $migrator = app('migrator');
    $migrator->run(database_path('migrations'));

    echo "Migrations completed successfully!\n";

    // Show migration status
    $ran = $migrator->getRepository()->getRan();
    echo "Ran migrations:\n";
    foreach ($ran as $migration) {
        echo "- $migration\n";
    }

} catch (Exception $e) {
    echo "Migration error: " . $e->getMessage() . "\n";
}