<?php
$start = microtime(true);

define('BOARD_SIZE', 8);

$end = microtime(true);
echo 'Time taken: ' . ($end - $start) . ' seconds';