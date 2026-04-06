<?php

// Simple script to create basic tables needed for the application
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    $pdo = DB::connection()->getPdo();

    // Create sessions table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `sessions` (
            `id` varchar(255) NOT NULL,
            `user_id` bigint(20) unsigned DEFAULT NULL,
            `ip_address` varchar(45) DEFAULT NULL,
            `user_agent` text DEFAULT NULL,
            `payload` longtext NOT NULL,
            `last_activity` int(11) NOT NULL,
            PRIMARY KEY (`id`),
            KEY `sessions_user_id_index` (`user_id`),
            KEY `sessions_last_activity_index` (`last_activity`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");

    // Create cache table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `cache` (
            `key` varchar(255) NOT NULL,
            `value` mediumtext NOT NULL,
            `expiration` int(11) NOT NULL,
            PRIMARY KEY (`key`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");

    // Create diskons table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `diskons` (
            `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            `kode_diskon` varchar(255) NOT NULL,
            `keterangan` text NOT NULL,
            `tipe_diskon` enum('persen','nominal') NOT NULL,
            `nilai` decimal(10,2) NOT NULL,
            `minimum_belanja` decimal(15,2) NOT NULL DEFAULT '0.00',
            `berlaku_sampai` date NOT NULL,
            `is_active` tinyint(1) NOT NULL DEFAULT '1',
            `created_at` timestamp NULL DEFAULT NULL,
            `updated_at` timestamp NULL DEFAULT NULL,
            PRIMARY KEY (`id`),
            UNIQUE KEY `diskons_kode_diskon_unique` (`kode_diskon`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");

    echo "Basic tables created successfully!\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}