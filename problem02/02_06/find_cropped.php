<?php
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
echo $ratio;