<?php
ini_set('max_execution_time', 0);
$start = microtime(true);

require_once 'Foundationphp/ImageHandling/Scale.php';

use Foundationphp\ImageHandling\Scale;

$version = phpversion();
if ($version >= '5.5.0') {
    define('CAN_FLIP', true);
} else {
    define('CAN_FLIP', false);
}

// Image folders
$imageDir = 'originals';
$scaledDir = 'scaled';
$flippedDir = 'mirror';
$matchedDir = 'pirated';

// Files and dimensions
$files = array();
$widths = array();
$heights = array();

$dir = new DirectoryIterator($imageDir);
$images = new RegexIterator($dir, '/\.jpg$/i');
foreach ($images as $image) {
    $filename = $image->getFilename();
    $files[] = $filename;
    list($widths[], $heights[]) = getimagesize($imageDir . '/' . $filename);
}
$smallest = min(array_merge($widths, $heights));
$ratio = round(25 / $smallest, 2);
unset($widths);
unset($heights);

$resized = array();
try {
    for ($i = 0; $i < count($files); $i++) {
        if (CAN_FLIP) {
            $scaled = new Scale($files[$i], true, $flippedDir);
        } else {
            $scaled = new Scale($files[$i]);
        }
        $scaled->setSourceFolder($imageDir);
        $scaled->setRatio($ratio);
        $scaled->create();
        $resized[$i]['name'] = $files[$i];
        list($resized[$i]['w'], $resized[$i]['h']) =
            getimagesize($scaledDir . '/'. $files[$i]);
    }
    unset($files);
} catch (Exception $e) {
    echo $e->getMessage();
}

$end = microtime(true);
echo '<p>Time taken: ' . ($end - $start) . ' seconds.</p>';