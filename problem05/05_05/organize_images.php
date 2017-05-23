<?php
$dir = new RecursiveIteratorIterator(new RecursiveDirectoryIterator('.'));
$images = new RegexIterator($dir, '/\.(?:jpg|png|gif)$/i');
foreach ($images as $image) {
    $path = $image->getPathname();
    $files[] = $path;
    if ($caption = getIptcCaption($path)) {
        $captions[] = $caption;
    }
}
print_r($captions);

function getIptcCaption($image) {
    if(!getimagesize($image, $info)) {
        return "Can't open $image";
    } else {
        $caption = '';
        if (isset($info['APP13'])) {
            $iptc = iptcparse($info['APP13']);
            if (isset($iptc['2#120'][0])) {
                $caption = $iptc['2#120'][0];
            }
        }
        return $caption;
    }
}