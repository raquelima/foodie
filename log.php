<?php

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;

// Create the logger
$logger = new Logger('my_logger');
// Now add some handlers
$logger->pushHandler(new StreamHandler('./my_app.log', Logger::DEBUG));
$logger->pushHandler(new FirePHPHandler());

// You can now use your logger
$logger->info('My logger is now ready');
