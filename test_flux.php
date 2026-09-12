<?php

use Illuminate\Contracts\Console\Kernel;

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

echo class_exists('Flux\Flux') ? 'Yes Flux' : 'No Flux';
