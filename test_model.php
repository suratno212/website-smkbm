<?php

// Test file to check if NilaiModel can be loaded
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR);
define('APPPATH', __DIR__ . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR);
define('ROOTPATH', __DIR__ . DIRECTORY_SEPARATOR);
define('SYSTEMPATH', __DIR__ . DIRECTORY_SEPARATOR . 'system' . DIRECTORY_SEPARATOR);

require_once SYSTEMPATH . 'bootstrap.php';

use App\Models\NilaiModel;

try {
    $model = new NilaiModel();
    echo "NilaiModel loaded successfully!\n";
    echo "Table: " . $model->getTable() . "\n";
} catch (Exception $e) {
    echo "Error loading NilaiModel: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
} 