<?php
require 'lib/flight/Flight.php';
require 'lib/Collection.class.php';
if(is_file('config.php')) { require 'config.php'; }
else { die('Config file does not exist'); }

Flight::register('db', 'mysqli', [$CONFIG['host'], $CONFIG['user'], $CONFIG['pass'], $CONFIG['db']]);

include_once('lib/Routes.php');

// Start the framework.
Flight::start();

