<?php 
include( dirname( __DIR__, 2 ) . '/config/setup.php' );
$recursos = getDirectory(DEFAULT_ORDER_BY);
var_dump($recursos);