<?php
require 'lib/flight/Flight.php';
require 'lib/Collection.class.php';
//require 'lib/Presentation.class.php';
require 'config.php';

Flight::register('db', 'mysqli', [$CONFIG['host'], $CONFIG['user'], $CONFIG['pass'], $CONFIG['db']]);

include_once('lib/Routes.php');

// Start the framework.
Flight::start();

