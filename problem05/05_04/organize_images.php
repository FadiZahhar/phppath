<?php
$dir = new RecursiveIteratorIterator(new RecursiveDirectoryIterator('.'));
$images = new RegexIterator($dir, '/\.(?:jpg|png|gif)$/i');
foreach ($images as $image) {
    $files[] = $image->getPathname();
}
print_r($files);